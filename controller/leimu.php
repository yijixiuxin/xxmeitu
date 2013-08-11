<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-9
 * Time: 下午10:25
 * To change this template use File | Settings | File Templates.
 */

class leimu extends base {
	public $dbLeimu = '';

	public function __construct () {
		parent::__construct ();
		$this->dbLeimu = $this->load_model ('leimu');
	}

	public function leimulist () {
		$data = array();
		//获取所有类目信息
		$leimuList = $this->dbLeimu->flist ('', 'ob ASC');
		$data['leimuList'] = $leimuList;
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function addleimu () {
		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$insertData['lname'] = $_POST['lname'];
			$insertData['pid'] = (int)$_POST['pid'];
			$insertData['status'] = (int)$_POST['status'];
			$insertData['ob'] = (int)$_POST['ob'];
			$res = $this->dbLeimu->insert ($insertData);
			if ($res == true) {
				$this->showMsg ('添加类目成功', '/index.php?c=leimu&a=leimulist');
			} else {
				$this->showMsg ('添加类目失败');
			}
		}
		$leimuList = $this->dbLeimu->flist ();
		$data['leimuList'] = $leimuList;
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function editleimu () {
		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$updateData['lname'] = $_POST['lname'];
			$updateData['pid'] = $_POST['pid'];
			$updateData['ob'] = $_POST['ob'];
			$updateData['status'] = $_POST['status'];
			$where = " lid='{$_POST['lid']}' ";
			$res = $this->dbLeimu->update ($where, $updateData);
			if ($res == true) {
				$this->showMsg ('修改类目成功', '/index.php?c=leimu&a=leimulist');
			} else {
				$this->showMsg ('修改类目失败');
			}
		}

		$lid = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
		$leimuInfo = $this->dbLeimu->frow ("lid = '{$lid}'");
		if (empty($leimuInfo)) {
			$this->showMsg ('获取类目信息失败');
		}
		$data['leimuInfo'] = $leimuInfo;
		$leimuList = $this->dbLeimu->flist ();
		$data['leimuList'] = $leimuList;
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function delleimu () {
		$lid = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
		$where = 'lid=' . $lid;
		$res = $this->dbLeimu->del ($where);
		if ($res == true) {
			$this->showMsg ('删除类目成功', '/index.php?c=leimu&a=leimulist');
		} else {
			$this->showMsg ('删除类目失败');
		}
	}
}