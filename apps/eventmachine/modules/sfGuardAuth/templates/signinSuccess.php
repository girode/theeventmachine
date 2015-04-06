<?php use_helper('I18N') ?>

<h1><?php echo __('Signin', null, 'sf_guard') ?></h1>


<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form-horizontal">
    <div class="row">
        <?php echo $form ?>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-5">
                <input type="submit" class="btn btn-primary" value="<?php echo __('Signin', null, 'sf_guard') ?>" />

                <?php $routes = $sf_context->getRouting()->getRoutes() ?>
                <?php if (isset($routes['sf_guard_forgot_password'])): ?>
                  <a href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
                <?php endif; ?>

                <?php if (isset($routes['sf_guard_register'])): ?>
                  &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
                <?php endif; ?>
            </div>
        </div>
        
    </div>   

</form>