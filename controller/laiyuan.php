<?php

class laiyuan extends base {

	public $dbLaiyuan = '';
	public $dbLeimu = '';
	public $dbSubyuan = '';

	public function __construct () {
		parent::__construct ();
		$this->dbLaiyuan = $this->load_model ('laiyuan');
		$this->dbLeimu = $this->load_model ('leimu');
		$this->dbSubyuan = $this->load_model ('yuanlei');
	}

	public function index () {
		$data['laiyuanList'] = $this->dbLaiyuan->flist ();
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function addlaiyuan () {
		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$yuanData['name'] = $_POST['name'];
			$yuanData['url'] = $_POST['url'];
			$yuanData['class'] = $_POST['class'];
			$yuanData['status'] = $_POST['status'];
			$res = $this->dbLaiyuan->insert ($yuanData);
			if ($res == false)
				$this->showMsg ('添加来源失败');
			$yid = $this->dbLaiyuan->insertid ();
			foreach ($_POST['lurl'] as $k => $lurl) {
				$subData['lurl'] = $lurl;
				$subData['yid'] = $yid;
				$subData['lid'] = $_POST['lid'][$k];
				$subData['func'] = $_POST['func'][$k];
				$subData['status'] = $_POST['lstatus'][$k];
				$this->dbSubyuan->insert ($subData);
			}
			$this->showMsg ('添加来源成功', '/index.php?c=laiyuan&a=index');
		}
		$data['leimuList'] = $this->dbLeimu->flist ('status=1', 'ob ASC');
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}

	public function editlaiyuan () {
		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$where = "yid='{$_POST['yid']}'";
			$update['name'] = $_POST['name'];
			$update['url'] = $_POST['url'];
			$update['class'] = $_POST['class'];
			$res = $this->dbLaiyuan->update ($where, $update);
			if ($res == false)
				$this->showMsg ('修改来源失败');
			$this->dbSubyuan->del($where);
			foreach ($_POST['lurl'] as $k => $lurl) {
				$subData['lurl'] = $lurl;
				$subData['yid'] = $_POST['yid'];
				$subData['lid'] = $_POST['lid'][$k];
				$subData['func'] = $_POST['func'][$k];
				$subData['status'] = $_POST['lstatus'][$k];
				$this->dbSubyuan->insert ($subData);
			}
			$this->showMsg ('修改来源成功', '/index.php?c=laiyuan');
		}
		$yid = isset($_GET['yid']) ? (int)$_GET['yid'] : 0;
		$laiyuanInfo = $this->dbLaiyuan->frow ('yid=' . $yid);
		if (empty($laiyuanInfo))
			$this->showMsg ('获取来源信息失败');
		$subleiList = $this->dbSubyuan->flist ('yid=' . $yid);

		$data['laiyuanInfo'] = $laiyuanInfo;
		$data['subleiList'] = $subleiList;
		$data['leimuList'] = $this->dbLeimu->flist ('status=1', 'ob ASC');
		$this->views (__CLASS__ . '/' . __FUNCTION__, $data);
	}
}