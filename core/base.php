<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-9
 * Time: 下午8:58
 * To change this template use File | Settings | File Templates.
 */

class base {
    public $db = null;

    private $_loadLib = array();
    private $_loadModel = array();

    public $data = array();

    public function __construct() {
    }

    public function views($views, $data = '') {
        $viewsFile = APPPATH.'views/'.$views.'.phtml';
        if (file_exists($viewsFile) == false) {
            exit($views.' views exists');
        }
        if (empty($this->data)) extract($this->data);
        if (is_array($data)) extract($data);

        include $viewsFile;
    }

    public function load_library($lib) {
        if (isset($this->_loadLib[$lib])) return true;
        $libFile = APPPATH.'library/'.$lib.'Lib.php';
        if (file_exists($libFile) == false) {
            exit($lib.' library exists');
        }
        include $libFile;
        $className = $lib.'Lib';
        $library = new $className();
        $this->_loadLib[$lib] = &$library;
        return $library;
    }

    public function load_model($model) {
        if (isset($this->_loadModel[$model])) return $this->_loadModel[$model];
        $modelFile = APPPATH.'model/'.$model.'Model.php';
        if (file_exists($modelFile) == false) {
            exit($model.' model exists');
        }
        include $modelFile;
        $className = $model.'Model';
        $modelObj = new $className();
        $this->_loadModel[$model] = & $modelObj;
        return $modelObj;
    }

    public function showMsg($msg, $url = '') {
        header("Content-Type:text/html; charset=utf-8");
        echo '<html>';
        echo '<head><title>消息提示</title></head>';
        echo '<body>';
        echo '<script type="text/javascript">';
        echo 'alert("'.$msg.'");';
        if ($url != '') {
            echo 'window.location.href="'.$url.'";';
        } else {
            echo 'window.history.go(-1);';
        }
        echo '</script>';
        echo '</body>';
        echo '<html>';
    }

}