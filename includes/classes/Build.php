<?php

  interface observer {
    public function update(Observeable $Subject);
  }
  
  interface observeable {
    public function attach(Observer $Observer);
    public function detach(Observer $Observer);
    public function notify();
  }
  
   interface Cmd_ICommand {
         public function process();
         // public function undo();
   }
   
  class BuildControl implements observeable 
  {
   private $_Observers = Array();
   
   public function attach(Observer $Observer)
   {
     $this->_Observers[] = $Observer;
   }
   public function detach(Observer $Observer)
   {
     $this->_Observers = array_diff($this->_Observers, Array($Observer));
   }
   public function notify()
   {
     foreach($this->_Observers as $Observer)
        $Observer->update($this);
   }  
  }
   
  
   class Build extends BuildControl
   {
   
    public $Template;
    
    private $_cmd_stack = array();
  
    public function add(Cmd_ICommand $c)
    {
          $this->_cmd_stack[] = $c;
    }
  
    public function make()
    {
     $this->notify();
     // iterator $it
     
     foreach ($this->_cmd_stack as $it) {
         $it->process();
     }
    }
   }
  
 
?>