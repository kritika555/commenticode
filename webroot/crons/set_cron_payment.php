<?php

namespace App\Controller;
use App\Controller\AppController;

use App\Controller\PaymentController; 

use Cake\Core\Configure;
$dirname ='/home/commbsvl/public_html';
require ($dirname . '/vendor/autoload.php');

if (!defined('DS')) { 
    define('DS', DIRECTORY_SEPARATOR);
} 
  require_once('/home/commbsvl/public_html/config/bootstrap.php');

  require_once('/home/commbsvl/public_html/src/Controller/AppController.php');
  $paymentController = new PaymentController();
   //$securityHash = Configure::read(‘cronValidationToken’); // send a security hash so that will only be sent from cron

 $paymentController->payWinnersWeekly();
 //$paymentController->test();
  
?>
 