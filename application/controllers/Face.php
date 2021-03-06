<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Face extends CI_Controller
{
    public $key = 'hW4M6KzZ7cRsilSImHylXpX93kTNWB7V';
    public $secret = 'hvDGckrQKQgDzFdMFcBA0LivPq3RxpXW';

    // release
    // public $key = 'qoHuLwbh8-02hliI28d3HjGUVjLZUYOm';
    // public $secret = 'RVD_niLlp-Xco4qmKm0SJeBZ9Zxw1K9C';

    public function detect()
    {
        $url = 'https://api-cn.faceplusplus.com/facepp/v3/detect';

        $param = array(
            'api_key' => $this->key,
            'api_secret' => $this->secret,
            'image_url' => 'http://ora_inter.pagecp.com/img/bg.jpg',
        );
        $this->load->model('Curl_model');
        $res = $this->Curl_model->curl_post($url, $param);

        echo json_encode($res);
    }

    public function merge()
    {
        $url = 'https://api-cn.faceplusplus.com/imagepp/v1/mergeface';

        $param = array(
            'api_key' => $this->key,
            'api_secret' => $this->secret,
            'template_url' => 'http://ora_inter.pagecp.com/img/bg3.jpg',
            'merge_url' => 'http://ora_inter.pagecp.com/img/g8.jpg',
            'template_rectangle' => '271,315,218,218',
            'merge_rate' => '70',
        );
        $this->load->model('Curl_model');
        $res = $this->Curl_model->curl_post($url, $param);

        $res = json_decode($res);

        file_put_contents('img/res.jpg', base64_decode($res->result));
        echo '<a href="/img/res.jpg">结果图片</a>';
    }
}
