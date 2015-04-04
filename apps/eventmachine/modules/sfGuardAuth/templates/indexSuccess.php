<?php use_helper('I18N') ?>

define some beautiful content for site

<?php slot('signin_form') ?>

<form class="navbar-form navbar-right" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">    
    <?php echo $form ?>    
    <input type="submit" class="form-control" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
</form>

<?php end_slot() ?>