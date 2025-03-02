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
    'colecciones/(:segment)' => 'Productos::index/$1',
    'productos/(:segment)' => 'Productos::verProducto/$1',
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
    /*CRUD Unidades*/
    $routes->get('dashboard/unidades', 'UnidadesController::index');
    $routes->get('dashboard/unidades/agregar', 'UnidadesController::agregarUnidad');
    $routes->get('dashboard/unidades/editar/(:num)', 'UnidadesController::editarUnidad/$1');
    $routes->post('dashboard/unidades/insertar', 'UnidadesController::insertarUnidad');
    $routes->post('dashboard/unidades/actualizar', 'UnidadesController::actualizarUnidad');
    $routes->post('dashboard/unidades/eliminar/', 'UnidadesController::eliminarUnidad');
    $routes->get('dashboard/unidades/activar/(:num)', 'UnidadesController::activarUnidad/$1');
    $routes->get('dashboard/unidades/eliminados', 'UnidadesController::unidadesEliminadas');
    /*CRUD Categorias*/
    $routes->get('dashboard/categorias', 'categoriasController::index');
    $routes->get('dashboard/categorias/agregar', 'categoriasController::agregarCategoria');
    $routes->get('dashboard/categorias/editar/(:num)', 'categoriasController::editarCategoria/$1');
    $routes->post('dashboard/categorias/insertar', 'categoriasController::insertarCategoria');
    $routes->post('dashboard/categorias/actualizar', 'categoriasController::actualizarCategoria');
    $routes->post('dashboard/categorias/eliminar', 'categoriasController::eliminarCategoria/');
    $routes->get('dashboard/categorias/activar/(:num)', 'categoriasController::activarCategoria/$1');
    $routes->get('dashboard/categorias/eliminados', 'categoriasController::categoriasEliminadas');
    /*CRUD Marcas*/
    $routes->get('dashboard/marcas', 'MarcasController::index');
    $routes->get('dashboard/marcas/agregar', 'MarcasController::agregarMarca');
    $routes->get('dashboard/marcas/editar/(:num)', 'MarcasController::editarMarca/$1');
    $routes->post('dashboard/marcas/insertar', 'MarcasController::insertarMarca');
    $routes->post('dashboard/marcas/actualizar', 'MarcasController::actualizarMarca');
    $routes->post('dashboard/marcas/eliminar', 'MarcasController::eliminarMarca');
    $routes->get('dashboard/marcas/activar/(:num)', 'MarcasController::activarMarca/$1');
    $routes->get('dashboard/marcas/eliminados', 'MarcasController::marcasEliminadas');
    /*CRUD Productos*/
    $routes->get('dashboard/productos', 'Productos::listadoProductos');
    $routes->get('dashboard/productos/agregar', 'Productos::agregarProducto');
    $routes->post('dashboard/productos/insertar', 'Productos::insertarProducto');
    $routes->post('dashboard/productos/eliminar/', 'Productos::eliminarProducto/');
    $routes->get('dashboard/productos/editar/(:num)', 'Productos::editarProducto/$1');
    $routes->get('dashboard/productos/activar/(:num)', 'Productos::activarProducto/$1');
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
