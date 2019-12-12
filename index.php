<?php 

session_start();

require './Database/DB.php';

$errors=[];
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// print_r($errors);

  $data=[];

  if (empty($_POST["name"])) {
    $errors[] = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
     $errors[] = "Only letters and white space allowed";
    }else{
     $data['name'] = $name;
    }
  }
  
  if (empty($_POST["email"])) {
    $errors[] = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format";
    }else{
     $data['email'] = $email;
    }
  }
    
  if (empty($_POST["address"])) {
   $errors[] = "Address is required";
 } else {
   $address = test_input($_POST["address"]);
   // check if address only contains letters and whitespace
   if (!preg_match("/^[a-zA-Z, ]*$/",$address)) {
    $errors[] = "Invalid address";
   }else{
    $data['address'] = $address;
   }
 }

 if (empty($_POST["password"]) || empty($_POST["confirm_password"])) {
  $errors[] = "Password is required";
} else {
  $password = test_input($_POST["password"]);
  $confirm_password = test_input($_POST["confirm_password"]);
  if ($password != $confirm_password) {
   $errors[] = "Password is mis-matched";
  }else{
   $data['password'] = $password;
  }
}

$_SESSION['errors'] = $errors;

 if (count($data) == 4) {
   $dbConn = new DB("localhost", "crud_php", "root", "");
   $conn = $dbConn->createConnection();
   if ($conn) {
    $created = $dbConn->insert($data);
    if ($created) {
     echo "User created";
    }else{
     echo "Error occured";
    }
   }
   else{
    echo "Database Connection error";
   }
 }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
 <title>Create User</title>

 <style>
 body{
  font-family: 'Raleway', sans-serif;
 }
 </style>
</head>
<body>

<div class="container">
 <div class="row">
  <div class="col-sm-6 offset-sm-3 pt-5">
   <h3 class="text-center">SIGN UP</h3>

   <?php if (isset($_SESSION['errors'])) {
    if (count($_SESSION['errors'])) {
     foreach($_SESSION['errors'] as $error){?>
      <div class="alert alert-danger" role="alert">
       <?php echo $error?>
      </div>
     <?php
     }
    }
    session_destroy();
   }
   ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
      </div>
      <div class="form-group">
        <label for="address">Adress</label>
        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address">
      </div>
      <button type="submit" class="btn btn-primary">SIGN UP</button>
    </form>
  </div>
 </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>