<?php
function mostrarErroresFormulario($validacion, $campo)
{
    if ($validacion->hasError($campo)) {
        return $validacion->getError($campo);
    }
}
