<?php

require_once("LIB_project1.php");

require_once("upload.php");

session_name("Login");

session_start();

if(empty($_SESSION['name']))
{
$_SESSION['Oimage'] = "";
}

if(!empty($_SESSION['name']))
{
 $Oimage = $_SESSION['Oimage'];
}

$Head = head();

echo $Head['header1'];

?>



        <li><a href="index.php">Home</a></li>
        <li><a href="cart.php">Cart</a></li>
     <?php if($_SESSION['type'] == 'admin') {?>  
        <li class="active"><a href="admin.php">Admin</a></li>
     <?php }?>
          <li> <a href="#" style="color:white;margin-left:10%;font-size:15px"><strong><i>Welcome <?php echo $_SESSION['username']; ?></i></strong></a>
              
          </li>  
   
<?php  
     echo $Head['header2'];
?>
   

<div class="container">
  <div class='panel panel-primary class'>    
         <div class='panel-heading' style='text-align:center;font-size:20px'>Admin Page</div>   
      </div>
</div>
        
 
<?php    

$data10 = array(); 
    
    
$data10['PNameErr'] =  $data10['DErr'] = $data10['PrcErr'] = $data10['SPrcErr'] = $data10['QtyErr'] ="";  
    
$data11 = array(); 
    
$data11['PNameErr'] =  $data11['DErr'] = $data11['PrcErr'] = $data11['SPrcErr'] = $data11['QtyErr'] ="";     
    
$status = array();   
$status['success'] = "";
    
   // To upload the image on form submit
  if(isset($_POST['submit']) && isset($_FILES['FileUpload'])){
      
     $status = uploadProcess($_FILES);
      
  }   
    

   // When any new item is added.
    if(isset($_POST['submit'])) 
{
        
    $data10 = formValidationSanitization($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],$_FILES['FileUpload']['name']);
        
   if($data10['flag']=='true' && isset($_POST['submit']) && $status['flag']=='true')
    {  
     
      if($_POST['SalePrice']!=0 && $_SESSION['saleCount'] < 5)
      {
        $_SESSION['saleCount']++;
         
         insertPro($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],basename($_FILES['FileUpload']['name']));  
          
        echo "<h4 style='color:green'>Product {$_POST['ProductName']} added Succesfully!!</h4>";
      }
       else if($_POST['SalePrice']!=0 && $_SESSION['saleCount'] >= 5)
       {
           echo "<h4 style='color:red'>Sorry!!...Maximum of 5 items could be on Sale at a Time!!</h4>";
       }
       
       else
        {
            insertPro($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],basename($_FILES['FileUpload']['name'])); 
           
           echo "<h4 style='color:green'>Product {$_POST['ProductName']} added Succesfully!!</h4>";
            
        }
       
    }
       
}
    
// To update the existing product
  if(isset($_POST['update'])) 
{
        
    $data11 = formValidationSanitization($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],$Oimage);    
      
    if(isset($_FILES['FileUpload']))
    {
       print_r($_FILES['FileUpload']);
        
        $Oimage = basename($_FILES['FileUpload']['name']);
        
         $status1 = uploadProcess($_FILES);
    
         $Oimage = substr($Oimage,0, strrpos($Oimage, '.'));
        
      
    if($data11['flag']=='true' && $status1['flag']=='true')
    {
       updateItem($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],$_POST['ProductID'],$Oimage);
        
        echo "<h4 style='color:green'>Product {$_POST['ProductName']} updated Succesfully!!</h4>";
    }
    
 }
      else
      {
           if($data11['flag']=='true')
       {
                $data15 = getItemToEdit($_POST['ProductID']);
               
               if($_POST['SalePrice']==0 && $data15[0]->getSalePrice()!=$_POST['SalePrice']){
                   $_SESSION['saleCount']--;
        
               }
               
               if($_POST['SalePrice']!=0 && $data15[0]->getSalePrice()!=$_POST['SalePrice']){
                   $_SESSION['saleCount']++;
        
               }
               
         if($_SESSION['saleCount']>=3 && $_SESSION['saleCount']<=5)
           { updateItem($_POST['ProductName'],$_POST['description'],$_POST['Quantity'],$_POST['Price'],$_POST['SalePrice'],$_POST['ProductID'],$Oimage);
            
            echo "<h4 style='color:green'>Product {$_POST['ProductName']} updated Succesfully!!</h4>";
          }
         else if($_SESSION['saleCount']<3){
             $_SESSION['saleCount']++;
             echo "<h4 style='color:red'>Sorry!!...Cant remove this Item from Sale (min 3 required)</h4>";
         }
          else{
               $_SESSION['saleCount']++;
              echo "<h4 style='color:red'>Sorry!!...Maximum of 5 items could be on Sale at a Time!!</h4>";
          }    
        }
          
      }
   
}
    
 echo adminItemsDisplay();
    
     if(isset($_POST['change']))
     {
         $data5 = getItemToEdit($_POST['pickItem']);
         $_SESSION['name'] = 'admin';
         
        $_SESSION['Oimage'] = $data5[0]->getImageName();
     }
    
?>      
   


