<?php

require_once("LIB_project1.php");

session_name("Login");

session_start();

$Head = head();

echo $Head['header1'];
    
?>

        <li><a href="index.php">Home</a></li>
        <li class="active"><a href="cart.php">Cart</a></li>
     <?php if($_SESSION['type'] == 'admin') {?>  
        <li><a href="admin.php">Admin</a></li>
     <?php }?>
        <li> <a href="#" style="color:white;margin-left:10%;font-size:15px;cursor:auto"><strong><i>Welcome <?php echo $_SESSION['username']; ?></i></strong></a>
              
        </li>  

<?php  
     echo $Head['header2'];
?>
    
<div class='container'>
    
       
<?php  
    
    if(isset($_POST['remove']))
        
    {  
       delCart($_SESSION['username']);  // delete items from the cart
          
    }
    
      echo displayCartItems($_SESSION['username']);   // Display all the Cart Items
    

?>  

  </div>
    
<?php  
  echo  Footer();
?>
