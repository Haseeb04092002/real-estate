<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller
{
    public function calculator(array $data)
    {
        $data[] = "answer";
        return $data;
    }
}
