<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-10
 * Time: 下午9:46
 * To change this template use File | Settings | File Templates.
 */

class tujiModel extends DB {
	public $table = 'tuji';
	public $picTable = 'pic';

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

	public function joinPic($lid) {
		$sql = "SELECT t.tid,t.title,t.lid,t.`status`,t.created,p.tpicurl
						FROM {$this->table} as t
						LEFT JOIN {$this->picTable} as p ON t.tid = p.tid
						WHERE t.lid ={$lid}
						GROUP BY t.title
						ORDER BY p.ob DESC";
		$query = $this->query($sql);
		$fList = array();
		while($row = mysql_fetch_assoc($query)) {
			$fList[] = $row;
		}
		return $fList;
	}
}