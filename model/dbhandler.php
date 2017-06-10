<?php

class DbHandler {
    private $db_username;
    private $db_password;
    private $db_server;
    private $db_name;
    private $conn;

    public function __construct($server, $db_name, $username, $password) {
        $this->db_username = $username;
        $this->db_password = $password;
        $this->db_server = $server;
        $this->db_name = $db_name;

        try {
            $this->conn = new PDO("mysql:host=$this->db_server;dbname=$this->db_name", $this->db_username, $this->db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
             echo "Connection failed: " . $e->getMessage();
        }
    }

    public function createdata($query) {
        try{
            $query = $this->conn->prepare($query);
            $query->execute();
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        } catch(PDOException $e) {
            return $e;
        }
    }


    public function ReadData($array) {
        try {

            $select = $array['selectQuery'];

            $query = $this->conn->prepare($select);

            if(isset($array['bindParam'])) {
                foreach($array['bindParam'] as $key => $value) {
                    $query->bindParam($key, $value);
                }
            }

            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function ReadDataRowCount($array) {
        try {
            $select = $array['selectQuery'];
            $query = $this->conn->prepare($select);
            if(isset($array['bindParam'])) {
                foreach($array['bindParam'] as $key => $value) {
                    $query->bindParam($key, $value);
                }
            }

            $query->execute();
            return $query->rowCount();


        } catch(PDOException $e) {
            return $e;
        }
    }

    public function UpdateData($query) {
        try {
            $query = $this->conn->prepare($query);
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function DeleteData($query) {
        try {
            $query = $this->conn->prepare($query);
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $e) {
            return $e;
        }
    }

}
