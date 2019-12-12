<?php
/**
 * User Queries
 */
trait Queries
{
 public function insert($data)
 {
  try{
   // prepare sql and bind parameters
   $stmt = $this->connection->prepare("INSERT INTO users (name, email, password, address) VALUES (:name, :email, :password, :address)");
   $stmt->bindParam(':name', $data['name']);
   $stmt->bindParam(':email', $data['email']);
   $stmt->bindParam(':password', $data['password']);
   $stmt->bindParam(':address', $data['address']);

   $stmt->execute();
   return true;
  }
  catch(PDOException $e){
    echo "Error: " . $e->getMessage();
   }
   $this->closeConnection();
 }
 
}
