<?php

class laiyuanModel extends DB {
	public $table = 'picyuan';
  public $table2 = 'picyuanlei';

	public function __construct() {
		parent::__construct();
	}

	public function flist($where = '', $order = '', $limit = '') {
        return parent::flist($this->table, $where, $order, $limit);
    }

    public function insert($data) {
        return parent::insert($this->table, $data);
    }

    public function frow($where = '', $order = '') {
        return parent::frow($this->table, $where, $order);
    }

    public function update($where, $data) {
        return parent::update($this->table, $where, $data);
    }

    public function del($where) {
        return parent::del($this->table, $where);
    }

  public function addSubLei($data) {
    return parent::insert($this->table2, $data);
  }

  public function getSubLei($where) {
    return parent::flist($this->table2, $where);
  }

  public function delSubLei($where) {
    return parent::del($this->table2, $where);
  }
}