<div class="top-header menu-fixed">
    <div class="container mob-nospace">
        <div class="row module-space-xs">
            <div class="col-xs-6 col-sm-4"><?php echo $this->Html->link('<h1 class="site-title">'.$siteTitle.'</h1>', ['controller' => 'Users', 'action' => 'home'], ['escape' => false]); ?></div>
            <div class="col-xs-6 col-sm-8 menu-container">
                <?php if (isset($authUser['email'])) { ?>
                    <h2 class="user-menu hidden-xs">Hello, <?= $authUser['email'] ?></h2>
                <?php } else { ?>
				<h2 class="user-menu hidden-xs"><?php echo $this->Html->link('Sign In', ['controller' => 'Users', 'action' => 'login']); ?></h2>
				<?php }?>
               	
            </div>
        </div>
    </div>
</div>
