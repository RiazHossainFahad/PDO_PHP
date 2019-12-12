<?php

require 'Query.php';

class DB
{

 use Queries;

 private $dbHost;
 private $dbName;
 private $dbUsername;
 private $dbPassword;
 private $connection;
 
 public function __construct($dbHost, $dbName, $dbUsername, $dbPassword)
 {
  $this->dbHost = $dbHost;
  $this->dbName = $dbName;
  $this->dbUsername = $dbUsername;
  $this->dbPassword = $dbPassword;
 }

 public function createConnection()
 {
  try {
   $this->connection = new PDO("mysql:host={$this->dbHost};dbname={$this->dbName}", $this->dbUsername, $this->dbPassword);
   // set the PDO error mode to exception
   $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   return $this->connection;
   }
  catch(PDOException $e){
   echo "Error MSG: ". $e->getMessage();
   }
 }

 public function closeConnection(){
  $this->connection = null;
 }
}