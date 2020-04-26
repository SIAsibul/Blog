<?php
Class Database{
	public $host   = DB_HOST;
	public $user   = DB_USER;
	public $pass   = DB_PASS;
	public $dbname = DB_NAME;
	
	
	public $link;
	public $error;
	
	public function __construct(){
		$this->connectDB();
	}
	
	private function connectDB(){
	$this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
	if(!$this->link){
		$this->error ="Connection failed".$this->link->connect_error;
		return false;
	}
 }
	
	// Select or Read data
	
	public function select($query){
		$result = $this->link->query($query) or die($this->link->error.__LINE__);
		if($result->num_rows > 0){
			return $result;
		} else {
			return false;
		}
	}
	
	// Insert data
	public function insert($query){
	$inserted_row = $this->link->query($query) or die($this->link->error.__LINE__);
	if($inserted_row){
		return $inserted_row;
	} else {
		return false;
	}
  }
  
    // Update data
  	public function update($query){
	$updated_row = $this->link->query($query) or die($this->link->error.__LINE__);
	if($updated_row){
		return $updated_row;
	} else {
		return false;
	}
  }
  
  // Delete data
   public function delete($query){
	$deleted_row = $this->link->query($query) or die($this->link->error.__LINE__);
	if($deleted_row){
		return $deleted_row;
	} else {
		return false;
	}
  }

  public function existance($table, $key, $value){
			$query = "SELECT $key FROM $table WHERE $key = '$value'";
			$selection = $this->select($query);
			if ($selection) {
				$count = mysqli_num_rows($selection);
				if ($count > 0) {
					return true;
				} else {
					return false;
				}
			}
	}

 
 
}

