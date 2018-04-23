<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Face extends CI_Controller
{
    public $key = 'hW4M6KzZ7cRsilSImHylXpX93kTNWB7V';
    public $secret = 'hvDGckrQKQgDzFdMFcBA0LivPq3RxpXW';
    public function detect()
    {
        $url = 'https://api-cn.faceplusplus.com/facepp/v3/detect';

        $param = array(
            'api_key' => $this->key,
            'api_secret' => $this->secret,
            'image_url' => 'http://oracle.pagecp.com/img/tou.jpg',
        );
        echo json_encode($param);
        $this->load->model('Curl_model');
        $res = $this->Curl_model->curl_post($url, $param);
        echo json_encode($res);
    }
}
