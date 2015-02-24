<?php 
#error_reporting(0);

class simpleCRUD {

	public $con;
	public $error;
	public $errno;
	public $db;
	public $table;

	public function __construct( $host=null,$user=null,$password=null,$db=null,$config = array() ) {

		$default = array(
			'charset' => 'utf8',
			'port'=> 3306,
			'socket' => null,
			'charset'=>'utf8',
			'setNames'=>'utf8',
			);

		$config = $config + $default;

		$charset = $config['charset'];
		$port = $config['port'];
		$socket = $config['socket'];
		$this->db = $db;

		$mysqli = new mysqli( $host, $user, $password, $db, $port, ( empty( $socket ) ? "" : $socket ) ); 

		if( mysqli_connect_errno() ) {

			$this->error = mysqli_connect_error();
			$this->errno = mysqli_connect_errno();
			$this->con = false; 
		} else {
			$this->con = $mysqli;
		}
		$mysqli->set_charset($charset); 
		$mysqli->query("SET NAMES '".$charset."'");
		$mysqli->query("SET GLOBAL sql_mode='' ");
		return $this->con;
	}
	public function instance() {
		return $this->__construct();
	}
	
	public function query($query = null) {

		if( $query == null ) {
			return false;
		}

		$query = $this->con->query( $query ); 
		return $query;
	}

	public function escape( $string = null ) {
		return addslashes( $string );
	}

	public function get( $table = null, $conditions = array(), $config = array() ) {
		
		$this->table = $table;

		$defaults = array(
			"select"=>"*",
			"order"=>"DESC",
			"orderby"=>"id",
			"limit"=> null
			);

		$c = $config + $defaults; 
		if( is_array( $c['select'] ) ) {
			$c['select'] = implode(", ", $c['select']); 
		}

		if( empty( $conditions ) or $conditions == null ) {
			$concat = " 1 ";
		} 
		elseif( !empty( $conditions ) && is_string( $conditions ) ) {
			$concat = $conditions;
		} else {
			$concat = "";
			foreach( $conditions as $key => $value ) {
				$value = $this->escape( $value );
				$concat .= "{$key} = '{$value}' and ";
			}
			$concat = rtrim( $concat, " and " ); 
		}

		$inc = "ORDER BY ". $c['orderby']." ". $c['order']; 

		$lm = null == $c['limit'] ? "" : " LIMIT ".$c['limit'];

		$sql = "SELECT " . $c['select'] . " FROM " . $this->db . "." . $table . " WHERE ({$concat}) {$inc} {$lm}"; 
		return $this->query( $sql );
	}

	public function insert( $table = null, $data = array() ) {
		if( $table == null or empty( $data ) ):
			return false;
		else:
			$cols = ""; 
			$values = "";
			foreach( $data as $key => $value ) {

				$cols .= "{$key}, "; 
				$values .= "'{$value}', "; 
			}
			$cols = rtrim($cols,", "); 
			$values = rtrim($values,", "); 

			$sql = "INSERT INTO " . $this->db . ".{$table} ({$cols}) VALUES ({$values})"; 

			return $this->query( $sql );
		endif;
	}

	public function update($table = null, $data = array(), $conditions = array(), $operator = "AND" ) {

		if( $table == null or empty( $data ) or empty( $conditions ) ) {
			return false;
		} else {

			$returnData = ""; 
			foreach( $data as $key => $value ) {
				$value = $this->escape( $value );
				$returnData .= " $key = '$value', "; 
			} 
			$returnData = rtrim( $returnData, ", " ); 

			$returnConditions = ""; 

			foreach( $conditions as $key => $value ) {
				$value = $this->escape( $value ); 
				$returnConditions .= " $key = '$value' {$operator} "; 
			} 
			$returnConditions = rtrim( $returnConditions, " {$operator} "); 


			$sql = "UPDATE ".$this->db.".{$table} SET {$returnData} WHERE {$returnConditions}";
			
			return $this->query( $sql );
		}

	}

	public function delete($table = null, $conditions = array(), $operator = "AND" ) {

		if( $table == null or empty( $conditions ) ) {
			return false;
		} else {

			$returnConditions = ""; 
			foreach( $conditions as $key => $value ) {
				$value = $this->escape( $value ); 
				$returnConditions .= " $key = '$value' {$operator} "; 
			} 
			$returnConditions = rtrim( $returnConditions, " {$operator} "); 

			$sql = "DELETE FROM ".$this->db.".{$table} WHERE {$returnConditions}";
			
			return $this->query( $sql );
		}
	}
}