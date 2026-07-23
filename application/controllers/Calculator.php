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
        $data['area'] = $area;
        $data['from'] = $from;
        $data['to'] = $to;
        echo json_encode($data);
    }
}
