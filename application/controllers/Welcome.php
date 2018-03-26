<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->view('example');
    }
    public function version()
    {
        echo CI_VERSION;
    }

    public function api()
    {
        $this->Output_model->json_print(0, 'ok');
    }
}
