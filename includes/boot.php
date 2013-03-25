<?php
/**
 * boot.php
 */
include('includes/classes/Factory.php');

Factory::inc('includes::classes::Registry');
Factory::inc('includes::config');
Factory::inc('includes::classes::Controller');
Factory::inc('includes::classes::Command');

Controller::Run();


?>