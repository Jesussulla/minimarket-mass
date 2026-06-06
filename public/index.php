<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

$accion = $_GET['accion'] ?? 'catalogo';
$auth   = new AuthController();

switch ($accion) {

    case 'login':
        $auth->mostrarLogin();
        break;

    case 'procesar-login':
        $auth->procesarLogin();
        break;

    case 'logout':
        $auth->logout();
        break;

   case 'panel-admin':
    requiereRol('admin');
    $usuario = usuarioActual();
    require __DIR__ . '/../views/layout/header.php';
    require __DIR__ . '/../views/auth/barra_usuario.php';
    echo "
    <div style='max-width:700px;margin:60px auto;padding:40px;background:#fff;border-radius:14px;box-shadow:0 8px 30px rgba(0,0,0,.1);text-align:center;font-family:Segoe UI,Arial,sans-serif'>
        <div style='font-size:48px;margin-bottom:16px'>⚙️</div>
        <h1 style='color:#0066B3;margin-bottom:8px'>Panel de administración</h1>
        <p style='color:#555;font-size:15px'>Bienvenido, <strong>" . htmlspecialchars($usuario['nombre']) . "</strong></p>
        <hr style='margin:24px 0;border:none;border-top:1px solid #eee'>
        <div style='display:flex;gap:16px;justify-content:center;flex-wrap:wrap'>
            <a href='index.php?accion=catalogo' style='background:#0066B3;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px'>📦 Ver catálogo</a>
        </div>
    </div>";
    require __DIR__ . '/../views/layout/footer.php';
    break;

    case 'catalogo':
    default:
        requiereLogin();
        (new ProductoController())->listar();
        break;
}