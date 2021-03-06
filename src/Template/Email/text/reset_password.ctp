<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

Hi <?=$user['first_name'] ?>,
Please <?php echo $this->Html->link('click here', ['controller'=>'Users','action'=>'reset_password',$token,'_full' => true]); ?> to reset your password to <?=$siteTitle?> Admin.

<?php echo $this->element('email_signature_text');?>
