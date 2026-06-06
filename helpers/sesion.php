<?php
declare(strict_types=1);

function requiereLogin(): void {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?accion=login');
        exit;
    }
}

function usuarioActual(): ?array {
    return $_SESSION['usuario'] ?? null;
}

function requiereRol(string $rol): void {
    requiereLogin();
    if (usuarioActual()['rol'] !== $rol) {
        http_response_code(403);
        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
        <title>Acceso denegado</title>
        <style>
          body{font-family:'Segoe UI',Arial,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f0f4f8;margin:0}
          .box{background:#fff;padding:40px;border-radius:14px;box-shadow:0 8px 30px rgba(0,0,0,.1);text-align:center;max-width:400px}
          h1{color:#e74c3c;margin-bottom:8px}
          p{color:#555}
          a{display:inline-block;margin-top:20px;padding:10px 24px;background:#0066B3;color:#fff;border-radius:8px;text-decoration:none;font-weight:700}
          a:hover{background:#0055a0}
        </style></head><body>
        <div class='box'>
          <div style='font-size:48px'>🚫</div>
          <h1>Acceso denegado</h1>
          <p>No tienes permisos para ver esta página.</p>
          <a href='index.php?accion=catalogo'>Volver al catálogo</a>
        </div>
        </body></html>";
        exit;
    }
}