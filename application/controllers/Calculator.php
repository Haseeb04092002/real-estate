<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller
{
    public function calculator()
    {
        // $data[] = "answer";
        $area = $this->input->post('area') ?? '';
        $from = $this->input->post('from_unit') ?? '';
        $to = $this->input->post('to_unit') ?? '';

        $sqftPerMarla = 272.25;
        $marlaPerKanal = 20;
        $sqftPerSqyd = 9;

        switch ($from) {

            case "sqft":
                $sqft = $area;
                break;

            case "sqyd":
                $sqft = $area * $sqftPerSqyd;
                break;

            case "marla":
                $sqft = $area * $sqftPerMarla;
                break;

            case "kanal":
                $sqft = $area * $marlaPerKanal * $sqftPerMarla;
                break;

            default:
                $sqft = 0;
        }

        $sqyd = $sqft / $sqftPerSqyd;
        $marla = $sqft / $sqftPerMarla;
        $kanal = $marla / $marlaPerKanal;

        if ($to == "sqyd") {
            echo json_encode($sqyd);
            exit();
        } elseif ($to == "marla") {
            echo json_encode($marla);
            exit();
        } elseif ($to == "kanal") {
            echo json_encode($kanal);
            exit();
        } elseif ($to == "sqft") {
            echo json_encode($sqft);
            exit();
        }

        // $data['area'] = $area;
        // $data['from'] = $from;
        // $data['to'] = $to;
        // echo json_encode($data);
    }
}
