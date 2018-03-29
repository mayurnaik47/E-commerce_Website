<?php    
    
require_once("DB.class.php");


include "validations.php" ;

$db =  new DB();

// Below function  is used to Display Sales and Catalog items.

function displayProducts($page,$limit)
{
    
 $datap =  $GLOBALS['db']->pagination($page,$limit); 
    
    
 $data =  $GLOBALS['db']->getAllProducts();
    

 $htString  = "<div class='container'>\n
   <div class='row'>\n
    <div class='col-sm-12'>\n 
      <div class='panel panel-primary class'>\n    
         <div class='panel-heading' style='text-align:center;font-size:20px'>Sale Items</div>\n   
      </div>
    </div>
 </div>";
    
 $_SESSION['saleCount'] = 0;   
    
 $dataCatalog = array();   
       
 // Display data for Sales Item
    
     foreach($data as $row)
     {
       
         if($row->getSalePrice()!=0){
             
         $_SESSION['saleCount']++;
             
         $htString .= "<div class='row'>\n<div class='col-sm-4'>\n
     <div class='panel panel-primary'>\n
        <div class='panel-heading'>{$row->getProductName()}</div>\n
        <div class='panel-body' style='max-height:150px;padding-top:0px;'><img src='images/{$row->getImageName()}.jpg' class='img-responsive' style = 'width: 70%; margin: 0 auto;height: 150px;' alt='Image'></div>\n
        <div class='panel-footer'><b>Hurry, Only {$row->getQuantity()} left!!</b></div>\n
      </div>\n
    </div>\n
    <div class='col-sm-8'>\n
      <div class='panel panel-success'>\n
        <div class='panel-heading'>Description</div>\n
        <div class='panel-body'>{$row->getDescription()}</div>\n
          <div class='panel-footer'>Sale Price: \${$row->getSalePrice()} (Original Price: \${$row->getPrice()}).</div>\n
      </div>\n
     <form action='index.php?page=1' method='post' >\n
       <input type='hidden' name='item' value='{$row->getProductID()}' />\n
        <input type='hidden' name='item1' value='{$row->getProductName()}' />\n
       <input type='submit' class='btn btn-info' name='add' value='Add To Cart' />\n
    </form>\n
    </div>\n</div>\n";
            
         }
        
     }

    $htString  .= "</div><br>\n";
 
       
    $htString  .= "<div class='container'>\n
   <div class='row'>\n
    <div class='col-sm-12'>\n 
      <div class='panel panel-primary class'>\n    
         <div class='panel-heading' style='text-align:center;font-size:20px'>Catalog</div>\n   
      </div>
    </div>
 </div>";
    
// Display Data for Catalog Items    
    
     foreach($datap as $row)
     {
       
         
         $htString .= "<div class='row'>\n<div class='col-sm-4'>\n
     <div class='panel panel-primary'>\n
        <div class='panel-heading'>{$row->getProductName()}</div>\n
        <div class='panel-body' style='max-height:150px;padding-top:0px;'><img src='images/{$row->getImageName()}.jpg' class='img-responsive' style='width: 70%; margin: 0 auto;height: 150px;' alt='Image'></div>\n
        <div class='panel-footer'><b>Hurry, Only {$row->getQuantity()} left!!</b></div>\n
      </div>\n
    </div>\n
    <div class='col-sm-8'>\n
      <div class='panel panel-success'>\n
        <div class='panel-heading'>Description</div>\n
        <div class='panel-body'>{$row->getDescription()}</div>\n
          <div class='panel-footer'>Price: \${$row->getPrice()} </div>\n
      </div>\n
     <form action='index.php?page=1' method='post' >\n
       <input type='hidden' name='item' value='{$row->getProductID()}' />\n
       <input type='hidden' name='item1' value='{$row->getProductName()}' />\n
       <input type='submit' class='btn btn-info' name='add' value='Add To Cart' />\n
    </form>\n
    </div>\n</div>\n";
                
     }
   
    $htString  .= "</div><br>\n";
       
    return ($htString);
}

// Below function is used to get Page Number
function getPage()
{
    
    $pg = $GLOBALS['db']->getPageNumber();
    return $pg;
}

// Below functions is used to display Items from Cart

