<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public $tables = array('表1','表2','表3','表4','表5','表6','表7','表8','表9');

    public function index()
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $databases = $this->cache->get('databases');
        if (!$databases) {
            $databases = array();
        }
        $data = array('databases' => $databases);

        $this->load->view('migration', $data);
    }

    public function new_database()
    {
        $this->load->view('new_database');
    }

    public function add_database()
    {
        $database_name = $this->input->get_post('database_name');
        $database_address = $this->input->get_post('database_address');
        $username = $this->input->get_post('username');
        $password = $this->input->get_post('password');

        if (!$database_name || !$database_address || !$username || !$password) {
            return;
        }

        // do some database check here to make sure database configration works
        $res = $this->database_check($database_name, $database_address, $username, $password);
        if ($res) {
            $this->add_database_to_store($database_name, $database_address, $username, $password);
            $this->load->helper('url');
            redirect('/', 'location', 301);
        } else {
            $this->load->view('add_database_fail');
        }
    }

    private function database_check($database_name, $database_address, $username, $password)
    {
        // fake checks
        //

        return true;
    }

    private function add_database_to_store($database_name, $database_address, $username, $password)
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $databases = $this->cache->get('databases');
        if (!$databases) {
            $databases = array();
        }
        $new_one = array(
            'database_name' => $database_name,
            'database_address' => $database_address,
            'username' => $username,
            'password' => $password,
        );

        $databases[] = $new_one;

        $this->cache->save('databases', $databases, 3600 * 24 * 7);
    }

    public function new_mig()
    {
        $from = $this->input->get('from');
        $to = $this->input->get('to');

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $databases = $this->cache->get('databases');

        $from_database = $databases[$from];
        $from_database['id'] = $from;

        $to_database = $databases[$to];
        $to_database['id'] = $to;

        $data = array(
            'from_database' => $from_database,
            'to_database' => $to_database,
            'tables' => $this->tables,
        );

        $this->load->view('new_mig', $data);
    }

    public function add_mig()
    {
        $from = $this->input->get('from');
        $to = $this->input->get('to');
        $tables = $this->input->get('tables');

        $pieces = explode(',', $tables);
        foreach ($pieces as $table_id) {
            $table_name = $this->tables[$table_id];
            $db_id = $from.'_'.$to;
            $job = array(

                'table_name' => $table_name,
                'create_date' => time(),
                'status' => rand(0, 100),
            );

            $this->add_job($db_id, $job);
        }

        $this->load->helper('url');
        redirect('/', 'location', 301);
    }

    private function add_job($db_id, $job)
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $jobs = $this->cache->get('jobs');
        if (!$jobs) {
            $jobs = array();
        }

        if (isset($jobs[$db_id])) {
            $job_set = $jobs[$db_id];
        } else {
            $job_set = array();
        }

        $job_set[] = $job;

        $jobs[$db_id] = $job_set;

        $jobs = $this->cache->save('jobs', $jobs, 3600 * 24 * 7);
    }

    // useless
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
