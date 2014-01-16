<?php
###########################################################################
#                                                                         #
#  SolusVMController                                                      #
#                                                                         #
#  Copyright (C) 2012 SolusVMController                                   #
#                                                                         #
#  This program is free software: you can redistribute it and/or modify   #
#  it under the terms of the GNU General Public License as published by   #
#  the Free Software Foundation, either version 3 of the License, or      #
#  (at your option) any later version.                                    #
#                                                                         #
#  This program is distributed in the hope that it will be useful,        #
#  but WITHOUT ANY WARRANTY; without even the implied warranty of         #
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          #
#  GNU General Public License for more details.                           #
#                                                                         #
#  You should have received a copy of the GNU General Public License      #
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.  #
#                                                                         #
###########################################################################

class MySQL {
    protected $link, $host, $user, $password, $database;
    private $query, $log, $lastError, $total=0;

    public function __construct($host, $user, $password, $database){
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
    }

    public function __destruct(){ if(is_resource($this->link)) @mysql_close($this->link); }

	public function connect(){
		$this->link = @mysql_connect($this->host, $this->user, $this->password) or die('MySQL->connect(): Unable to make a database connection.');

        @mysql_select_db($this->database, $this->link) or die('MySQL->connect(): Database error.');

        mysql_query('SET NAMES utf8', $this->link);
        mysql_query('SET CHARACTER SET utf8', $this->link);
        mysql_query('SET CHARACTER_SET_CONNECTION=utf8', $this->link);
	}

    public function enableLog($file){
        $this->log = $file;
        if(!is_file($file)) @file_put_contents($file, '');
		if(!is_writable($file)) die('MySQL->enableLog(): No permission to write file.');
    }

    public function saveError(){
		$this->lastError = mysql_error($this->link);
        if(!is_file($this->log)) return false;

		$lines[] = date('Y-m-d H:i:s', time() - date('Z'));
		$lines[] = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '-';
		$lines[] = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '-';
		$lines[] = mysql_error($this->link) . ':' . mysql_errno($this->link);
		$lines[] = $this->query;

		file_put_contents($this->log, implode("\t", $lines) . "\n", FILE_APPEND);
    }

	public function getLastError(){ return $this->lastError; }

    public function escape($s){ return @mysql_real_escape_string($s, $this->link); }

	public function getQuery(){ return $this->query; }

    public function execute($query){
        $this->query = $query;
		$this->lastError = '';

		if(!is_resource($this->link)) die('MySQL->execute(): Call MySQL->connect() before make a query.');

		$resource = @mysql_query($query, $this->link) or $this->saveError();
		$this->total += 1;

		if(!$resource) return false;

		if(is_resource($resource)){
			$result = array();

			while($row = mysql_fetch_assoc($resource)) $result[] = $row;
			mysql_free_result($resource);

			return $result;
		}
		return true;
    }

    public function select($table, $data='*', $condition=''){
        $columns = '';
		$where = '';

        if(preg_match('/LIKE|BETWEEN| IS|=|<|>/i', $condition)) $where = 'WHERE ' . $condition;
		elseif(!empty($condition)) $where = $condition;

		if(strpos($data, ',')) $data = array_map('trim', explode(',', $data));
        if(is_array($data)) $columns = '`' . implode('`,`', $data) . '`';
        else $columns = ($data == '*') ? $data : '`' . $data . '`';

        $query = 'SELECT ' . $columns . ' FROM `' . $table . '` ' . $where;

        return $this->execute($query);
    }

    public function affectedRows(){ return mysql_affected_rows($this->link); }

    public function getLastId(){ return mysql_insert_id($this->link); }

    public function total(){ return $this->total; }

    public function insert($table, $data){
        $field = '';
        $value = '';

        foreach($data as $key=>$val){
            $field .= '`' . $key . '`, ';
            $value .= '\'' . $this->escape($val) . '\', ';
        }
        $query = 'INSERT INTO `' . $table . '` (' . rtrim($field, ', ') . ') VALUES (' . rtrim($value, ', ') . ')';

        return $this->execute($query);
    }

    public function update($table, $data, $condition=''){
        $column = '';
        $where = (!empty($condition)) ? 'WHERE ' . $condition : '';

        if(is_array($data)){
            foreach($data as $key=>$val) $column .= '`' . $key . '`=\'' . $this->escape($val) . '\', ';
            $query = 'UPDATE `' . $table . '` SET ' . rtrim($column, ', ') . ' ' . $where;
        } else{
			$query = 'UPDATE `' . $table . '` SET ' . $data . ' ' . $where;
        }

        return $this->execute($query);
    }

    public function delete($table, $condition=''){
        $where = (!empty($condition)) ? 'WHERE ' . $condition : '';
        $query = 'DELETE FROM `' . $table . '` ' . $where;

        return $this->execute($query);
    }

	 public function executeSQL($sql){
        $query = '';
        $sql = explode("\n", $sql);

        foreach($sql as $s){
            $s = trim($s);
            if($s != '' && substr($s, 0, 1) != '-' && substr($s, 0, 1) != '#') $query .= $s;

            if(substr($s, -1) == ';'){
                $this->execute($query);
                $query = '';
            }
        }
    }
}

?>