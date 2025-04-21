<?php

namespace App\Controllers;

use App\Models\marcasModel;

class MarcasController extends CrudController
{
    public function __construct()
    {
        parent::__construct(new MarcasModel(), 'Marcas');
    }

}
