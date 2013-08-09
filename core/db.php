<?php
/**
 * Created by JetBrains PhpStorm.
 * User: WEIWEI
 * Date: 13-8-9
 * Time: 下午9:13
 * To change this template use File | Settings | File Templates.
 */

class DB {
    public $db = null;
    public function __construct() {
        $this->db = mysql_connect(DB_HOST, DB_USER, DB_PWD);
        mysql_select_db(DB_DBNAME, $this->db);
        mysql_query('set names "utf8"', $this->db);
    }

    public function query($sql) {
        return mysql_query($sql, $this->db);
    }

    public function flist($table, $where = '') {
        $where = $where == '' ? '1=1' : $where;
        $sql = "SELECT * FROM {$table} WHERE {$where}";
        $result = $this->query($sql);
        $resArr = array();
        while($row = mysql_fetch_assoc($result)) {
            $resArr[] = $row;
        }
        return $resArr;
    }

    public function insert($table, $data) {
        $key = array_keys($data);
        $value = $data;
        $sql = "INSERT INTO `{$table}` (`".join('`,`', array_keys($data))."`) VALUES('".join("','", $data)."')";
        return $this->query($sql);
    }
}