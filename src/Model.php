<?php

namespace Lequyen\Mvc;

class Model {
    protected $conn;
    protected $table;

    protected $columns;

    public function __construct() {
        try {
            $this->conn = new \PDO("mysql:host=localhost;dbname=nhom4", 'root', '');
        
            // set the PDO error mode to exception
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function findOne($id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        return $stmt->fetch();
    }

    public function all() {
        $sql = 'SELECT * FROM ' . $this->table;

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    public function paginate($page = 1, $perPage = 10) {
        $sql = "SELECT * FROM {$this->table} LIMIT $perPage OFFSET (($page - 1) * $perPage)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    public function insert($data) {
        $sql = "INSERT INTO {$this->table}";

        $columns = implode(", ", $this->columns);
        $sql .= "({$columns}) VALUES ";

        $values = [];
        foreach ($this->columns as $column) {
            $values[] = ":{$column}";
        }
        $values = implode(", ", $values);
        $sql .= "({$values})";

        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns)) {
                $stmt->bindParam(":{$key}", $value);
            }
        }
        
        $stmt->execute();
    }

    /* 
        $data = [
            'collumn_name' => 'giá trị người dùng truyền vào',
        ];

        $conditions = [
            ['collumn_name', 'toán tử so sánh', 'giá trị người dùng truyền vào']
        ];
    */
    public function update($data, $conditions = []) {
        $sql = "UPDATE {$this->table} SET ";

        $sets = [];
        foreach ($this->columns as $column) {
            $sets[] = "{$column} = :{$column}";
        }
        $sets = implode(", ", $sets);
        $sql .= "{$sets}";

        $where = [];
        foreach ($conditions as $condition) {
            $where[] = "{$condition[0]} {$condition[1]} :{$condition[0]}";
        }
        $where = implode(", ", $where);
        $sql .= " WHERE {$where}";

        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            if (in_array($key, $this->columns)) {
                $stmt->bindParam(":{$key}", $value);
            }
        }

        foreach ($conditions as $condition) {
            $stmt->bindParam(":{$condition[0]}", $condition[2]);
        }
        
        $stmt->execute();
    }

    public function delete($conditions = []) {
        $sql = "DELETE FROM {$this->table} WHERE ";

        $where = [];
        foreach ($conditions as $condition) {
            $where[] = "{$condition[0]} {$condition[1]} :{$condition[0]}";
        }
        $where = implode(", ", $where);
        $sql .= "{$where}";

        $stmt = $this->conn->prepare($sql);

        foreach ($conditions as $condition) {
            $stmt->bindParam(":{$condition[0]}", $condition[2]);
        }
        
        $stmt->execute();
    }

    public function __destruct() {
        $this->conn = null;
    }
    }

    