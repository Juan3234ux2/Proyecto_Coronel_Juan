<?php

namespace App\Controllers;

use App\Models\categoriasModel;

class CategoriasController extends CrudController
{
    public function __construct()
    {
        parent::__construct(new CategoriasModel(), 'Categorias');
    }
}
