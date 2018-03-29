<?php
  class Cart {
   
    private $Description;
    private $ProductName;
    private $Price;
    private $Quantity;
    private $CartID;
      
    public function getDescription(){ return $this->Description;  }  
               
    public function getProductName(){ return $this->ProductName;  }  
            
    public function getPrice(){ return $this->Price;  }  
          
    public function getQuantity(){ return $this->Quantity;  }  
      
    public function getCartID(){ return $this->CartID;  }  
        
       
}

 ?>