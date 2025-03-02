<?php

namespace App\Libraries;

class Hash
{
    public static function encriptar($contraseña)
    {
        return password_hash($contraseña, PASSWORD_BCRYPT);
    }
    public static function verificar($contraseñaIngresada, $contraseñaUsuario)
    {
        return (password_verify($contraseñaIngresada, $contraseñaUsuario));
    }
}
