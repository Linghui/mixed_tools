<?php

class Pk_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->set_table('all_pk');
    }
}
