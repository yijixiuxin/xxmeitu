<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-9
 * Time: 下午9:09
 * To change this template use File | Settings | File Templates.
 */

class index extends base {
    public function __construct(){
        parent::__construct();
    }

    public function index() {
        $this->views(__FUNCTION__);
    }

    public function left(){
        $leimu = array(
            '类目管理' => '/index.php?c=leimu&a=leimulist',
            '来源管理' => '/index.php?c=index&a=laiyuan',
            '图片管理' => '/index.php?c=index&a=tupian',
        );
        $data['leimu'] = $leimu;
        $this->views(__CLASS__.'/'.__FUNCTION__, $data);
    }

    public function content() {
        echo '欢迎使用XX美图后台管理系统';
        exit();
    }

}