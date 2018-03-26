<?php

class Jpush_model extends CI_Model
{
    private $app_key = '';
    private $master_secret = '';
    private $url = 'https://api.jpush.cn/v3/push';

    /*  $receiver 接收者的信息
        all 字符串 该产品下面的所有用户. 对app_key下的所有用户推送消息
        tag(20个)Array标签组(并集): tag=>array('昆明','北京','曲靖','上海');
        tag_and(20个)Array标签组(交集): tag_and=>array('广州','女');
        alias(1000)Array别名(并集): alias=>array('93d78b73611d886a74*****88497f501','606d05090896228f66ae10d1*****310');
        registration_id(1000)注册ID设备标识(并集): registration_id=>array('20effc071de0b45c1a**********2824746e1ff2001bd80308a467d800bed39e');
    */
    //$content 推送的内容。
    //$m_type 推送附加字段的类型(可不填) http,tips,chat....
    //$m_txt 推送附加字段的类型对应的内容(可不填) 可能是url,可能是一段文字。
    //$m_time 保存离线时间的秒数默认为一天(可不传)单位为秒
    private function push($receiver = 'all', $content = '', $m_type = '', $m_txt = '', $m_time = '86400')
    {
        $base64 = base64_encode("$this->app_key:$this->master_secret");
        $header = array("Authorization:Basic $base64",'Content-Type:application/json');
        $data = array();
        $data['platform'] = 'all';          //目标用户终端手机的平台类型android,ios,winphone
        $data['audience'] = $receiver;      //目标用户

        $data['notification'] = array(
            //统一的模式--标准模式
            'alert' => $content,
            //安卓自定义
            'android' => array(
                'alert' => $content,
                'title' => '',
                'builder_id' => 1,
                'extras' => array('type' => $m_type, 'txt' => $m_txt),
            ),
            //ios的自定义
            'ios' => array(
                'alert' => $content,
                'extras' => array('type' => $m_type, 'txt' => $m_txt),
            ),
        );

       //苹果自定义---为了弹出值方便调测
        $data['message'] = array(
            'msg_content' => $content,
            'extras' => array('type' => $m_type, 'txt' => $m_txt),
        );

        //附加选项
        $data['options'] = array(
            'sendno' => time(),
            'time_to_live' => $m_time, //保存离线时间的秒数默认为一天
            'apns_production' => 1,        //指定 APNS 通知发送环境：0开发环境，1生产环境。
        );
        $param = json_encode($data);
        $res = $this->push_curl($param, $header);
        log_message('error', "Jpush debug $res ".json_encode($content));
        if ($res) {       //得到返回值--成功已否后面判断
            return $res;
        } else {          //未得到返回值--返回失败
            return false;
        }
    }

    //推送的Curl方法
    private function push_curl($param = '', $header = '')
    {
        if (empty($param)) {
            return false;
        }
        $postUrl = $this->url;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL, $postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);           // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);

        return $data;
    }
}
