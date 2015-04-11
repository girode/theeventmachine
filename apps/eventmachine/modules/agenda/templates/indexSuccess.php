<?php use_stylesheet('fullcalendar.min.css') ?>
<?php use_javascript('fullcalendar.min.js') ?>

<div class="page-header">
    <h1>Agenda de <?php echo $usuario?></h1>
</div>

<?php include_partial('agenda', array('eventos' => $eventos)); ?>
<?php include_partial('event_form_modal', array('form' => $form)); ?>


