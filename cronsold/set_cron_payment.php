<?php

namespace App\Controller;
require dirname(__DIR__) . ‘/vendor/autoload.php’;
use App\Controller\AppController;
use App\Controller\PaymentController; 
use Cake\Core\Configure;

if (!defined(‘DS’)) {
    define(‘DS’, DIRECTORY_SEPARATOR);
} 
  require_once(dirname(dirname(__FILE__)).DS.’config’.DS.’bootstrap.php’);
  require_once(dirname(dirname(__FILE__)).DS.’src’.DS.’Controller’.DS.’AppController.php’);

  $PaymentController = new PaymentController();
   //$securityHash = Configure::read(‘cronValidationToken’); // send a security hash so that will only be sent from cron
  $PaymentController->payWinnersWeekly();
  
    $PaymentController->test_cron();

