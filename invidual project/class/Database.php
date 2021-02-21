<?php
class Database{
    public function __construct()
    {
        $this->conn = $this->getConnection();

    }

    public function getConnection(){
        $db_server = 'localhost';
        $db_username = 'root';
         $db_password = '';
        $db_database = 'final';
        $conn = new mysqli($db_server, $db_username,
                                $db_password, $db_database);
        // Check Connection
        if ($conn->connect_error) {
            die('Error while connect to database :' . $conn->connect_error);
        }
        return $conn;
    }

    public function getAll($table) {
        $sql = 'SELECT * FROM '.$table;
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
      
    public function getOne($id) {
        $sql = "SELECT 
                    n.id,
                    n.title,
                    n.detail,
                    n.category_code,
                    n.user_code,
                    n.image,
                    c.name AS category_name,
                    u.name AS post_by
                FROM news AS n
                INNER JOIN categories AS c ON c.category_code= n.category_code
                INNER JOIN users AS u ON u.user_code = n.user_code
                WHERE n.id = " . $id;
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows>0 ) {
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    //query join to get dispplay data
    public function getAllTable() {
        $sql = "SELECT 
                    n.id,
                    n.title,
                    n.detail,
                    n.image,
                    c.name AS category_name,
                    u.name AS post_by
                FROM news AS n
                INNER JOIN categories AS c ON c.category_code= n.category_code
                INNER JOIN users  AS u ON u.user_code = n.user_code";
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Insert Data
    public function insert($table,$value,$row=null){
		$insert= " INSERT INTO ".$table;
		if($row!=null){
			$insert.=" (". $row." ) ";
		}
		for($i=0; $i<count($value); $i++){
			if(is_string($value[$i])){
				$value[$i]= '"'. $value[$i] . '"';
			}
		}
		$value=implode(',',$value);
		$insert.=' VALUES ('.$value.')';
		$ins=$this->conn->query($insert);
		if($ins){
			return true;
		}else{
			return false;
		}
	}

    //function for update data
    public function update($id,$title,$detail, $category_code,$user_code) {
        $sql = "UPDATE news SET
                    title='".$title."', 
                    detail='".$detail."',   
                    user_code='".$user_code."',
                    category_code='".$category_code."'
                    WHERE id= " .$id;
        if ($this->conn->query($sql) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }

    // delete data
    public function delete($id,$table) {
        $sql = "DELETE FROM .$table
                    WHERE id = " . $id;
        if ($this->conn->query($sql) === TRUE) {
            return TRUE;
        }
        return FALSE;
    }
}
?>