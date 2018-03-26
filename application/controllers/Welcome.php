<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
        echo "interview";
    }
    public function version()
    {
        echo CI_VERSION;
    }

    public function example()
    {
        $this->load->view('example');
    }

    public function api()
    {
        $this->Output_model->json_print(0, 'ok');
    }
}