<?php  if(isset($_POST['change']) || isset($_POST['update'])) { ?> 
    
<div class="container">    
    <div class="col-sm-8" style="border:solid 1px grey; border-radius: 1%; background-color:#9EF5FF;margin-bottom:2%"> 
           <strong><h4 style="padding-bottom:0px;color:blue">Update Existing Item</h4></strong>
			<form  action="admin.php" method="post">
				<div class="row" style = "padding:5px;padding-top:5px" >
					<label class="col-sm-3" >Product Name:</label>
                    <input type="hidden" name="ProductID" value="<?php if(isset($_POST['change'])){echo $data5[0]->getProductID();} ?>"/>
		            <input type="text" name="ProductName" id="first_name" class="col-sm-6" value = "<?php if(isset($_POST['update'])){echo $_POST['ProductName'];} if(isset($_POST['change'])){echo $data5[0]->getProductName();} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data11['PNameErr'] ?></span>
		        </div>  
                
               <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3" >Description:</label>
		            <textarea class="col-sm-6" rows="5" name="description"><?php if(isset($_POST['update'])){echo $_POST['description'];} if(isset($_POST['change'])){echo $data5[0]->getDescription();} ?></textarea><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data11['DErr'] ?></span>
		        </div>  
                
              <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Price:</label>
		            <input type="text" name="Price" class="col-sm-6" value = "<?php if(isset($_POST['update'])){echo $_POST['Price'];}if(isset($_POST['change'])){echo $data5[0]->getPrice();} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data11['PrcErr'] ?></span>
		        </div>  
                
              <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Sale Price:</label>
		            <input type="text" name="SalePrice" class="col-sm-6" value = "<?php if(isset($_POST['update'])){echo $_POST['SalePrice'];} if(isset($_POST['change'])){echo $data5[0]->getSalePrice();} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data11['SPrcErr'] ?></span>
		        </div> 
            <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Quantity:</label>
		            <input type="text" name="Quantity" class="col-sm-6" value = "<?php if(isset($_POST['update'])){echo $_POST['Quantity'];}if(isset($_POST['change'])){echo $data5[0]->getQuantity();} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data11['QtyErr'] ?></span>
		        </div>  
                
                 <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Upload Image:</label>
                    <input name="FileUpload" id="FileUpload" type="file" /><span style = "color:red;padding-left:3px;"><?php if(!empty($status1['err'])) {echo ' '.$status1['err'];}?></span>
                </div>
                
                <div class="row" style = "padding:5px;padding-top:10px;padding-bottom:30px;text-align:center" >
		            <button type="button" value="reset" class="btn btn-default" onclick = "window.location.href='admin.php'">Reset Form</button>
		            <button class="btn btn-primary" type="submit" name="update" value="update" class="btn btn-default">Submit Changes</button>
		        </div>
                
            </form>
    </div>
       
</div>    
        
<?php } ?>    
    
<div class="container" style="margin-bottom:2%">
         <div class="col-sm-8" style="border:solid 1px grey; border-radius: 1%; background-color:#9EF5FF"> 
             <strong><h4 style="padding-bottom:0px;color:blue">Add New Item</h4></strong>
			<form  action="admin.php" method="post">
				<div class="row" style = "padding:5px;padding-top:5px" >
					<label class="col-sm-3" style="padding-left:3px">Product Name:</label>
		            <input type="text" name="ProductName" id="first_name" class="col-sm-6" value = "<?php if(isset($_POST['submit'])){echo $_POST['ProductName'];} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data10['PNameErr'] ?></span>
		        </div>  
                
               <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3" >Description:</label>
		            <textarea class="col-sm-6" rows="5" name="description"><?php if(isset($_POST['submit'])){echo $_POST['description'];} ?></textarea><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data10['DErr'] ?></span>
		        </div>  
                
              <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Price:</label>
		            <input type="text" name="Price" class="col-sm-6" value = "<?php if(isset($_POST['submit'])){echo $_POST['Price'];} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data10['PrcErr'] ?></span>
		        </div>  
                
              <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Sale Price:</label>
		            <input type="text" name="SalePrice" class="col-sm-6" value = "<?php if(isset($_POST['submit'])){echo $_POST['SalePrice'];} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data10['SPrcErr'] ?></span>
		        </div> 
              <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Quantity:</label>
		            <input type="text" name="Quantity" class="col-sm-6" value = "<?php if(isset($_POST['submit'])){echo $_POST['Quantity'];} ?>"/><span style = "color:red;padding-left:3px;">*<?php echo ' '.$data10['QtyErr'] ?></span>
		        </div>
                
                 <div class="row" style = "padding:5px;padding-top:10px" >
					<label class="col-sm-3">Upload Image:</label>
                    <input name="FileUpload" id="FileUpload" type="file" /><span style = "color:red;padding-left:3px;"><?php if(!empty($status['err'])) {echo ' '.$status['err'];} if (!empty($data10['FErr'])){echo ' '.$data10['FErr'];} ?></span>
                </div>
                 
                <div class="row" style = "padding:5px;padding-top:10px;padding-bottom:30px;text-align:center" >
		            <button type="button" value="reset" class="btn btn-default" onclick = "window.location.href='admin.php'">Reset Form</button>
		            <button class="btn btn-primary" type="submit" name="submit" value="submit" class="btn btn-default " onclick="javascript: form.action='admin.php'; form.enctype='multipart/form-data';">Submit Item</button>
		        </div>
                
            </form>
    </div>
    </div>  
    
<?php  
  echo  Footer();
?>

