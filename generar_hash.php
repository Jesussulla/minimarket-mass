<?php
declare(strict_types=1);

$clave = 'admin123';
$hash  = password_hash($clave, PASSWORD_DEFAULT);

echo "<h2>Generador de hash</h2>";
echo "<p>Contraseña: <b>" . htmlspecialchars($clave) . "</b></p>";
echo "<p>Hash generado:</p>";
echo "<pre style='background:#0e1726;color:#9fe6b0;padding:12px;border-radius:8px'>"
     . htmlspecialchars($hash) . "</pre>";

$ok = password_verify($clave, $hash) ? 'SÍ ✅' : 'NO ❌';
echo "<p>¿password_verify('$clave', \$hash) devuelve true? <b>$ok</b></p>";