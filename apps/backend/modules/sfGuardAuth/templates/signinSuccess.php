<?php use_stylesheet('/css/backend/sign_in') ?>
<?php use_helper('I18N') ?>

<div class="container">
    <?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div> 