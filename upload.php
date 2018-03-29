<?php
//Function to upload the file.

function uploadProcess($files)
{

$status = array();
    $status['success'] = "";
    $status['err'] = "";
    $status['flag'] = "";
    
define ('SITE_ROOT', realpath(dirname(__FILE__)));

//check that we have a file
if((!empty($files["FileUpload"])) && ($files['FileUpload']['error'] == 0)) {
    
  //Check if the file is JPEG image and it's size is less than 4MB
  
  $filename = basename($files['FileUpload']['name']);
  
  $ext = substr($filename, strrpos($filename, '.') + 1);
    
  if (($ext == "jpg") && ($files["FileUpload"]["type"] == "image/jpeg") && 
    ($files["FileUpload"]["size"] < 4500000)) {
    //Determine the path to which we want to save this file
      $newname = SITE_ROOT.'/images/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($files['FileUpload']['tmp_name'],$newname))) {
           $status['success'] = "File Uploaded Successfully!!";
            $status['flag'] = 'true';
        } else {
           $status['err'] = "A problem occurred during file upload!";
             $status['flag'] = 'false';
        }
      } else {
         $status['err'] = "File ".$files["FileUpload"]["name"]." already exists";
           $status['flag'] = 'false';
      }
  } 
    
} else {
           $status['err'] = "No file uploaded";
            $status['flag'] = 'false';
           $json = array();
           $json['msg'] = $status['err'];
           $json['error'] = '';
}
    
    return $status;

}

?>