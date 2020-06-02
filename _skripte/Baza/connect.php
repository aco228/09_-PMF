<?php
	class BazaPodataka{
		private $conn;

		private $host;
		private $user;
		private $pass;
		private $db_name;

		public $data;
		public $num;

		public function __construct($query = ""){
				//echo ">>>>>>>>>>>>> ".$_SERVER['HTTP_HOST'];
			switch($_SERVER['HTTP_HOST']){
				case "localhost": 
					$this->host="localhost"; $this->user="root"; $this->pass="root"; $this->db_name="pmf_sajt"; 
					break;
				case "aco228.freeiz.com": 
					$this->host="mysql15.000webhost.com"; $this->user="a4763871_root"; $this->pass="root1234"; $this->db_name="a4763871_ezm"; 
					break;
			}
			$this->connect();
			if($query!="") $this->q($query);
		}
		public function __destruct() { $this->disconnect(); }

		public function q($query, $err = false){
			if(!mysql_ping()){ $this->disconnect(); $this->connect(); }
			if(!$err) $r = mysql_query($query) or die("dbGreska Q ");
			else  	  $r = mysql_query($query) or die("dbGreska Q " . mysql_error());

			$this->data = mysql_fetch_array($r, MYSQL_ASSOC);
			return $this->data;
		}

		public function e($query, $err = false){
			if(!mysql_ping()){ $this->disconnect(); $this->connect(); }
			if(!$err) $r = mysql_query($query) or die("dbGreska E ");
			else  	  $r = mysql_query($query) or die("dbGreska E " . mysql_error());
		}

		public function qMul($query, $num = false, $err = false){
			if(!mysql_ping()){ $this->disconnect(); $this->connect(); }
			if(!$err) $this->data = mysql_query($query) or die("dbGreska Qmul ");
			else  	  $this->data = mysql_query($query) or die("dbGreska Qmul " . mysql_error());

			if($num) $this->num = mysql_num_rows($this->data);

			return $this->data;
		}

		/*
			CONNECT & DISCONNECT
		*/

		private function connect(){
			$this->conn = mysql_connect($this->host, $this->user, $this->pass) or die("dbGreska (conn)"); 
			mysql_select_db($this->db_name, $this->conn) or die("dbGreska (select)");
			mysql_query("SET NAMES UTF8");
		}
		private function disconnect(){ if(gettype($this->conn) == "resource") mysql_close($this->conn); }
		//private function disconnect(){ mysql_close($this->conn);}
	}
?>