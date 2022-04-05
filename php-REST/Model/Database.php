<?php
class Database {
    protected PDO $connection;

    public function __construct(){
        $this->connection = $this->getConnection();
    }

    private function getConnection() : PDO {
        $conn = null;
        try{
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
            $conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $conn;
    }

    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            return $stmt->fetchAll();
        } catch(Exception $e) {
            echo "Statement could not be executed!";
        }
        return false;
    }

    protected function executeStatement($sqlStatement = "" , $params = []) {
        try {
            $stmt = $this->connection->prepare($sqlStatement);
            if($stmt === false) {
                echo "Statement could not be executed!";
            }
            foreach($params as $placeholder => $param){
                $sanitized = intval($param) === 0 ? filter_var($param, FILTER_SANITIZE_STRING) : intval($param);
                $stmt->bindValue($placeholder, $sanitized);
            }
            $stmt->execute();

            return $stmt;
        } catch(Exception $exception) {
            echo "Statement could not be executed: " . $exception->getMessage();
        }
    }

}
