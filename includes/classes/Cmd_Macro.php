<?php
interface Cmd_ICommand {
         public function process();
         // public function undo();
 };
  class Cmd_Macro
  {
    private $_commands = array();
  
    public function add(Cmd_ICommand $c)
    {
          $this->_cmd_stack[] = $c;
    }
  
   public function make()
   {
     // iterator $it
     foreach ($this->_cmd_stack as $it) {
         $it->process();
     }
   }
 };
 
  class Hello implements Cmd_ICommand 
  {
          public function process() 
          {
                  echo "Hello ";
          }
  };
  
 class World implements Cmd_ICommand 
 {
         public function process() 
         {
                 echo "World!\n";
         }
 };
 
 $macro = new Cmd_Macro();
 
 $macro->add(new Hello);
 $macro->add(new World);
 $macro->make();
 ?>