<?php
class DB {
    private static $_instance = null;
    private $_pdo,
            $_query, 
            $_error = false, 
            $_results,
            $_count = 0;

    //make the db more secure to use private constructor
    private function __construct() {
        try {
            $this->_pdo = new PDO(
                'mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),
                Config::get('mysql/username'),
                Config::get('mysql/password'));
            // DISPLAY CONNECTED
            // echo 'Success';
                
        } catch(PDOException $e) {
            die($e->getMessage());
            //PDO CONNECTION FAIL
            // echo 'PDO ERROR';
            }

       
    }

    //get the instance by the outside class
    public static function getInstance() {
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    //use pdo to execute the query by passing the sql command and bind the values into sql command
    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x=1;
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }

            if($this->_query->execute()){
                // echo 'Success Excuted';
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }             
            else{
                $this->_error = true;
            }    
        }

        return $this;
    }

    //generate the sql command 
    public function action($action, $table, $where = array()){
        if(count($where) ===3){
            $operators = array('=','>','<','>=',"<=");

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if(in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator}?";
                if(!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }
        }
        return false;
    }

    //generate the sql command to get data from db
    public function get($table, $where){
        return $this->action('SELECT *',$table, $where);
    }

    public function delete($table, $where){
        return $this->action('DELETE',$table, $where);
    }

    public function insert($table, $fields = array()){
        if(count($fields)){
            $keys = array_keys($fields);
            $values = '';
            $x = 1;

            foreach($fields as $field) {
                $values .= '?';
                if($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }

            $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES ({$values})";   
            
            // echo $sql;
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
        }
        return false;
    }

    public function update($table,$id,$fields){
        $set ="";
        $x = 1;
        
        foreach($fields as $name => $value){
            // $set .= "{$name} = '{$value}'";
            $set .= "{$name} = ?";
            if ($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        // echo $sql;

        if(!$this->query($sql, $fields)->error()){
            return true;
        }
        return false;

    }

    public function results() {
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function count(){
        return $this->_count;
    }

    public function error(){
        return $this->_error;
    }
}