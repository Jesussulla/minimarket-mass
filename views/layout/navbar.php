<?php require_once __DIR__ . '/../../helpers/sesion.php'; ?>
<?php $u = usuarioActual(); ?>
<style>
    .navbar { background: #0066B3; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,.15); margin: -40px -40px 40px -40px; }
    .navbar-logo { font-weight: 800; font-size: 18px; letter-spacing: 2px; }
    .navbar-der { display: flex; align-items: center; gap: 14px; font-size: 14px; }
    .navbar-der a { background: #fff; color: #0066B3; padding: 6px 16px; border-radius: 6px; text-decoration: none; font-weight: 700; }
    .navbar-der a:hover { background: #FFB81C; }
    .contenedor { display: flex; gap: 20px; }
</style>
<nav class="navbar">
    <div class="navbar-logo">🛒 MASS · Sistema de Caja</div>
    <div class="navbar-der">
        <span>👤 <?= htmlspecialchars($u['nombre']) ?> · <?= htmlspecialchars(ucfirst($u['rol'])) ?></span>
        <a href="index.php?accion=logout">⏻ Salir</a>
    </div>
</nav>
<div class="contenedor">