<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php // include_http_metas() ?>
    <?php // include_metas() ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>

   <body>
       
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="#" class="navbar-brand">The Event Machine</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            
            <?php if ($sf_user->isAuthenticated()): ?>
                <li class="dropdown">
                  <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">Options <span class="caret"></span></a>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="#">Hide header</a></li>
                    <li><a href="#">Edit user data</a></li>
                    <li><a href="#">Etc</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
            <?php endif;?>
          </ul>
          <!-- signIn/signOut form/links -->  
          <?php if ($sf_user->isAuthenticated()): ?>
              <p class="navbar-text navbar-right">
                  Signed in as <a href="#" class="navbar-link"><?php echo $sf_user->getName() ?></a>
                  (<?php echo link_to('Salir', '@sf_guard_signout', array('class' => 'navbar-link')) ?>)
              </p>
          <?php else: ?>
              <?php if (has_slot('signin_form')): ?>
                <?php include_slot('signin_form') ?>
              <?php endif; ?>
          <?php endif;?>
          
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <!-- Begin page content -->
    <div class="container">
        <?php echo $sf_content ?>
    </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Por Gabriel Rode. 2015</p>
      </div>
    </footer>   
       
  </body>
</html>


