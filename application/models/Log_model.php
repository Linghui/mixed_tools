<?php

class Log_model extends CI_Model
{
    public function log($tag, $message)
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $logs = $this->cache->get('logs');
        if (!$logs) {
            $logs = array();
        }
        $logs[] = date('Y-m-d H:i:s', time())." - $tag - $message";

        $jobs = $this->cache->save('logs', $logs, 3600 * 24 * 7);
    }

    public function get()
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        
        $logs = $this->cache->get('logs');

        return $logs;
    }
}
