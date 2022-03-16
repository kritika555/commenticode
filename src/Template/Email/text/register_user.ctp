Hi There,

Thanks for registering with us. Please follow the below link to verify your account: 
URL: <?php echo $this->Url->build(["controller" => "Users", "action" => "verify",$user->verification_token],true); ?>

<?php echo $this->element('email_signature_text');?>