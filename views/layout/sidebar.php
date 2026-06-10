<?php 
$accion = $_GET['accion'] ?? 'catalogo'; 
require_once __DIR__ . '/../../helpers/sesion.php';
$usuario = usuarioActual();
?>
<style>
    .sidebar { 
        width: 200px; 
        background: #1a2332; 
        padding: 20px 12px; 
        min-height: calc(100vh - 60px);
        position: sticky;
        top: 60px;
    }
    .sidebar a { 
        display: block; 
        padding: 12px 14px; 
        margin-bottom: 8px; 
        color: #ccc; 
        text-decoration: none; 
        border-radius: 6px;
        border-left: 3px solid transparent; 
        transition: all .2s; 
        font-size: 14px;
        cursor: pointer;
    }
    .sidebar a:hover { 
        background: #2a3a4a; 
        color: #fff; 
    }
    .sidebar a.activo { 
        background: #0066B3;
        color: #fff; 
        border-left-color: #FFB81C; 
        font-weight: 600; 
    }
</style>
<aside class="sidebar">
    <a href="index.php?accion=catalogo" class="<?= $accion === 'catalogo' ? 'activo' : '' ?>">📦 Catálogo</a>
    
    <?php if ($usuario['rol'] === 'admin'): ?>
        <a href="index.php?accion=nuevo-producto" class="<?= $accion === 'nuevo-producto' ? 'activo' : '' ?>">➕ Nuevo producto</a>
        <a href="#">✏️ Editar</a>
        <a href="#">📊 Reportes</a>
    <?php endif; ?>
</aside>
<main>