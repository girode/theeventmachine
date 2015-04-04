<?php use_stylesheet('fullcalendar.min.css') ?>
<?php use_javascript('fullcalendar.min.js') ?>

<div class="page-header">
    <h1>Agenda de <?php echo $usuario?></h1>
</div>

<?php include_partial('modal'); ?>
<?php include_partial('agenda'); ?>


