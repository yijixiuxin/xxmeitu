<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-11
 * Time: 上午7:27
 * To change this template use File | Settings | File Templates.
 */

class tupian extends base {
	public $dbPic = '';
	public $dbTuji = '';
	public $dbLeimu = '';

	public function __construct() {
		parent::__construct();
		$this->dbPic = $this->load_model('pic');
		$this->dbLeimu = $this->load_model('leimu');
		$this->dbTuji = $this->load_model('tuji');
	}

	public function index() {
		$leimuList = $this->dbLeimu->flist('', 'ob ASC');
		$lid = isset($_GET['lid']) ? (int)$_GET['lid'] : 0;
		if ($lid <= 0) {
			$lid = $leimuList[0]['lid'];
		}
		$picList = $this->dbTuji->joinPic($lid);
		$data['leimuList'] = $leimuList;
		$data['picList']= $picList;
		$data['lid'] = $lid;
		$this->views(__CLASS__.'/'.__FUNCTION__, $data);
	}

	public function picview(){

		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$where = 'tid='.$_POST['tid'];
			$updateTuji['title'] = $_POST['title'];
			$updateTuji['lid'] = $_POST['lid'];
			$updateTuji['status'] = $_POST['status'];
			$res = $this->dbTuji->update($where, $updateTuji);
			if ($res == false) $this->showMsg('更新图集失败');
			foreach ($_POST['pid'] as $k => $pid) {
				$upWhere = 'pid='.$pid;
				$upData['pname'] = $_POST['pname'][$k];
				$upData['ob'] = (int)$_POST['ob'][$k];
				$upData['status'] = (int)$_POST['pstatus'][$k];
				$this->dbPic->update($upWhere, $upData);
			}
			$this->showMsg('更新图集成功', '/index.php?c=tupian&a=index&lid='.$_POST['lid']);
		}

		$tid = isset($_GET['tid']) ? (int)$_GET['tid'] : 0;
		$tujiInfo = $this->dbTuji->frow('tid='.$tid);
		if (empty($tujiInfo)) $this->showMsg('查找图集失败');
		$leimuList = $this->dbLeimu->flist();
		$picList = $this->dbPic->flist('tid='.$tid);
		$data['tujiInfo'] = $tujiInfo;
		$data['leimuList'] = $leimuList;
		$data['picList'] = $picList;
		$this->views(__CLASS__.'/'.__FUNCTION__, $data);
	}
}