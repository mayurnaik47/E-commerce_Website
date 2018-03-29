<?php

require_once("LIB_project1.php");

session_name("Login");
session_start();


if(isset($_POST['logout'])) {
    
    session_unset(); 
    session_destroy();
}

if(isset($_SESSION['loggedIn']))
{
    
    if($_SESSION['loggedIn']=='true'){
        
         header("Location:index.php?");
         exit;
    }
    
    
}

$Str = head();

echo $Str['header3'];

if(isset($_POST['login']))
{
    
    $username = $_POST['user'];
    $password = $_POST['password'];
    $type = $_POST['loginType'];
    
    
   $flag = validateUser($username,$password,$type);
    
    if($flag==1){
        $_SESSION['saleCount'] = 0;
        $_SESSION['type'] = $type;
        $_SESSION['username'] = $username;
        $_SESSION['loggedIn'] = 'true';
        header("location:index.php");
    }
    else{
        echo "<h6 style='color:red'>Incorrect Username/ Password</h6>";
    }
    
}


?>

    
<div class="container" style="margin-top:2%">   
  <div class="row">    
    <div class="col-sm-8">
   <form action="login.php" method="post">
    <div class="form-group">
    <label for="text"><span style = "color:red;padding-left:1px;">*</span>Username:</label>
    <input type="text" required name="user" class="form-control">
    </div>
  <div class="form-group">
    <label for="pwd"><span style = "color:red;padding-left:1px;">*</span>Password:</label>
    <input type="password" required name="password" class="form-control" id="pwd">
  </div>
      <div class="form-group">
      <label for="pwd">Login as:</label>
  <label class="radio-inline"><input type="radio" name="loginType" checked value="user" >User</label>
  <label class="radio-inline"><input type="radio" name="loginType" value="admin">Admin</label>
     </div>
  <button type="submit" name="login" class="btn btn-primary">Log In</button>
  </form>
   </div>   
    </div>
    </div>
    
    
    
</body>
</html>