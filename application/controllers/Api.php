<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function search()
    {
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $jobs = $this->cache->get('jobs');
        if (!$jobs) {
            $this->Output_model->json_print(1, 'no data');
        }
        $db_id = $from.'_'.$to;
        if (!isset($jobs[$db_id])) {
            $this->Output_model->json_print(1, 'no data');
        }

        $this->Log_model->log('job', 'search job');

        $this->Output_model->json_print(0, 'ok', $jobs[$db_id]);
    }
}
