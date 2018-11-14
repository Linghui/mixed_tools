<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pk extends CI_Controller
{
    public $map = array(
        'pk-no1' => 1,
        'pk-no2' => 2,
        'pk-no3' => 3,
        'pk-no4' => 4,
        'pk-no5' => 5,
        'pk-no6' => 6,
        'pk-no7' => 7,
        'pk-no8' => 8,
        'pk-no9' => 9,
        'pk-no10' => 10,
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->load->model('Pk_model');
    }
    public function index()
    {
        // $time = time();
        $time = strtotime('2016-07-27 1:00:00');

        $counter = 0;
        while (true) {
            $year = date('Y', $time);
            $month = date('m', $time);
            $day = date('d', $time);

            echo "date_str $year $month $day ";

            $res = $this->deal_day($year, $month, $day);
            $time -= 60 * 60 * 24;

            if (!$res) {
                ++$counter;
                if ($counter > 10) {
                    break;
                }
            } else {
                $counter = 0;
            }
        }
    }

    private function deal_day($year, $month, $day)
    {
        $record = $this->cache->get('record');
        if (!$record) {
            $record = array();
        }

        $date_str = "$year-$month-$day";

        if (isset($record[$date_str])) {
            echo "added before\n";

            return true;
        }

        $this->load->model('Curl_model');
        $content = $this->Curl_model->curl_get("http://www.aa35.com/Pk10/Index_NumList.php?SearchDate=$date_str&PageSize=180&ShowModelNum=1&t=0.33283237762907");
        // $content = $this->Curl_model->curl_get('http://www.aa35.com/Pk10/Index_NumList.php?SearchDate=2016-8-17&PageSize=180&ShowModelNum=1&t=0.33283237762907');
        // echo "content\n";
        // echo $content;
        // echo "\n";
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
        $row_counter = 0;
        foreach ($dom->getElementsByTagName('table') as $tbody) {
            foreach ($tbody->getElementsByTagName('tr') as $row) {
                $cols = $row->getElementsByTagName('td');
                if ($cols && isset($cols[0])) {
                    $order_no = $cols[0]->nodeValue;
                    $time = $cols[1]->nodeValue;

                    // echo "time str $time\n";

                    $time = strtotime($year.'-'.$time);

                    $data = array(
                            'order_no' => $order_no,
                            'open_date' => $time,
                        );

                    // echo 'cols 2 '.$cols[2]->nodeValue."\n";

                    $i = $cols[2]->getElementsByTagName('i');

                    $index = 1;
                    foreach ($i as $one) {
                        $class = $one->getAttribute('class');
                        $data['c'.($index)] = $this->map[$class];
                        ++$index;
                    }

                    $this->Pk_model->add($data);
                    ++$row_counter;
                }
            }

            if ($row_counter == 0) {
                echo "not found\n";

                return false;
            }
            break;
        }

        echo "$row_counter 组\n";
        $record[$date_str] = $row_counter;
        $this->cache->save('record', $record, 60 * 60 * 24 * 365);

        return true;
    }

    public function b_or_s()
    {
        $all = $this->Pk_model->get_by_condition_array();
        $category = array();
        foreach ($all as $one) {
            $open_date = $one['open_date'];
            $date = date('Y-m-d', $open_date);

            if (!isset($category[$date])) {
                $category[$date] = array();
            }

            for ($i = 1; $i <= 10; ++$i) {
                if ($one["c$i"] <= 5) {
                    if (!isset($category[$date]["c$i"])) {
                        $category[$date]["c$i"] = 0;
                    }
                    ++$category[$date]["c$i"];
                }

                if (!isset($category[$date]["tc$i"])) {
                    $category[$date]["tc$i"] = 0;
                }
                ++$category[$date]["tc$i"];
            }

            // array_push($category[$date], $row);
        }

        // echo json_encode($category);


        foreach ($category as $date => $data_set) {
            echo "$date ";
            for ($i = 1; $i <= 10; ++$i) {
                if (isset($data_set["c$i"]) && isset($data_set["tc$i"])) {
                    echo round($data_set["c$i"] * 100 / $data_set["tc$i"], 1).' ';
                } else {
                    echo '00 ';
                }
            }
            echo "\n";
        }
    }

    public function all()
    {
        $all = $this->Pk_model->get_by_condition_array();
        foreach ($all as $row) {
            echo $row['order_no'];
            echo ",";
            echo date("Y-m-d h:i", $row['open_date']);
            echo ",";
            for ($i=1; $i <=10 ; $i++) {
                echo $row['c'.$i];
                echo ",";
            }
            echo "\n";
        }
    }

    public function test()
    {
        // $this->load->model('Pk_model');
        // $data = array(
        //     'order_no' => 1,
        //     'open_date' => 11111,
        //     'c1' => 1,
        //     'c2' => 1,
        //     'c3' => 1,
        //     'c4' => 1,
        //     'c5' => 1,
        //     'c6' => 1,
        //     'c7' => 1,
        //     'c8' => 1,
        //     'c9' => 1,
        //     'c10' => 1,
        // );
        // $this->Pk_model->add($data);

        // $this->cache->save('test', 'test');
        // echo $this->cache->get('test');
    }
}
