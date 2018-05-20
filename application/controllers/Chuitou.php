<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Chuitou extends CI_Controller
{
    public function index()
    {
        $this->load->view('main');
    }

    public function api()
    {
        $big = $this->input->get('big');
        $small = $this->input->get('small');
        if (!$big || !$small) {
            $this->Output_model->json_print(1, '没有数据输入');

            return;
        }

        $big = explode(',', $big);
        if (!$big || gettype($big) != 'array') {
            $this->Output_model->json_print(1, '大锤头数据格式不对');

            return;
        }

        if (count($big) != 10) {
            $this->Output_model->json_print(1, '大锤头数字不是10个 '.(count($big)) - 10);

            return;
        }

        $small = explode(',', $small);
        if (!$small || gettype($small) != 'array') {
            $this->Output_model->json_print(1, '小锤头数据格式不对');

            return;
        }

        if (count($small) != 18) {
            $this->Output_model->json_print(1, '小锤头数字不是10个 '.(count($small)) - 18);

            return;
        }

        // $big = array(90.6,90.8,95.6,96.2,96.6,97.4,101.6,101.8,102.4,109.8);
        // $small = array(55,55.4,55.6,55.6,55.8,56,56.2,56.4,56.4,56.6,56.8,57,57.2,57.4,57.4,57.6,57.6,58);
        sort($big);
        sort($small);

        // echo 'big, '.json_encode($big);
        // echo "\n";
        // echo 'big, avg '.$this->avg($big);
        // echo "\n";

        // echo 'small, '.json_encode($small);
        // echo "\n";
        // echo 'small, avg '.$this->avg($small);
        // echo "\n";

        $found_key = false;
        $smallest = false;
        $group_1 = $big[0] + $big[9];

        for ($i = 1; $i < count($big) - 1; ++$i) {
            for ($j = $i + 1; $j < count($big) - 1; ++$j) {
                $temp = $big[$i] + $big[$j];
                $cha_he[$i.'_'.$j] = $temp;
            }
        }

        foreach ($cha_he as $key => $value) {
            if (!$found_key) {
                $found_key = $key;
            }
            if (!$smallest) {
                $smallest = abs($value - $group_1);
            } else {
                $temp = $value - $group_1;
                // echo "temp $temp\n";
                if (abs($temp) < $smallest) {
                    $found_key = $key;
                    $smallest = abs($temp);
                }
            }
        }

        // echo "smallest $smallest\n";
        $line_1_2_min = $smallest;
        // echo "found key $found_key \n";
        list($index_1, $index_2) = explode('_', $found_key);
        $sub_big = array();
        $sub_big_index_map = array();
        for ($i = 0; $i < count($big); ++$i) {
            if ($i == 0 || $i == 9 || $i == $index_1 || $i == $index_2) {
                continue;
            }
            $sub_big[] = $big[$i];
            $sub_big_index_map[''.(count($sub_big) - 1)] = $i;
        }
        // echo json_encode($sub_big);
        // echo "\n";

        $total = $this->sum($sub_big);

        $sub_index_1 = 0;
        $sub_index_2 = 1;
        $sub_index_3 = 2;
        $smallest = false;

        for ($i = 0; $i < count($sub_big); ++$i) {
            for ($j = $i + 1; $j < count($sub_big); ++$j) {
                for ($h = $j + 1; $h < count($sub_big); ++$h) {
                    $sub_sum = $sub_big[$i] + $sub_big[$j] + $sub_big[$h];
                    $temp = abs($total - $sub_sum * 2);
                    // echo "temp $i $j $h $temp\n";
                    if (!$smallest) {
                        $smallest = $temp;
                    } else {
                        if ($temp < $smallest) {
                            $smallest = $temp;
                            $sub_index_1 = $i;
                            $sub_index_2 = $j;
                            $sub_index_3 = $h;
                        }
                    }
                }
            }
        }

        $big_index_map_1 = $sub_big_index_map[$sub_index_1];
        $big_index_map_2 = $sub_big_index_map[$sub_index_2];
        $big_index_map_3 = $sub_big_index_map[$sub_index_3];

        // echo "sub 1 2 3 $big_index_map_1 ,$big_index_map_2, $big_index_map_3 $smallest\n";
        $line_3_4_min = $smallest;

        $line_1_sum = $big[0] + $big[9];
        // echo 'line 1 big 0,9 '.$big[0].' '.$big[9].' sum '.($line_1_sum);
        // echo "\n";
        $line_2_sum = $big[$index_1] + $big[$index_2];
        // echo "line 2 big $index_1, $index_2 ".$big[$index_1].' '.$big[$index_2].' sum '.($line_2_sum);
        // echo "\n";

        // echo "line 3 big $big_index_map_1 ,$big_index_map_2, $big_index_map_3 ".$big[$big_index_map_1].' '.$big[$big_index_map_2].' '.$big[$big_index_map_3];
        $line_3_sum = $big[$big_index_map_1] + $big[$big_index_map_2] + $big[$big_index_map_3];
        // echo ' sum '.($line_3_sum);
        // echo "\n";

        $left_index = array();
        for ($i = 0; $i < count($big); ++$i) {
            if ($i == 0 || $i == 9 || $i == $index_1 || $i == $index_2 || $i == $big_index_map_1 || $i == $big_index_map_2 || $i == $big_index_map_3) {
                continue;
            }
            $left_index[] = $i;
        }

        // echo "line 3 big $left_index[0] ,$left_index[1], $left_index[2] ".$big[$left_index[0]].' '.$big[$left_index[1]].' '.$big[$left_index[2]];

        $line_4_sum = $big[$left_index[0]] + $big[$left_index[1]] + $big[$left_index[2]];
        // echo 'last sum '.($line_4_sum);
        // echo "\n";

        $set = $this->julizi4($small);

        $big_bigger_cha = 0;
        $big_smaller_cha = 0;

        $final_line_1 = array();

        $final_line_2 = array();

        if ($line_1_sum > $line_2_sum) {
            $final_line_1[] = $big[0];
            $final_line_1[] = $big[9];

            $final_line_2[] = $big[$index_1];
            $final_line_2[] = $big[$index_2];
        } else {
            $final_line_1[] = $big[$index_1];
            $final_line_1[] = $big[$index_2];

            $final_line_2[] = $big[0];
            $final_line_2[] = $big[9];
        }

        $final_line_3 = array();

        $final_line_4 = array();

        if ($line_3_sum > $line_4_sum) {
            $final_line_3[] = $big[$big_index_map_1];
            $final_line_3[] = $big[$big_index_map_2];
            $final_line_3[] = $big[$big_index_map_3];

            $final_line_4[] = $big[$left_index[0]];
            $final_line_4[] = $big[$left_index[1]];
            $final_line_4[] = $big[$left_index[2]];
        } else {
            $final_line_3[] = $big[$left_index[0]];
            $final_line_3[] = $big[$left_index[1]];
            $final_line_3[] = $big[$left_index[2]];

            $final_line_4[] = $big[$big_index_map_1];
            $final_line_4[] = $big[$big_index_map_2];
            $final_line_4[] = $big[$big_index_map_3];
        }

        if ($line_1_2_min > $line_3_4_min) {
            $big_bigger_cha = $line_1_2_min;
            $big_smaller_cha = $line_3_4_min;
        } else {
            $big_bigger_cha = $line_3_4_min;
            $big_smaller_cha = $line_1_2_min;
        }

        // echo  "big_bigger_cha $big_bigger_cha\n";
        // echo  "big_small_cha $big_smaller_cha\n";

        $smallest = false;
        $smallest_f4_group = false;
        $smallest_last_f4_group = false;
        $left_10 = false;
        $counter = 1;

        $tt_over = false;
        foreach ($set as $row) {
            $f4 = $row['f4'];
            $rest = $row['rest'];
            $last_set = $this->julizi4($rest);

            foreach ($last_set as $row_2) {
                ++$counter;
                // echo "counter $counter\n";
                $last_f4 = $row_2['f4'];
                $last_rest = $row_2['rest'];

                $f4_sum = $this->sum($f4);
                $last_f4_sum = $this->sum($last_f4);

                $temp1 = abs(round($f4_sum - $last_f4_sum, 2));

                // echo "temp1 $temp1 $big_bigger_cha\n";
                $tttt = abs(round($temp1 -  $big_bigger_cha, 2));
                // echo "tttt 1 $tttt\n";

                if (!$smallest) {
                    $smallest = $tttt;
                    $smallest_f4_group = $f4;
                    $smallest_last_f4_group = $last_f4;
                    $left_10 = $last_rest;
                } elseif ($tttt == 0) {
                    $smallest = $tttt;
                    $smallest_f4_group = $f4;
                    $smallest_last_f4_group = $last_f4;
                    $left_10 = $last_rest;
                    $tt_over = true;
                    break;
                } elseif ($tttt < $smallest) {
                    $smallest = $tttt;

                    $smallest_f4_group = $f4;
                    $smallest_last_f4_group = $last_f4;
                    $left_10 = $last_rest;
                }
            }

            if ($tt_over) {
                break;
            }
        }

        // echo 'f4 '.json_encode($smallest_f4_group).' sum '.$this->sum($smallest_f4_group);
        // echo "\n";

        // echo 'last_f4 '.json_encode($smallest_last_f4_group).' sum '.$this->sum($smallest_last_f4_group);
        // echo "\n";
        $cha = $this->sum($smallest_f4_group) - $this->sum($smallest_last_f4_group);

        // echo 'cha '.($cha);
        // echo "\n";

        if ($cha < 0) {
            $final_line_3 = array_merge($final_line_3, $smallest_f4_group);
            $final_line_4 = array_merge($final_line_4, $smallest_last_f4_group);
        } else {
            $final_line_3 = array_merge($final_line_3, $smallest_last_f4_group);
            $final_line_4 = array_merge($final_line_4, $smallest_f4_group);
        }

        // echo 'last_rest '.json_encode($left_10);
        // echo "\n";

        $final_set = $this->julizi5($left_10);
        // echo json_encode($final_set);
        // echo "\n";

        $smallest = false;
        $smallest_f5_group = false;
        $smallest_last_f5_group = false;

        foreach ($final_set as $row) {
            $f5 = $row['f5'];
            $rest = $row['rest'];

            $sum = $this->sum($f5);
            $sum_rest = $this->sum($rest);

            $temp1 = abs(round($sum - $sum_rest, 2));

            // echo "temp1 $temp1 $big_smaller_cha\n";
            $tttt = abs(round($temp1 -  $big_smaller_cha));

            if (!$smallest) {
                $smallest = $tttt;
                $smallest_f5_group = $f5;
                $smallest_last_f5_group = $rest;
            } elseif ($tttt == 0) {
                $smallest = $tttt;
                $smallest_f5_group = $f5;
                $smallest_last_f5_group = $rest;
                break;
            } elseif ($tttt < $smallest) {
                $smallest = $tttt;

                $smallest_f5_group = $f5;
                $smallest_last_f5_group = $rest;
            }
        }

        $last_sum_1 = $this->sum($smallest_f5_group);

        // echo 'f5 '.json_encode($smallest_f5_group).' sum '.$last_sum_1;
        // echo "\n";

        $last_sum_2 = $this->sum($smallest_last_f5_group);

        // echo 'last_f5 '.json_encode($smallest_last_f5_group).' sum '.$last_sum_2;
        // echo "\n";

        $cha = $last_sum_1 - $last_sum_2;
        // echo 'last '.($cha);
        // echo "\n";

        if ($cha < 0) {
            $final_line_1 = array_merge($final_line_1, $smallest_f5_group);
            $final_line_2 = array_merge($final_line_2, $smallest_last_f5_group);
        } else {
            $final_line_1 = array_merge($final_line_1, $smallest_last_f5_group);
            $final_line_2 = array_merge($final_line_2, $smallest_f5_group);
        }
        // echo "final\n";
        // echo "line 1 " . json_encode($final_line_1) . " " . $this->sum($final_line_1);
        // echo "\n";
        // echo "line 2 " . json_encode($final_line_2). " " . $this->sum($final_line_2);
        // echo "\n";
        // echo "line 3 " . json_encode($final_line_3). " " . $this->sum($final_line_3);
        // echo "\n";
        // echo "line 4 " . json_encode($final_line_4). " " . $this->sum($final_line_4);
        // echo "\n";

        $html = json_encode($final_line_1).' '.$this->sum($final_line_1);
        $html .= '<br/>';
        $html .= json_encode($final_line_2).' '.$this->sum($final_line_2);
        $html .= '<br/>';
        $html .= json_encode($final_line_3).' '.$this->sum($final_line_3);
        $html .= '<br/>';
        $html .= json_encode($final_line_4).' '.$this->sum($final_line_4);
        $html .= '<br/>';

        $this->Output_model->json_print(0, 'ok', $html);
    }

    private function s($n = 3)
    {
        if ($n == 2) {
            return 1;
        } else {
            return $this->s($n - 1) + ($n - 1);
        }
    }

    public function e()
    {
        echo $this->s(30);
        echo "\n";
    }

    public function zhao()
    {
        $n = 5;
        $num = 3;
        $c1 = $this->chengjie($n, $num);
        $c2 = $this->chengjie($num);
        echo "c1 $c1, c2 $c2\n";

        echo $this->chengjie($n, $num) / $this->chengjie($num);
        echo "\n";
    }

    public function chengjie($n, $end = false)
    {
        if ($end && $n == ($n - $end + 1)) {
            return $n;
        } elseif ($n == 1) {
            return 1;
        } else {
            return $this->chengjie($n - 1) * $n;
        }
    }

    public function ce()
    {
        echo $this->chengjie(6);
        echo "\n";
    }

    public function julizi3($array)
    {
        $res = array();
        for ($i = 0; $i < count($array); ++$i) {
            for ($j = $i + 1; $j < count($array); ++$j) {
                for ($h = $j + 1; $h < count($array); ++$h) {
                    $t_n_1 = $array[$i];
                    $t_n_2 = $array[$j];
                    $t_n_3 = $array[$h];

                    $rest = array();

                    for ($ti = 0; $ti < count($array); ++$ti) {
                        if ($ti == $i || $ti == $j || $ti == $h) {
                            continue;
                        }
                        $rest[] = $array[$ti];
                    }

                    $sub_small = array(
                                'f3' => array($t_n_1,$t_n_2,$t_n_3),
                                'rest' => $rest,
                            );

                    $res[] = $sub_small;
                }
            }
        }

        return $res;
    }

    public function julizi4($array)
    {
        $res = array();
        for ($i = 0; $i < count($array); ++$i) {
            for ($j = $i + 1; $j < count($array); ++$j) {
                for ($h = $j + 1; $h < count($array); ++$h) {
                    for ($k = $h + 1; $k < count($array); ++$k) {
                        $t_n_1 = $array[$i];
                        $t_n_2 = $array[$j];
                        $t_n_3 = $array[$h];
                        $t_n_4 = $array[$k];

                        $rest = array();

                        for ($ti = 0; $ti < count($array); ++$ti) {
                            if ($ti == $i || $ti == $j || $ti == $h || $ti == $k) {
                                continue;
                            }
                            $rest[] = $array[$ti];
                        }

                        $sub_small = array(
                            'f4' => array($t_n_1,$t_n_2,$t_n_3,$t_n_4),
                            'rest' => $rest,
                        );

                        $res[] = $sub_small;
                    }
                }
            }
        }
        // echo 'count '.count($res);
        // echo "\n";
        // echo json_encode($res);
        // echo "\n";

        return $res;
    }

    public function julizi5($array)
    {
        $res = array();
        for ($i = 0; $i < count($array); ++$i) {
            for ($j = $i + 1; $j < count($array); ++$j) {
                for ($h = $j + 1; $h < count($array); ++$h) {
                    for ($k = $h + 1; $k < count($array); ++$k) {
                        for ($l = $k + 1; $l < count($array); ++$l) {
                            $t_n_1 = $array[$i];
                            $t_n_2 = $array[$j];
                            $t_n_3 = $array[$h];
                            $t_n_4 = $array[$k];
                            $t_n_5 = $array[$l];

                            $rest = array();

                            for ($ti = 0; $ti < count($array); ++$ti) {
                                if ($ti == $i || $ti == $j || $ti == $h || $ti == $k || $ti == $l) {
                                    continue;
                                }
                                $rest[] = $array[$ti];
                            }

                            $sub_small = array(
                                    'f5' => array($t_n_1,$t_n_2,$t_n_3,$t_n_4,$t_n_5),
                                    'rest' => $rest,
                                );

                            $res[] = $sub_small;
                        }
                    }
                }
            }
        }

        return $res;
    }

    public function julizi_by_num($array, $num)
    {
        if ($num == 0) {
            $res = array(
                'remain' => $array,
            );

            return $res;
        }

        $all = array();

        for ($i = 0; $i < count($array); ++$i) {
            $temp_array = $array;
            $one = array_splice($temp_array, $i, 1);
            echo 'line '.json_encode($temp_array);
            echo "\n";
            $data = $this->julizi_by_num($temp_array, $num - 1);

            if (isset($data['num'])) {
                $one = array_merge($one, $data['num']);
            }
            $data['num'] = $one;

            return $data;
            // $all[] = $data;
        }

        // return $all;
    }

    public function test()
    {
        $data = array(1,2,3,4,5);

        // $rest = array_splice($data, 0, 1);
        // echo 'line '.json_encode($data);
        // echo "\n";
        // echo 'rest '.json_encode($rest);
        // echo "\n";

        $res = $this->julizi_by_num($data, 3);
        echo json_encode($res);
        echo "\n";
    }

    private function avg($array)
    {
        $avg = $this->sum($array) / count($array);

        return $avg;
    }

    public function cha_ping($array)
    {
        $avg = $this->avg($array);
        $cha_ping = array();
        foreach ($array as $one) {
            $cha_ping[] = $one - $avg;
        }
        sort($cha_ping);

        return $cha_ping;
    }

    public function sum($array)
    {
        $sum = 0;
        foreach ($array as $one) {
            $sum += $one;
        }

        return $sum;
    }
}
