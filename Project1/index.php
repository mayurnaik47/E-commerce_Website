<?php

require_once("LIB_project1.php");

session_name("Login");

session_start();

if(!isset($_SESSION['loggedIn']))
{
       
       header("Location:login.php?");
       exit;
} 
$_SESSION['page1'] = 'active';


if(isset($_GET['page']))
{
  if($_GET['page']==1){$_SESSION['page1'] = 'active'; $_SESSION['page2'] = '';$_SESSION['page3'] = ''; }
    
  if($_GET['page']==2){$_SESSION['page1'] = ''; $_SESSION['page2'] = 'active';$_SESSION['page3'] = '';}
    
  if($_GET['page']==3){$_SESSION['page1'] = ''; $_SESSION['page2'] = '';$_SESSION['page3'] = 'active';}
}


$Head = head();

echo $Head['header1'];
    
?>

<li class="active"><a href="index.php">Home</a></li>
<li><a href="cart.php">Cart</a></li>
<?php if($_SESSION['type'] == 'admin') {?>  
  <li><a href="admin.php">Admin</a></li>
<?php }?>
 <li> <a href="#" style="color:white;margin-left:10%;font-size:15px;cursor:alias"><strong><i>Welcome <?php echo $_SESSION['username']; ?></i></strong></a>
</li>

<?php    
   echo $Head['header2'];
    
    
    if(isset($_POST['add']) && isset($_POST['item']))
        
    {
       
        
       updateQty($_POST['item']);      // Update the Product qty once its added to cart
        
    }
    
    if(!isset($_GET['page'])){
        $page = 1;
    }
    else{
        $page = $_GET['page'];
    }
    
       echo displayProducts($page,5);   // Display data page wise
    
    if(isset($_POST['add']) && isset($_POST['item']))
    {
       
        CartInsert($_POST['item'],$_SESSION['username']);   // Iserting the product to Cart table when "Add to cart" button is pressed. 
        
    }


 $totpages = getPage()-1;

for($i=2;$i<=$totpages;$i++) {
   $_SESSION['page'.$i] = "";
    
}

for($i=1;$i<=$totpages;$i++) {

if(isset($_GET['page']))
{
  if($_GET['page']==$i)
  {$_SESSION['page'.$i] = 'active';}
  else
  {
  $_SESSION['page'.$i] = '';
  }
  
     
}

}
?>  
   


<div class='container'>
   <div class='row'>
    <div class='col-sm-12'>    
<ul class="pagination justify-content-center">
  <li class="page-item"><a class="page-link" href="index.php?page=<?php if($page==1){ echo (($totpages));} else { echo (($page-1) % $totpages);} ?>">Prev</a></li>
  
 <?php for($i=1;$i<=$totpages;$i++) {?> 
   
  <li class="page-item <?php echo $_SESSION['page'.$i] ?>"><a class="page-link" href="index.php?page=<?php echo 
    $i?>"><?php echo $i ?></a></li>
 <?php  }?> 
    
  <li class="page-item"><a class="page-link" href="index.php?page=<?php if($page==($totpages-1)){ echo (($page+1));} else { echo (($page+1) % $totpages);} ?>">Next</a></li>
</ul>   
       </div>
    </div>
    </div>

<?php  
  echo  Footer();
?>