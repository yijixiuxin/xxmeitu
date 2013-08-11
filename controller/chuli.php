<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-10
 * Time: 下午9:16
 * To change this template use File | Settings | File Templates.
 */

class chuli extends base {
	public $dbLaiyuan = '';
	public $dbYuanlei = '';

	public function __construct () {
		parent::__construct ();
		$this->dbLaiyuan = $this->load_model('laiyuan');
		$this->dbYuanlei = $this->load_model('yuanlei');
	}

	public function index() {
		$laiyuanList = $this->dbLaiyuan->flist('status=1');
		foreach ($laiyuanList as $yuan) {
			$yuanClass = $this->load_library($yuan['class']);
			$yuanleiList = $this->dbYuanlei->flist('yid='.$yuan['yid'].' and status=1');
			foreach($yuanleiList as $lei) {
				$yuanClass->$lei['func']($yuan, $lei);
			}
		}
	}
}