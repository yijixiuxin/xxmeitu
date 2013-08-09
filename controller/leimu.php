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
    public function __construct(){
        parent::__construct();
        $this->dbLeimu = $this->load_model('leimu');
    }

    public function leimulist() {
        $data = array();
        //获取所有类目信息
        $leimuList = $this->dbLeimu->flist();
        $data['leimuList'] = $leimuList;
        $this->views(__CLASS__.'/'.__FUNCTION__, $data);
    }

    public function addleimu() {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $insertData['lname'] = $_POST['lname'];
            $insertData['pid'] = (int)$_POST['pid'];
            $insertData['status'] = (int)$_POST['status'];
            $insertData['ob'] = (int)$_POST['ob'];
            $res = $this->dbLeimu->insert($insertData);
            if ($res == true) {
                $this->showMsg('添加类目成功', '/index.php?c=leimu&a=leimulist');
            } else {
                $this->showMsg('添加类目失败');
            }
        }
        $leimuList = $this->dbLeimu->flist();
        $data['leimuList'] = $leimuList;
        $this->views(__CLASS__.'/'.__FUNCTION__, $data);
    }
}