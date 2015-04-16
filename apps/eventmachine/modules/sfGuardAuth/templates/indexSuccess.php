<?php use_stylesheet('main.css') ?>
<?php use_helper('I18N') ?>

<?php slot('signin_form') ?>

<form class="navbar-form navbar-right" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">    
    <?php echo $form ?>    
    <input type="submit" class="form-control" value="<?php echo __('Signin', null, 'sf_guard') ?>" />
</form>

<?php end_slot() ?>

<div class="jumbotron jumbotron-main">
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <?php echo image_tag('/img/calendar-512.png', array("alt" => "Agenda", "class" => "img-responsive")) ?>
                    <!-- Me genera:
                        <img src="../img/calendar-512.png" class="img-responsive" alt="Agenda">
                    -->
                </div>
                <div class="col-md-6">
                      <h1>The Event Machine</h1>
                      <h2>Scheduling System</h2>
                      <p>Agendas made simple</p>  
                </div>
            </div>  
        </div>
    </div>
</div>

