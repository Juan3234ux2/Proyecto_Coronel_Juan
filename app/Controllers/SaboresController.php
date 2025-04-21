<?php

namespace App\Controllers;

use App\Models\SaboresModel;

class SaboresController extends CrudController
{
    public function __construct()
    {
        parent::__construct(new SaboresModel(), 'Sabores');
    }
}
