<?php 

require_once('connection.php');

class Database{
    private $conn;
    
    public function __construct($connection)
    {
        $this->conn = $connection;
    }
    public function show_all($table){
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($table, $fields){
       
        
         $columns = implode(", ", array_keys($fields));
        $placeholders = ":" . implode(", :", array_keys($fields));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        foreach($fields as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    
    public function find($table, $conditions){
        $keys = array_keys($conditions);
        $where = [];
        foreach($keys as $k){
            $where[] = "$k = :$k";
        }
        $where_clause = implode(' AND ', $where);

        $sql = "SELECT * FROM $table WHERE $where_clause LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        foreach($conditions as $k => $v){
            $stmt->bindValue(":$k", $v);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : false;
    }

    
    public function update($table, $fields, $where){
        $set_parts = [];
        foreach(array_keys($fields) as $k){
            $set_parts[] = "$k = :$k";
        }
        $set_clause = implode(', ', $set_parts);

        $sql = "UPDATE $table SET $set_clause";

        
        if(is_numeric($where)){
            $sql .= " WHERE id = :__where_id";
        } elseif(is_array($where)){
            $conds = [];
            foreach(array_keys($where) as $k){
                $conds[] = "$k = :__where_$k";
            }
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        } else {
            $sql .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($sql);
        foreach($fields as $k => $v){
            $stmt->bindValue(":$k", $v);
        }
        if(is_numeric($where)){
            $stmt->bindValue(":__where_id", $where);
        } elseif(is_array($where)){
            foreach($where as $k => $v){
                $stmt->bindValue(":__where_$k", $v);
            }
        }

        return $stmt->execute();
    }

    
    public function delete($table, $where){
        $sql = "DELETE FROM $table";
        if(is_numeric($where)){
            $sql .= " WHERE id = :__where_id";
        } elseif(is_array($where)){
            $conds = [];
            foreach(array_keys($where) as $k){
                $conds[] = "$k = :$k";
            }
            $sql .= ' WHERE ' . implode(' AND ', $conds);
        } else {
            $sql .= " WHERE $where";
        }

        $stmt = $this->conn->prepare($sql);
        if(is_numeric($where)){
            $stmt->bindValue(":__where_id", $where);
        } elseif(is_array($where)){
            foreach($where as $k => $v){
                $stmt->bindValue(":$k", $v);
            }
        }

        return $stmt->execute();
    }

    
}



$users = new Database($conn);
$user_infos = new Database($conn);