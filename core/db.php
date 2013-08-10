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
      if(isset($_GET['printsql'])) echo $sql,'<br>';
        return mysql_query($sql, $this->db);
    }

    public function flist($table, $where = '', $order = '', $limit = '') {
        $sqlAdd = '';
        if ($where != '') $sqlAdd .= ' WHERE '. $where;
        if ($order != '') $sqlAdd .= ' ORDER BY '.$order;
        if ($limit != '') $sqlAdd .= ' LIMIT '.$limit;
        $sql = "SELECT * FROM {$table} {$sqlAdd}";
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

    public function update($table, $where, $data) {
        $sqlAdd = ' WHERE '.$where;
        foreach ($data as $k => $v) $up[] = " `{$k}`='{$v}' ";
        $sql = "UPDATE {$table} SET ".join(',', $up).$sqlAdd;
        return $this->query($sql);
    }

    public function frow($table, $where = '', $order = '') {
        $sqlAdd = '';
        if ($where != '') $sqlAdd .= ' WHERE '. $where;
        if ($order != '') $sqlAdd .= ' ORDER BY '.$order;
        $sql = "SELECT * FROM {$table} {$sqlAdd} LIMIT 1";
        $res = $this->query($sql);
        return mysql_fetch_assoc($res);
    }

    public function del($table, $where) {
        $sql = "DELETE FROM {$table} WHERE ".$where;
        return $this->query($sql);
    }

  public function insertid() {
    return mysql_insert_id($this->db);
  }
    
}