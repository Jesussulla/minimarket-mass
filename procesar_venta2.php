<?php
date_default_timezone_set('America/Lima');

// Importación segura usando la constante mágica __DIR__
require_once __DIR__ . '/clases/Producto.php';
require_once __DIR__ . '/clases/Cliente.php';
require_once __DIR__ . '/clases/Venta.php';

// === DATOS DE PRUEBA (OBJETOS) ===
$cliente = new Cliente('45788836', 'Carlos', 'Quispe', 'frecuente');

$p1 = new Producto('P001', 'Arroz Costeño 1kg',    'abarrotes', 4.50, 100);
$p2 = new Producto('P002', 'Inca Kola 1.5L',       'bebidas',   6.50, 50);
$p3 = new Producto('P003', 'Pan de Molde Mass',    'panaderia', 7.20, 30);

$venta = new Venta($cliente, 'yape');
$venta->agregarProducto($p1, 5);
$venta->agregarProducto($p2, 2);
$venta->agregarProducto($p3, 1);

$hora = (int) date('H');
if ($hora >= 5 && $hora <= 11) {
    $saludo = 'Buenos días';
} elseif ($hora >= 12 && $hora <= 18) {
    $saludo = 'Buenas tardes';
} elseif ($hora >= 19 && $hora <= 23) {
    $saludo = 'Buenas noches';
} else {
    $saludo = 'Tienda cerrada';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Venta POO - Minimarket Mass</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background-color: #f4f4f9; margin: 0; padding: 20px; display: flex; justify-content: center; }
        .ticket-box { background: #fff; width: 380px; padding: 20px; border: 1px dashed #000; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .linea-separadora { border-top: 1px dashed #000; margin: 10px 0; }
        .tabla-productos { width: 100%; border-collapse: collapse; font-size: 13px; }
        .tabla-productos th { border-bottom: 1px solid #000; text-align: left; }
        .resumen-tabla { width: 100%; font-size: 13px; margin-top: 10px; }
        .badge { background-color: #0066B3; color: white; padding: 3px 6px; font-size: 11px; border-radius: 3px; }
    </style>
</head>
<body>
<div class="ticket-box">
    <h2 class="text-center" style="margin: 0; color: #0066B3;">MINIMARKET MASS</h2>
    <p class="text-center" style="font-size: 12px; margin: 5px 0;">Tiendas Mass S.A.C.<br>RUC: 20554896321</p>
    <div class="linea-separadora"></div>
    <p style="font-size: 12px; margin: 0;">
        <strong>Fecha:</strong> <?= date('d/m/Y H:i:s') ?><br>
        <strong>Cliente:</strong> <?= htmlspecialchars($venta->getCliente()->getNombre() . " " . $venta->getCliente()->getApellido()) ?><br>
        <strong>DNI:</strong> <?= htmlspecialchars($venta->getCliente()->getDni()) ?> <span class="badge"><?= strtoupper($venta->getCliente()->getTipo()) ?></span><br>
        <strong>Pago:</strong> <?= strtoupper($venta->getMetodoPago()) ?>
    </p>
    <div class="linea-separadora"></div>
    <table class="tabla-productos">
        <thead>
            <tr>
                <th>DESCRIPCIÓN (CANT)</th>
                <th class="text-right">P.UNIT</th>
                <th class="text-right">IGV</th>
                <th class="text-right">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($venta->getLineas() as $linea): 
                $p = $linea['producto']; $cant = $linea['cantidad'];
                $subtotal = $p->getPrecio() * $cant; $igvLinea = $subtotal * $p->tasaIGV(); $total = $subtotal + $igvLinea;
            ?>
            <tr>
                <td><?= htmlspecialchars($p->getNombre()) ?> (x<?= $cant ?>)</td>
                <td class="text-right">S/ <?= number_format($p->getPrecio(), 2) ?></td>
                <td class="text-right">S/ <?= number_format($igvLinea, 2) ?></td>
                <td class="text-right">S/ <?= number_format($total, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="linea-separadora"></div>
    <table class="resumen-tabla">
        <tr><td>Subtotal Bruto:</td><td class="text-right">S/ <?= number_format($venta->calcularSubtotalBruto(), 2) ?></td></tr>
        <tr><td>IGV Total:</td><td class="text-right">S/ <?= number_format($venta->calcularIgvTotal(), 2) ?></td></tr>
        <tr style="font-weight: bold;"><td>Total Bruto:</td><td class="text-right">S/ <?= number_format($venta->calcularTotalBruto(), 2) ?></td></tr>
        <?php if ($venta->calcularMontoDescuento() > 0): ?>
        <tr style="color: green;"><td>Descuento:</td><td class="text-right">-S/ <?= number_format($venta->calcularMontoDescuento(), 2) ?></td></tr>
        <?php endif; ?>
        <?php if ($venta->calcularMontoComision() > 0): ?>
        <tr style="color: red;"><td>Recargo Tarjeta:</td><td class="text-right">+S/ <?= number_format($venta->calcularMontoComision(), 2) ?></td></tr>
        <?php endif; ?>
        <tr style="font-size: 16px; font-weight: bold; border-top: 1px double #000;">
            <td>TOTAL A PAGAR:</td><td class="text-right" style="color: #0066B3;">S/ <?= number_format($venta->calcularTotalNeto(), 2) ?></td>
        </tr>
    </table>
    <div class="linea-separadora"></div>
    <p class="text-center" style="font-size: 12px; font-style: italic; margin: 0;">¡<?= $saludo ?>! Gracias por tu compra en Mass.</p>
</div>
</body>
</html>