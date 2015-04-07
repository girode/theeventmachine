<?php use_helper('I18N') ?>

<div class="jumbotron">
  <h1>Welcome to the Event Machine Scheduling System</h1>
  <p>Your agenda made Simple</p>
</div>

<?php slot('signin_form') ?>

<form class="navbar-form navbar-right" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">    
    <?php echo $form ?>    
    <input type="submit" class="form-control" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
</form>

<?php end_slot() ?>