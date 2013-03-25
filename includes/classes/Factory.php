<?php

class Factory {


static public function inc( $file_name ) { 
	// ist $class_name überhaupt gültig 
 	if( ! is_string( $file_name ) || ! trim( $file_name ) ) { 
 		throw new Exception( 'kein gültiger Klassenname' ); 
 	} 
 	// gibt es die Klasse überhaupt  
 	//$xxx=self::path();
 	$include_file =str_replace( '::', '/' , $file_name ).'.php';
  	if( ! file_exists( $include_file ) ) { 
  			echo "File not found: ".$include_file;
  			throw new Exception( 'Datei nicht gefunden: '.$e->getMessage() ); 
  		} 
  	else {
  		//echo "OK";
  		require_once($include_file); // Objekt bauen  
  	}

}
/** 
* statische Methode zum bauen neuer Objekte, 
* inklusive Fehlerbehandlung 
* und variablen Klassenpfad sowie einer Paketverwaltung * 
* @param string $class_name - Paket::Klassenname des gewünschten Objektes 
* @param array $params - Parameter für den Konstruktor der Klasse 
* @return object vom Typ $class_name 
**/
static public function get( $class_name, $params = null ) { 
	// ist $class_name überhaupt gültig 
 	if( ! is_string( $class_name ) || ! trim( $class_name ) ) { 
 		throw new Exception( 'kein gültiger Klassenname' ); 
 	} 
 	
 	self::inc($class_name);
 	// gibt es die Klasse überhaupt  
 	/*
 	$file = _CLASS_PATH_.strtolower(str_replace( '::', DIRECTORY_SEPARATOR , $class_name ).'.php' );
  	if( ! file_exists( $file ) ) { 
  			echo "FNF";
  			throw new Exception( 'Datei nicht gefunden: '.$e->getMessage() ); 
  		} 
  	else {
  		
  		require_once($file); // Objekt bauen
  		 
  	}*/
  	try{ 
  		// erstmal den Namen vom Paket trennen  
  		 
  		$tmp = explode( '::', $class_name ); 
  		
  	        $name = array_pop( $tmp ); 
  		// Objekt bauen  
  		 
  		$obj = new $name( $params ); 
  		 
  	}
  	catch( Exception $e ) { 
  		// ein Fehler innerhalb der anderen Klasse,   
  		// wir hängen die andere Meldung mit an  
  		throw new Exception( 'Fehler beim Konstruieren des Objektes: '.$e->getMessage() ); 
  	} 
  	// fertiges Objekt zurückgeben  
  	return $obj; 
  } 
} 

  // Benutzung des Factory Pattern 
  // Pfad festlegen für die Klassen 
/*
  define( '_CLASS_PATH_', 'C:\\Apache2\\htdocs\\profiler\\p\\profiler\\includes\\classes\\' );
  // Objekt bauen 
  
  try { 
  // bindet die Klasse "/var/www/class/meinpaket/meineklasse.class.php" ein  
  //$test1 = Factory::get( 'MeinPaket::MeineKlasse' ); 
  echo "DEBUG<br />";
  $test1 = Factory::get( 'profiler::profiler' ); 
  
  echo $test1;
  // bindet die Klasse "/var/www/class/meinpaket/unterpakte/meineklasse2.class.php" ein  
  //$test2 = Factory::get( 'MeinPaket::UnterPaket::MeineKlasse2' ); 
  }catch( Exception $e ) 
  { 
  	echo $e->getMessage(); 
  }
 /* 
  $test = Factory::get( 'Profiler::Profiler' ); 
  
  


  Factory::load('Registry::Registry');
  registry::set('test', 'Ich bin ueberall verfuegbar.');
  $x=registry::get('test'); 

 print_r($test->path_stat(__FILE__));
*/
?>