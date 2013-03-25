<?php
  /**
   * Registry class to pass global variables between classes.
   */
  abstract class Registry
  {
  	   public static $reg_message="";
      /**
       * Object registry provides storage for shared objects
       *
      * @var array 
      */
     private static $registry = array();
     
     /**
      * Adds a new variable to the Registry.
      *
      * @param string $key Name of the variable
      * @param mixed $value Value of the variable
      * @throws Exception
      * @return bool 
      */
     public static function set($key, $value) {
         try {
	     	 if (!isset(self::$registry[$key])) {
	             self::$registry[$key] = $value;
	             return true;
	         } else {
	             throw new Exception('Unable to set registry-variable `' . $key . '` as `' . $value . '`. It was already set as `' . self::get($key) . '`.');
	         }
         }
         catch (Exception $e) {
         	self::$reg_message.=$e->getMessage()."<br />";
         	//$system->messenger($reg->getMsg());
         }
         
     }
  
     /**
      * Returns the value of the specified $key in the Registry.
      *
      * @param string $key Name of the variable
      * @return mixed Value of the specified $key
      */
     public static function get($key)
     {
         if (isset(self::$registry[$key])) {
             return self::$registry[$key];
         }
         return null;
     }
  
     /**
      * Returns the whole Registry as an array.
      *
      * @return array Whole Registry
      */
     public static function getAll()
     {
         return self::$registry;
     }
  
     /**
      * Removes a variable from the Registry.
      *
      * @param string $key Name of the variable
      * @return bool
      */
     public static function remove($key)
     {
         if (isset(self::$registry[$key])) {
             unset(self::$registry[$key]);
             return true;
         }
         return false;
     }
  
     /**
      * Removes all variables from the Registry.
      *
      * @return void 
      */
     public static function removeAll()
     {
         self::$registry = array();
         return;
     }
     
     public static function get_Reg_Msg() {
     	return self::$reg_message;
     }
 }
 

 

// Regs::set('test', 'Ich bin ueberall verfuegbar.');
 

 
 /*
 //echo Registry::msg;
 $reg=new registry();
 $reg->set('title','PDP - PHP Design Patterns');
 echo $reg->get('title');
 $reg->set('title','PEPERS');
 echo $reg->get('title');
 echo $reg->getMsg();
*/ 
 ?>