<?php
  class Products {
    private $ProductID;
    private $Description;
    private $ProductName;
    private $Price;
    private $Quantity;
    private $ImageName;
    private $SalePrice;

   
    public function getProductID() { return $this->ProductID;  }  
               
    public function getDescription(){ return $this->Description;  }  
               
    public function getProductName(){ return $this->ProductName;  }  
            
    public function getPrice(){ return $this->Price;  }  
          
    public function getQuantity(){ return $this->Quantity;  }  
        
    public function getImageName(){ return $this->ImageName;  }  
      
    public function getSalePrice(){ return $this->SalePrice;  }    
   
      
  
  }
 ?>