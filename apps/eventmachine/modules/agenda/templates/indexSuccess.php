<?php use_stylesheet('fullcalendar.min.css') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascript('fullcalendar.min.js') ?>
<?php use_javascripts_for_form($form)?>
<?php use_helper('I18N') ?>

<div class="container">
<!--    <div class="page-header">
        <h1>Agenda de <?php //echo $usuario?></h1>
        TODO: Verificar cultura
        <?php // echo __("hola"); ?>
    </div>-->
    
    <?php include_partial('agenda', array('eventos' => $eventos)); ?>
    <?php include_partial('event_form_modal', array('form' => $form)); ?>
    <?php include_partial('errores'); ?>
</div>


