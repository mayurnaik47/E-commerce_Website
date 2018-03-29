<?php

class DB{
  private $dbh; 
  private $mysq;
   
    //Constructor for PDO DB connections
  function __construct() {
    try {
        $this->dbh = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}",$_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOexception $e) {
      echo($e->getMessage());
      die();
    }
  }
    

// To retrieve all the products from database.    
function getAllProducts() {
  try {
    include_once "Products.class.php";
    $data = array();
    $stmt = $this->dbh->prepare("select * from products");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Products");
    while($product=$stmt->fetch())
    {
      $data[]=$product;
    }
    return $data;
  }catch(PDOexception $e) {
    echo $e->getMessage();
    die();
  }
}
 
// To retrieve all the products from cart.        
function getAllCarts() {
  try {
    include_once "Cart.class.php";
    $data = array();
    $stmt = $this->dbh->prepare("select * from cart");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Cart");
    while($product=$stmt->fetch())
    {
      $data[]=$product;
    }
    return $data;
  }catch(PDOexception $e) {
    echo $e->getMessage();
    die();
  }
}    
    
// To retrieve the product for particular ID.        
function getProductById($id) {
    try {
      include_once "Products.class.php";    
      $data = array();
      $stmt = $this->dbh->prepare("select * from products where ProductID = :id");
      $stmt->execute(array("id"=>$id));
      $stmt->setFetchMode(PDO::FETCH_CLASS,"Products");
      while($row = $stmt->fetch()){
        $data[] = $row;
      }
   
      return $data;
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
    }
  }   
   
//To Validate the aunthenticated user from database.     
function userValidate($username) {
    try {
      include_once "Users.class.php";    
      $data = array();
      $stmt = $this->dbh->prepare("select * from users where username = :name");
      $stmt->execute(array("name"=>$username));
      $stmt->setFetchMode(PDO::FETCH_CLASS,"Users");
      while($row = $stmt->fetch()){
        $data[] = $row;
      }
   
      return $data;
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
    }
  }      
    
    
// To get the total number of pages used in Pagination    
function getPageNumber(){
    
  try {
    include_once "Products.class.php";
    $total_results1 = 0;
    $stmt = $this->dbh->prepare("select * from products");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Products");
    while($product=$stmt->fetch())
    {
      $total_results1 +=1;
    }
    
  }catch(PDOexception $e) {
    echo $e->getMessage();
    die();
  }  
    
$Pages = ceil($total_results1/5);  
    
    return $Pages;
    
    
}
    
    
// To implement pagination functionality.    
function pagination($page,$lmt)
{       
        
try {
    include_once "Products.class.php";
    $total_results = 0;
    $stmt = $this->dbh->prepare("select * from products");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Products");
    while($product=$stmt->fetch())
    {
      $total_results +=1;
    }
    
  }catch(PDOexception $e) {
    echo $e->getMessage();
    die();
  }  
    
$total_pages = ceil($total_results/$lmt);       

$starting_limit = ($page-1)*$lmt;
    
try {
    $data = array();
    $stmt = $this->dbh->prepare("select * from products WHERE SalePrice = 0 ORDER BY ProductName ASC LIMIT $starting_limit, $lmt");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS,"Products");
    while($product=$stmt->fetch())
    {
      $data[]=$product;
    }
    return $data;
  }catch(PDOexception $e) {
    echo $e->getMessage();
    die();
  }    
               
}
  
//To Insert an Item in Cart.    
 function insertCart($ProductName,$Description,$Quantity,$Price,$user){
    try{
        $stmt = $this->dbh->prepare("insert into cart(ProductName,Description,Quantity,Price,CartID) values(:pName,:Desc,:Quan,:Pric,:CID)");
        $stmt->execute(array("pName"=>$ProductName,"Desc"=>$Description,"Quan"=>$Quantity,"Pric"=>$Price,"CID"=>$user));
        return $this->dbh->lastInsertId();
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
  }
}   
   
// To insert a product in cart.
function insertProduct($ProductName,$Description,$Quantity,$Price,$SalePrice,$img){
    try{
        $stmt = $this->dbh->prepare("insert into products(ProductName,Description,Quantity,Price,SalePrice,ImageName) values(:pName,:Desc,:Quan,:Pric,:SaleP,:ImageN)");
        $stmt->execute(array("pName"=>$ProductName,"Desc"=>$Description,"Quan"=>$Quantity,"Pric"=>$Price,"SaleP"=>$SalePrice,"ImageN"=>$img));
        return $this->dbh->lastInsertId();
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
  }
} 
  
//To Delete items from cart based on User.    
function deleteCart($user){
 try{
        $stmt = $this->dbh->prepare("DELETE FROM cart where CartID = :name");
        $stmt->execute(array("name"=>$user));
        return true;
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
  }
}   
  
//To Update the Qty     
function updQty($pid){
    
    $dat = $this->getProductById($pid);
    
    $qty = $dat[0]->getQuantity()-1;
    
    if ($qty==-1){
        echo "<h3 style='color:red;padding-left:50px'>Sorry....Item <i>'{$dat[0]->getProductName()}'</i> is currently Out of Stock !!!</h3>";
        return false;
    }
    else {
        
        echo "<h3 style='color:green;padding-left:50px'> Item <i>'{$dat[0]->getProductName()}'</i> Successfully added to Cart !!!</h3>";
        
    }
   try{
        $stmt = $this->dbh->prepare("UPDATE products SET Quantity='$qty' WHERE ProductID=$pid");
        $stmt->execute();
        return $dat;
    }catch(PDOexception $e) {
      echo $e->getMessage();
      die();
  }     
}
    
// Update Item Description from Porduct Table. For Admin use only    
function update($fields) {
    $queryString = "update products set";
    $insertId = 0;
    $numRows = 0;
    $items = array();
    $types = "";
    
   foreach($fields as $k=>$v){

     switch($k)  {
     case "PName" : 
          $queryString .= " ProductName = :PName,";
          $items[] = &$fields[$k];
          $types .= "s";
          break;
      case "Desc" : 
          $queryString .= "Description = :Desc,";
          $items[] = &$fields[$k];
          $types .= "s";
          break;
      case "Price" : 
          $queryString .= "Price = :Price,";
          $items[] = &$fields[$k];
          $types .= "i";
          break;  
     case "SPrice" : 
          $queryString .= "SalePrice = :SPrice,";
          $items[] = &$fields[$k];
          $types .= "i";
          break; 
     case "Qty" : 
          $queryString .= "Quantity = :Qty,";
          $items[] = &$fields[$k];
          $types .= "i";
          break;
     case "Img" : 
          $queryString .= "ImageName = :Img,";
          $items[] = &$fields[$k];
          $types .= "s";
          break; 
     case "Id":
          $insertId = intval($fields[$k]);
          break;    
          
     } //switch
   
   } //foreach
   $queryString = trim($queryString,",");
   $queryString .= " where ProductID = :Id";
   $types .= "i";
   $items[] = &$insertId;

    if($stmt = $this->dbh->prepare($queryString)) {
      
      foreach($fields as $k=>$v)
      {
          //echo ':'.$k.'=>'.$v;
          $stmt->bindParam(':'.$k,$v);
          
          
      }
        
       $stmt->execute($fields);
    
    }

  
  }//update
    
        
}
?>
