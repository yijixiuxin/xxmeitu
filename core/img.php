<?php

class img {
	public $ypicPath = '';
	public $hpicPath = '';
	public $mpicPath = '';
	public $lpicPath = '';

	public function __construct() {
		$this->ypicPath = APPPATH.'upload/y/';
		$this->hpicPath = APPPATH.'upload/h/';
		$this->mpicPath = APPPATH.'upload/m/';
		$this->lpicPath = APPPATH.'upload/l/';
	}
}