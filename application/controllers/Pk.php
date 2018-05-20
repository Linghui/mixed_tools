<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pk extends CI_Controller
{
    public function index()
    {
        $this->load->model('Curl_model');
        $content = $this->Curl_model->curl_get('http://www.aa35.com/Pk10/date_2018-05-18_pagesize_180.html');
        echo "content\n";
        echo $content;
        echo "\n";
        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        $list = $dom->getElementById('NumList');
        foreach ($list->getElementsByTagName('tr') as $row) {
            $cols = $row->getElementsByTagName('td');
            echo 'order '.$cols[0]->nodeValue;
            echo "\n";
        }
    }
}
