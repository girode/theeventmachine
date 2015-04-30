<div id="eventFormModal" class="modal">
    <div class="modal-dialog modal-lg">
        
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nuevo Evento</h4>
            </div>

            <form action="<?php echo url_for('@procesar_formulario_evento_ajax')?>" method="post" id="formAltaEvento">
                <div class="modal-body">
                    <?php echo $form->renderHiddenFields() ?>
                        <div class="container-fluid">
                            <div class="row">        
                                <div class="col-lg-6" style="border-right:1px solid #000">                                    
                                    <div class="form-horizontal">
                                        <?php echo $form->renderRequiredFields() ?>
                                    </div>   
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-horizontal">
                                        <?php echo $form->renderNonRequiredFields() ?>
                                    </div>
                                </div>
                            </div>    
                        </div>        
                </div>
                <?php echo $form->renderJavascript() ?>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </div>
            </form>        
            
        </div><!-- /.modal-content -->
        
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->