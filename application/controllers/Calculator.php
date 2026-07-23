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
            $answer = $sqyd . ' Sqyd';
            echo json_encode($answer);
            exit();
        } elseif ($to == "marla") {
            $answer = $marla . ' Marla';
            echo json_encode($answer);
            exit();
        } elseif ($to == "kanal") {
            $answer = $kanal . ' Kanal';
            echo json_encode($answer);
            exit();
        } elseif ($to == "sqft") {
            $answer = $sqft . ' Sqft';
            echo json_encode($answer);
            exit();
        }

        // $data['area'] = $area;
        // $data['from'] = $from;
        // $data['to'] = $to;
        // echo json_encode($data);
    }
}
