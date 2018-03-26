<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function search()
    {
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        
        $this->Output_model->json_print(0, 'ok');
    }
}
