<?php
include 'Database.php';
class Category extends Database{
    private $conn;
    public function __construct()
    {
        $this->conn = $this->getConnection();
    }
    public function __destruct()
    {
        $this->conn->close();
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
}
?>