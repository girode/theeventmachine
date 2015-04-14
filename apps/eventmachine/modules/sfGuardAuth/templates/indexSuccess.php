<?php use_stylesheet('main.css') ?>
<?php use_helper('I18N') ?>

<?php slot('signin_form') ?>

<form class="navbar-form navbar-right" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">    
    <?php echo $form ?>    
    <input type="submit" class="form-control" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
</form>

<?php end_slot() ?>

<div class="jumbotron jumbotron-main">
  <div class="container">
    <h1>The Event Machine</h1>
    <h2>Scheduling System</h2>
    <p>Agendas made simple</p>
  </div>
</div>

