<?php

abstract class Command {
  final function __construct() { }

  final function execute( $request ) {
    $this->doExecute( $request );
  }

  abstract function doExecute( $request );
}