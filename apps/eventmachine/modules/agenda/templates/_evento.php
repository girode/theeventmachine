<a href="#!" class="list-group-item">
    <button type="button" class="close invisible removeEventButton" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h6><?php echo $evento->getInicioFormateado(); ?></h6>
    <h4 class="list-group-item-heading"><?php echo $evento->getTitulo(); ?></h4>
    <p class="list-group-item-text"><?php echo $evento->getDescripcion(); ?></p>
    <input id="evento_id" type="hidden" value="<?php echo $evento->getId(); ?>" name="evento[id]">
</a>