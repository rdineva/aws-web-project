<?php
  class Database {
    public function connect() {
      $this->connection = new PDO("mysql:host=127.0.0.1;dbname=mediadb", 'root', 'Mysql123@');
    }

    public function __destruct() {
      $this->connection = null;
    }

    public function query($query) {
      return $this->connection->query($query);
    }

    public function exec($query) {
      return $this->connection->exec($query);
    } 
  }
?>
