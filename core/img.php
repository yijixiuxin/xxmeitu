<?php

class img extends base {
	public $ypicPath = '';
	public $hpicPath = '';
	public $mpicPath = '';
	public $lpicPath = '';
	public $tpicPath = '';

	public $sHpic = '0.9';
	public $sMpic = '0.6';
	public $sLpic = '0.3';
	public $sTpic = array('width' => 200, 'height' => 200);

	public $dbPic = '';
	public $dbCaiji = '';
	public $dbTuji = '';

	public function __construct() {
		$this->ypicPath = APPPATH.'upload/y/';
		$this->hpicPath = APPPATH.'upload/h/';
		$this->mpicPath = APPPATH.'upload/m/';
		$this->lpicPath = APPPATH.'upload/l/';
		$this->tpicPath = APPPATH.'upload/t/';

		$this->dbPic = $this->load_model('pic');
		$this->dbCaiji = $this->load_model('caiji');
		$this->dbTuji = $this->load_model('tuji');
	}

	public function curlGet($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		sleep(1);
		return $output;
	}

	public function addPicDb($tid, $title, $picUrl, $yid, $lid) {
		//检测是否已经有此图片
		$isExists = $this->dbPic->frow("picurl='{$picUrl}'");
		if (!empty($isExists)) return true;
		$yPicFile = $this->copyYuantu($picUrl);
		if ($yPicFile == false) return false;
		$picName = substr($yPicFile, strrpos($yPicFile, '/') + 1);
		$hPicPath = $this->hpicPath.date('YmdH').'/';
		$mPicPath = $this->mpicPath.date('YmdH').'/';
		$lPicPath = $this->lpicPath.date('YmdH').'/';
		$tPicPath = $this->tpicPath.date('YmdH').'/';
		if (!is_dir($hPicPath)) {mkdir($hPicPath);chmod($hPicPath, 777);}
		if (!is_dir($mPicPath)) {mkdir($mPicPath);chmod($mPicPath, 777);}
		if (!is_dir($lPicPath)) {mkdir($lPicPath);chmod($lPicPath, 777);}
		if (!is_dir($tPicPath)) {mkdir($tPicPath);chmod($tPicPath, 777);}
		$hPicFile = resizeThumbnailImage($hPicPath.$picName, $yPicFile, $this->sHpic);
		$mPicFile = resizeThumbnailImage($mPicPath.$picName, $yPicFile, $this->sMpic);
		$lPicFile = resizeThumbnailImage($lPicPath.$picName, $yPicFile, $this->sLpic);
		$tPicFile = resizeThumbnailImage($tPicPath.$picName, $yPicFile, 1, $this->sTpic);
		$insert = array(
			'lid' => $lid,
			'yid' => $yid,
			'tid' => $tid,
			'picurl' => $picUrl,
			'pname' => $title,
			'ypicurl' => substr($yPicFile, strpos($yPicFile, '/upload')),
			'hpicurl' => substr($hPicFile, strpos($hPicFile, '/upload')),
			'mpicurl' => substr($mPicFile, strpos($mPicFile, '/upload')),
			'lpicurl' => substr($lPicFile, strpos($lPicFile, '/upload')),
			'tpicurl' => substr($tPicFile, strpos($tPicFile, '/upload')),
			'status' => 1,
			'created' => time()
		);
		return $this->dbPic->insert($insert);
	}

	public function copyYuantu($picUrl) {
		$picPath = $this->ypicPath.date('YmdH').'/';
		if (!is_dir($picPath)) {
			mkdir($picPath);
			chmod($picPath, 777);
		}
		$fileName = date('Ymdhis').rand(1,10000).substr($picUrl, strrpos($picUrl, '.'));
		$filePath = $picPath.$fileName;
		if (copy($picUrl, $filePath)) {
			return $filePath;
		} else {
			return false;
		}
	}

	public function checkCaiji($url) {
		$fRow = $this->dbCaiji->frow("url='{$url}'");
		if (empty($fRow)) {
			return false;
		}
		return true;
	}
	public function addCaiji($url) {
		$insert = array('url' => $url, 'status' => 1, 'created' => time());
		return $this->dbCaiji->insert($insert);
	}

	public function addTuji($title, $lid, $yid, $articleUrl) {
		$fRow = $this->dbTuji->frow("lid={$lid} AND yid={$yid} AND articleurl='{$articleUrl}'");
		if (!empty($fRow)) {
			return $fRow['tid'];
		}
		$insert = array('title' => $title, 'yid' => $yid, 'lid' => $lid, 'articleurl' => $articleUrl, 'status' => 0, 'created' => time());
		$res = $this->dbTuji->insert($insert);
		return $this->dbTuji->insertid();
	}
}