function displayCartItems($user)
{
    
    $data =  $GLOBALS['db']->getAllCarts(); 
    
     $Crt = "Sorry...No Items Available!!";   
   
 foreach($data as $row)
{
    if($row->getCartID()==$user)
  {
    
    $Crt = "Your Cart Items";
    break;
  }
}       
    
    
    $dataCatalog = array();     
   
    $htString = "<div class='row'>
    
    <div class='col-sm-10' style='margin-left:8.5%'> 
      <div class='panel panel-primary class'>    
         <div class='panel-heading' style='text-align:center;font-size:20px'>$Crt</div>   
      </div>
    </div>
 </div>";
    
    $totalCost = 0.00;
    
 //Display data from Cart
    
 foreach($data as $row)
{
    if($row->getCartID()==$user)
  {
       
   $htString .= "<div class='row'>\n
    
    <div class='col-sm-10' style='margin-left:8.5%'>\n 
      <div class='panel panel-success'>\n
          <div class='panel-heading' style='font-size:15px'><strong>{$row->getProductName()}</strong></div>\n
            <div class='panel-body'>{$row->getDescription()}</div>\n
          <div class='panel-footer'>Quantity ordered: 1 &nbsp;&nbsp;&nbsp;&nbsp; <strong>Total Cost: {$row->getPrice()}</strong>
        </div>\n
      </div>\n
    </div>\n
   </div>";  
     
     $totalCost += $row->getPrice();
    }
 }
    $htString .= "<div class='row'>  
    <div class='col-sm-10' style='margin-left:42%'>             
    <form action='cart.php?page=1' method='post' style='margin-bottom:2%'>
       <input type='submit' class='btn btn-info' name='remove' value='Empty Cart' />

        <span style='margin-left:27%;padding:1%;font-size:20px;color:white' class='label label-warning'>Total Price: \$$totalCost</span>
    </form>        
    </div>  
</div>";
    
    return ($htString);
}


// Below function is used to display Admin items
function adminItemsDisplay()
{
  
 $data =  $GLOBALS['db']->getAllProducts(); 
    
 $htString  = "<div class='container'>\n
              <form action='admin.php' method='post'>\n
     <div class='col-sm-11'>\n 
      <label for='sel1'>Select the Product to make changes: (Select one)</label>\n
      <select class='form-control' name='pickItem'>";
    
 $dataCatalog = array();     
    
    // Display data for Admin Product Selection
    
     foreach($data as $row)
     {
         $htString .=  "<option value='{$row->getProductID()}'>{$row->getProductName()}</option>\n";
         
     }
    
     $htString .= "</select><br>\n
                  </div><div class='col-sm-1'>\n 
    <input type='submit' class='btn btn-primary' name = 'change' value = 'change' style='margin-top:24px' value='Select'>\n
 </div>\n      
  </form>\n 
  </div>";
    
    return ($htString);
}

//Below function performs form validation and Sanitization

function formValidationSanitization($PName,$Desc,$Qty,$Price,$SPrice,$file)
    
{
   
    $res = array();
    $res['flag'] = 'true';
    
    $res['PNameErr'] =  $res['DErr'] = $res['PrcErr'] = $res['SPrcErr'] = $res['QtyErr'] = $res['FErr'] = "";   
    
    if (empty($PName)) 
   {
     $res['PNameErr'] = "Product Name is required.";
     $res['flag'] = 'false';
   } 
    else 
   {
    $fName = sanitizeString($PName);
        
    if($fName == "" || strlen($fName) > 500 || sqlInjection($fName) || sqlInjectionUnion($fName) ||
  		sqlInjectionSelect($fName) || sqlInjectionInsert($fName) || sqlInjectionDelete($fName) ||
  		 sqlInjectionUpdate($fName) || sqlInjectionDrop($fName) || crossSiteScripting($fName) ||
  		 crossSiteScriptingImg($fName)) 
     {
    	$res['PNameErr'] = 'You must enter a valid Product Name.';
        $res['flag'] = 'false';
     }
      
        
   }    
 
    if (empty($file)) 
   {
     $res['FErr'] = "Please upload File";
     $res['flag'] = 'false';
   } 
    
 
if (empty($Desc)) 
  {
     $res['DErr'] = 'Description of the Product is required';
     $res['flag'] = 'false';
  } 
    else 
  {
    $comments = sanitizeString($Desc);
        
    if(sqlInjection($comments) || sqlInjectionUnion($comments) ||
  		sqlInjectionSelect($comments) || sqlInjectionInsert($comments) || sqlInjectionDelete($comments) ||
  		 sqlInjectionUpdate($comments) || sqlInjectionDrop($comments) || crossSiteScripting($comments) ||
  		 crossSiteScriptingImg($comments)) 
    {
    	$res['DErr'] = 'Please enter valid description';
        $res['flag'] = 'false';
  	}
        
  } 
    
    if (empty($Qty)) 
   {
     $res['QtyErr'] = "Quantity is required.";
     $res['flag'] = 'false';
   } 
    else 
   {
    $fName = sanitizeString($Qty);
        
    if($fName == "" || !numbers($fName) || strlen($fName) > 30) 
     {
    	$res['QtyErr'] = 'You must enter a valid Quantity.';
        $res['flag'] = 'false';
     }
        
   }  
    
if (empty($Price)) 
   {
     $res['PrcErr'] = "Price is required.";
     $res['flag'] = 'false';
   } 
    else 
   {
    $fName = sanitizeString($Price);
        
    if($fName == "" || !numeric($fName) || strlen($fName) > 30) 
     {
    	$res['PrcErr'] = 'You must enter a valid Price.';
        $res['flag'] = 'false';
     }
        
   }  
    
if (empty($SPrice)&& !isset($SPrice)) 
   {
     $res['SPrcErr'] = "Sale Price is required.";
     $res['flag'] = 'false';
   } 
    else 
   {
    $fName = sanitizeString($SPrice);
        
    if($fName == "" || !numeric($fName) || strlen($fName) > 30) 
     {
    	$res['SPrcErr'] = 'You must enter a valid Sale Price.';
        $res['flag'] = 'false';
     }
        
   }  
   
    return ($res);
    
}


