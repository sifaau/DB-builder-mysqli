<?php
// nyoba modifikasi query builder, by sifa, 15/11/2016
// DB DRIVER  :  Mysqli
require_once __DIR__."config.php";
class db_query_builder{

	private $mysqli = NULL;
	public function __construct() {
		date_default_timezone_set("Asia/Jakarta");
		return $this->mysqli = new mysqli(HOST_NAME,USERNAME_DB,PASSWORD_DB,DB_NAME) OR die("Koneksi ke DataBase Gagal, segera hubungi Programmer.");
	}

	public function save($table_name,$data){
		$fields = array_keys($data);
		$query="INSERT INTO ".$table_name."(`".implode('`,`', $fields)."`)
		VALUES('".implode("','", $data)."')";
		return $this->mysqli->query($query);
	}


	public function update($table_name, $data, $condition=''){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "UPDATE ".$table_name." SET ";
		$sets = array();
		foreach($data as $column => $value)
		{
			$sets[] = "`".$column."` = '".$value."'";
		}
		$query .= implode(', ', $sets);
		$query .= $where;
		return $this->mysqli->query($query);
	}


	public function delete($table_name, $condition='')
	{
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "DELETE FROM ".$table_name.$where;
		return $this->mysqli->query($query);
	}


	public function select_where($table_name,$fields,$condition=''){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "SELECT ".$fields." FROM ".$table_name.$where;
		return $this->mysqli->query($query);
	}

	public function select_order($table_name,$fields,$condition='',$order){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition." " : " ".trim($condition)." ";
		}
		$query = "SELECT ".$fields." FROM ".$table_name.$where." ORDER BY ".$order;
		return $this->mysqli->query($query);
	}

	public function select_max($table_name,$fields,$condition=''){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "SELECT MAX(".$fields.") as hasil FROM ".$table_name.$where;
		$mysqli_query = $this->mysqli->query($query);
		$hasil= $this->fetch_array($mysqli_query);
		return $hasil['hasil'];
	}

	public function select_sum($table_name,$field,$condition=''){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "SELECT SUM(".$field.") as hasil FROM ".$table_name.$where;
		$mysqli_query = $this->mysqli->query($query);
		$hasil= $this->fetch_array($mysqli_query);
		return $hasil['hasil'];
	}

	public function result_array($table_name,$fields,$condition=''){
		//pengembangan sedikit dr select_where 
		$query = $this->select_where($table_name,$fields,$condition);
		return $hasil= $this->fetch_array($query);
	}

	public function last_row($table_name,$fields,$condition='',$order){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "SELECT ".$fields." FROM ".$table_name.$where." ORDER BY ".$order." LIMIT 1";
		$mysqli_query = $this->mysqli->query($query);
		return $this->fetch_array($mysqli_query);
	}

	public function last_field_value($table_name,$field,$condition='',$order){
		$where='';
		if(!empty($condition))
		{
			$where = substr(strtoupper(trim($condition)), 0, 5) != 'WHERE' ? " WHERE ".$condition : " ".trim($condition);
		}
		$query = "SELECT ".$field." as hasil FROM ".$table_name.$where." ORDER BY ".$order." LIMIT 1";
		$mysqli_query = $this->mysqli->query($query);
		$hasil= $this->fetch_array($mysqli_query);
		return $hasil['hasil'];
	}


	public function all_data($table_name){
		$query = "SELECT * FROM ".$table_name;
		return $this->mysqli->query($query);
	}

	public function insert_id(){
		return $this->mysqli->insert_id;
	}


	public function count_rows($table_name,$field,$condition){
		$query = $this->select_where($table_name,$field,$condition);
		return $query->num_rows;
	}

	public function num_rows($query){
		return $query->num_rows;
	}

	public function get_data_by_field($table_name,$field,$condition){
		$query = $this->select_where($table_name,$field,$condition);
		$hasil= $this->fetch_array($query);
		return $hasil["$field"];
	}


	public function autocommit($boolean){
		// $boolean : true or false;
		return $this->mysqli->autocommit($boolean);
	}


	public function commit(){
		return $this->mysqli->commit();
	}


	public function rollback(){
		return $this->mysqli->rollback();
	}


	public function fetch_array($query){
		return  $query->fetch_array(MYSQLI_ASSOC);
		// return index yang dipakei hanya nama field
	}

	public function escape_string($string){
		return $this->mysqli->real_escape_string($string);
	}




}



?>