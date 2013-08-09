<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-10
 * Time: 上午7:39
 * To change this template use File | Settings | File Templates.
 */

class leimuModel extends DB {
    public $table = 'leimu';

    public function __construct() {
        parent::__construct();
    }

    public function flist($where = '') {
        return parent::flist($this->table, $where);
    }

    public function insert($data) {
        return parent::insert($this->table, $data);
    }
}