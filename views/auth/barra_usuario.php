<?php
require_once __DIR__ . '/../../helpers/sesion.php';
requiereLogin();

$nombre = $_SESSION['usuario']['nombre'] ?? 'Usuario';
$rol    = $_SESSION['usuario']['rol']    ?? 'cajero';
$tienda = $_SESSION['usuario']['tienda'] ?? 'Tienda';

$modoTexto  = ($rol === 'admin') ? '⚙️ Modo administrador' : '🛒 Caja';
$badgeColor = ($rol === 'admin') ? '#e67e22' : '#27ae60';
?>
<style>
  *{box-sizing:border-box;font-family:'Segoe UI',Arial,sans-serif}
  .barra{background:#0066B3;color:#fff;padding:10px 24px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 10px rgba(0,0,0,.2);position:sticky;top:0;z-index:999}
  .barra-izq{display:flex;align-items:center;gap:14px}
  .barra-logo{font-weight:800;font-size:16px;letter-spacing:2px;border-right:2px solid rgba(255,255,255,.2);padding-right:14px}
  .barra-info{font-size:13px}
  .barra-info strong{display:block;font-weight:700}
  .barra-info span{opacity:.8;font-size:12px}
  .badge{padding:3px 12px;border-radius:20px;font-size:11px;font-weight:700;color:#fff;background:<?= $badgeColor ?>}
  .barra-der{display:flex;align-items:center;gap:12px}
  .reloj{font-size:12px;opacity:.7;font-weight:600}
  .btn-salir{background:#fff;color:#0066B3;padding:6px 16px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:700;transition:all .2s}
  .btn-salir:hover{background:#e8f0fe;transform:translateY(-1px)}
</style>

<div class="barra">
  <div class="barra-izq">
    <div class="barra-logo">MASS</div>
    <div class="barra-info">
      <strong>👤 <?= htmlspecialchars($nombre) ?></strong>
      <span>🏪 <?= htmlspecialchars($tienda) ?></span>
    </div>
    <span class="badge"><?= $modoTexto ?></span>
  </div>
  <div class="barra-der">
    <span class="reloj" id="reloj"></span>
    <a href="index.php?accion=logout" class="btn-salir">⏻ Salir</a>
  </div>
</div>

<script>
  function tick(){
    const d=new Date();
    document.getElementById('reloj').textContent=
      String(d.getHours()).padStart(2,'0')+':'+
      String(d.getMinutes()).padStart(2,'0')+':'+
      String(d.getSeconds()).padStart(2,'0');
  }
  tick(); setInterval(tick,1000);
</script>