<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$principal = [
    '/' => 'Home::index',
    'quienes-somos' => 'Home::quienesSomos',
    'contacto' => 'Home::contacto',
    'preguntas-frecuentes' => 'Home::preguntasFrecuentes',
    'comercializacion' => 'Home::comercializacion',
    'cerrar-sesion' => 'AutenticacionController::cerrarSesion',
    'terminos-y-condiciones' => 'Home::terminosYCondiciones',
    'colecciones/(:segment)' => 'Productos::index/',
    'productos/cambiar-sabor' => 'Productos::cambiarSabor',
    'productos/(:segment)' => 'Productos::verProducto',
];
$routes->map($principal);
$routes->post('enviar-consulta', 'ConsultasController::recibirConsulta');
$routes->set404Override('App\Controllers\Home::show404');
/*Cliente*/
$routes->group('', ['filter' => 'autenticacion'], function ($routes) {
    $routes->get('cuenta', 'UsuariosController::cuenta');
    $routes->get('cuenta/detalle-pedido/(:num)', 'UsuariosController::detallePedido/$1');
    $routes->get('cuenta/modificar-datos/', 'UsuariosController::editarDatos');
    $routes->post('cuenta/enviar-datos/', 'UsuariosController::actualizarDatos');
    $routes->get('cuenta/modificar-contrasenia/', 'UsuariosController::editarContraseña');
    $routes->post('cuenta/enviar-clave', 'UsuariosController::actualizarContraseña');

    /*Carrito*/
    $routes->post('productos/agregarcarrito', 'CarritoController::agregarAlCarrito');
    $routes->post('eliminar-producto-carrito', 'CarritoController::eliminarDelCarrito');
});
$routes->group('', ['filter' => 'usuariologueado'], function ($routes) {
    $routes->get('iniciar-sesion', 'AutenticacionController::login');
    $routes->get('registrarse', 'AutenticacionController::registro');
    $routes->post('registrarse', 'AutenticacionController::registrar');
    $routes->post('login-user', 'AutenticacionController::iniciarSesion');
});
$routes->group('', ['filter' => 'carritoVacio'], function ($routes) {
    $routes->get('confirmar-pedido', 'PedidosController::index');
    $routes->post('realizar-compra', 'PedidosController::nuevoPedido');
});
$routes->get('search', 'Home::buscar/$1');
/*Administrador*/
$routes->group('', ['filter' => 'usuarioAdmin'], function ($routes) {
    /*CRUD Sabores*/
    $routes->get('dashboard/sabores', 'SaboresController::index');
    $routes->get('dashboard/sabores/listar', 'SaboresController::list');
    $routes->post('dashboard/sabores/insertar', 'SaboresController::create');
    $routes->put('dashboard/sabores/actualizar', 'SaboresController::update');
    $routes->put('dashboard/sabores/eliminar/', 'SaboresController::delete');
    $routes->put('dashboard/sabores/activar/', 'SaboresController::restore');
    $routes->get('dashboard/sabores/eliminados', 'SaboresController::listDeleted');
    /*CRUD Categorias*/
    $routes->get('dashboard/categorias', 'categoriasController::index');
    $routes->get('dashboard/categorias/listar', 'categoriasController::list');
    $routes->post('dashboard/categorias/insertar', 'categoriasController::create');
    $routes->put('dashboard/categorias/actualizar', 'categoriasController::update');
    $routes->put('dashboard/categorias/eliminar', 'categoriasController::delete');
    $routes->put('dashboard/categorias/activar/', 'categoriasController::restore');
    $routes->get('dashboard/categorias/eliminados', 'categoriasController::listDeleted');
    /*CRUD Marcas*/
    $routes->get('dashboard/marcas', 'MarcasController::index');
    $routes->get('dashboard/marcas/listar', 'MarcasController::list');
    $routes->post('dashboard/marcas/insertar', 'MarcasController::create');
    $routes->put('dashboard/marcas/actualizar', 'MarcasController::update');
    $routes->put('dashboard/marcas/eliminar', 'MarcasController::delete');
    $routes->put('dashboard/marcas/activar/', 'MarcasController::restore');
    $routes->get('dashboard/marcas/eliminados', 'MarcasController::listDeleted');
    /*CRUD Productos*/
    $routes->get('dashboard/productos', 'Productos::listadoProductos');
    $routes->get('dashboard/productos/listar', 'Productos::listarProductos');
    $routes->get('dashboard/productos/agregar', 'Productos::agregarProducto');
    $routes->get('dashboard/productos/presentaciones/(:num)', 'Productos::listadoPresentaciones/$1');
    $routes->post('dashboard/productos/insertar', 'Productos::insertarProducto');
    $routes->put('dashboard/productos/eliminar/', 'Productos::eliminarProducto/');
    $routes->get('dashboard/productos/editar/(:num)', 'Productos::editarProducto/$1');
    $routes->put('dashboard/productos/activar/', 'Productos::activarProducto');
    $routes->post('dashboard/productos/actualizar', 'Productos::actualizarProducto');
    $routes->get('dashboard/productos/eliminados', 'Productos::productosEliminados');
    /*Pedidos*/
    $routes->get('dashboard/pedidos', 'PedidosController::listarPedidos');
    $routes->get('dashboard/pedidos/detalles/(:num)', 'PedidosController::detallesPedido/$1');
    /*Cambiar Rol*/
    $routes->post('dashboard/usuarios/cambiar-admin', 'UsuariosController::cambiarAdmin');

    /*Lista Usuarios*/
    $routes->get('dashboard/usuarios', 'UsuariosController::index');
    $routes->get('dashboard', "AdminController::dashboard");
    /*Lista consultas*/
    $routes->get('dashboard/consultas', "ConsultasController::listarConsultas");
    $routes->get('dashboard/detalle-consulta/(:num)', "ConsultasController::verDetalleConsulta/$1");
    $routes->post('consultas/resolver-consulta', "ConsultasController::resolverConsulta");
});
