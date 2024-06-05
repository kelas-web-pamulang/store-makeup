<?php

class ConfigDB
{
    private $host = 'localhost';
    private $db_name = 'database_makeup';
    private $username = 'root';
    private $password = '';
    private $conn;
    private $last_query;

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }

    public function select($table, $where = [])
    {
        $query = "SELECT * FROM $table WHERE deleted_at IS NULL";

        foreach ($where as $key => $value) {
            $query .= " $key '$value'";
        }

        $this->last_query = $query;

        $result = $this->conn->query($query);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function update($table, $data, $id)
    {
        $updated_at = date('Y-m-d H:i:s');
        $query = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            $query .= "$key = '$value', ";
        }
        $query .= "updated_at = '$updated_at' WHERE ID_Produk = '$id'";

        $this->last_query = $query;

        return $this->conn->query($query);
    }

    public function getLastQuery()
    {
        return $this->last_query;
    }

}