//Below function updates the existing item.
function updateItem($PName,$Desc,$Qty,$Prc,$SPrc,$PID,$img)
    
{
    
    $flds = array();
    $flds['PName'] = $PName;
    
    $flds['Desc'] = $Desc;
    
    $flds['Price'] = $Prc;
    
    $flds['SPrice'] = $SPrc;
    
    $flds['Qty']  = $Qty;
    
    $flds['Id'] = $PID;
    
    $flds['Img'] = $img;
    
    
    $data1 =  $GLOBALS['db']->update($flds); 
    
}


//Below function validates the login information
function validateUser($user,$pass,$type){
    
   $data2 = $GLOBALS['db']->userValidate($user);
    
    if(!empty($data2))
    {
    if($data2[0]->getUsername()==$user && $data2[0]->getPassword()==$pass && $data2[0]->getType()==$type){
        
        return 1;
    }
    else
        return 0;
    }
    else
        return 0;
}

// Below functions insert new product to cart.

function CartInsert($pid,$user)
{
    $data1 =  $GLOBALS['db']->getProductById($pid); 
    
    $GLOBALS['db']->insertCart($data1[0]->getProductName(),$data1[0]->getDescription(),$data1[0]->getQuantity(),$data1[0]->getPrice(),$user);
    
    return ($data1);
}

// It retrieves the item to edit
function getItemToEdit($pid)
{
    $data1 =  $GLOBALS['db']->getProductById($pid); 
    
    return ($data1); 
    
}

//it inserts the required product
function insertPro($ProductName,$Description,$Quantity,$Price,$SalePrice,$img)
    
{
   $img1 = substr($img,0, strrpos($img, '.'));
    
    $dat2 = $GLOBALS['db']->insertProduct($ProductName,$Description,$Quantity,$Price,$SalePrice,$img1);
    
}

// It updates the Quantity.
function updateQty($pid)
{
    $dat2 = $GLOBALS['db']->updQty($pid);
   
    
}

// It deletes the cart item of specified user.
function delCart($user)
{
    
    $dat2 = $GLOBALS['db']->deleteCart($user);
    
}


//Funtion to displays HTML Header
function head()
{
     $bigString = array();
    
    $bigString['header1'] = "<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Online Toys Market</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='style.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

</head>
<body>

<div class='jumbotron' style='padding:0px;background-color:#4F8571;margin-bottom:0px'>
  <div class='container text-center' style='background-color:#4F8571'>
      <h1><span style='color:#C49551'>Toys</span> World</h1>      
    <p style='color:white'>Where fun and learning never end</p>
  </div>
</div>

<nav class='navbar navbar-inverse'>
  <div class='container-fluid'>
    <div class='navbar-header'>
      <a class='navbar-brand' style='padding:0px;cursor:auto' href='#'><img src='images/logo.png' style='height:50px' /></a>
    </div>
    <div class='collapse navbar-collapse' id='myNavbar'>
      <ul class='nav navbar-nav'>";
    
     $bigString['header3'] = "<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Online Toys Market</title>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' href='style.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

</head>
<body>

<div class='jumbotron' style='padding:0px;background-color:#4F8571;margin-bottom:0px'>
  <div class='container text-center' style='background-color:#4F8571'>
      <h1><span style='color:#C49551'>Toys</span> World</h1>      
    <p style='color:white'>Where fun and learning never end</p>
  </div>
</div>";
    
    $bigString['header2'] = "<li> <a href='#' style='height:50px'> 
        <form action='login.php' method='post'>  
         <input style = 'color:black' type='submit' name='logout' value='Logout'/> 
        </form>
        </a>
    </li>    
      </ul>
    </div>
  </div>
</nav>";
    
    return $bigString;
    
}
  

// Function to display Html footer.
function Footer(){
    
    $BString = "<footer class='page-footer font-small blue pt-4 mt-4' style='margin-top:0%'>
    <div class='footer-copyright py-3 text-center'>
        © 2018 Copyright:
        <a href='https://serenity.ist.rit.edu/~mpn3885/server/Lab4/Project1/'> Online Toys Shopping </a>
    </div>   
</footer>
</body>
</html>";
    
    return $BString;
}

?>  