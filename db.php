<?php
const DIR = '/cdn/';

define( 'PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . DIR );
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]" . DIR;
define( 'URL', $actual_link );

date_default_timezone_set("Asia/Kolkata");

function insert($table,$data) {
	global $db;
	$fields = $values = '';
	$i=0;
	foreach($data as $k=>$v) {
		$fields .= ($i>0?", `":"`") .$k."`";
		$values .= ($i>0?", '":"'") .$v."'";
		$i++;
	}


	$sql = "INSERT INTO `$table`($fields) VALUES($values);";
	$ret = $db->exec($sql);
	if(!$ret) {
		return false;
	}
	return true;
}

function update($table,$data,$id) {
	global $db;
	$query = '';
	$i=0;
	foreach($data as $k=>$v) {
		$query .= ($i>0?", `":"`") .$k."`='".$v."'";
		$i++;
	}
	$WHERE = '';
	if($id!=null) {
		$WHERE = "WHERE `id`='".$id."'";
	}
	$sql = "UPDATE `$table` SET $query $WHERE;";
	$ret = $db->exec($sql);
	if(!$ret) {
		return false;
	}
	return true;
}

function fetch($table,$id=null,$order_by='id',$order="DESC") {
	global $db;
	$WHERE = '';
	if($id!=null) {
		$WHERE = "WHERE `id`='".$id."'";
	}
	$sql = "SELECT * FROM `$table` $WHERE ORDER BY `$order_by` $order";
	$ret = $db->query($sql);
	$return = array();
	while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
		$return[] = $row;
	}
	return $return;
}

function fetchWhere($table,$cond=null) {
	global $db;
	$WHERE = '';
	if($cond!=null) {
		$WHERE = "WHERE ".$cond;
	}
	$sql = "SELECT * FROM `$table` $WHERE";
	$ret = $db->query($sql);
	$return = array();
	while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
		$return[] = $row;
	}
	return $return;
}

function delete($table,$id=null) {
	global $db;
	$WHERE = '';
	if($id!=null) {
		$WHERE = "WHERE `id`='".$id."'";
	}
	$sql = "DELETE FROM `$table` $WHERE";
	$ret = $db->query($sql);
	if(!$ret) {
		return false;
	}
	return true;
}

function truncate($table) {
	global $db;
	$sql = "Delete from `$table`";
	$ret = $db->query($sql);
	$sql = "DELETE FROM SQLITE_SEQUENCE WHERE name='$table'";
	$ret = $db->query($sql);
	if(!$ret) {
		return false;
	}
	return true;
}

class MyDB extends SQLite3 {
	function __construct() {
		$this->open(dirname(__FILE__).'/db/cdn.db');
	}
}
$db = new MyDB();
if(!$db) {
	echo $db->lastErrorMsg();
}
$db->busyTimeout(5000);
