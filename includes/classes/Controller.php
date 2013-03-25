<?php

class Controller {
  public static function Run() {
    $request_method =	$_SERVER['REQUEST_METHOD'];
    //$request_method = '_'.$request_method;
    //$request_method ${$request_method};
    //echo $request_method['com'];
    include("DataCheck.php");
    $data=new DataCheck();
    $data->requestcleaner();
    
    $r='_'.$request_method;
    global $$r;
    //var_dump($r);
    if (isset(${$r}['com'])){
    $command = self::getCommand(${$r}['com']);
    }
    else 
    $command = self::getCommand('Index');  
    //Registry::set('request',${$r});  
    $command->execute(${$r});
  }

  public static function getCommand( $command ) {
    $command = preg_replace('/[^a-zA-Z0-9]/', '', $command);
    $commandClass = ucfirst($command) . 'Command';
    $commandFile  = $commandClass . '.php';

    if($command != '' && file_exists('includes/classes/'.$commandFile)) {
      include($commandFile);

      if(class_exists($commandClass)) {
        return new $commandClass();
      }
    }

    include('IndexCommand.php');
    return new IndexCommand();
  }
}