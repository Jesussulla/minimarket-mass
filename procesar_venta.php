<?php
date_default_timezone_set('America/Lima');

require_once __DIR__ . '/clases/Producto.php';
require_once __DIR__ . '/clases/Cliente.php';
require_once __DIR__ . '/clases/Venta.php';

$cliente = new Cliente('45788836', 'Carlos', 'Quispe', 'frecuente');

$p1 = new Producto('P001', 'Arroz Costeño 1kg',  'abarrotes', 4.50, 100);
$p2 = new Producto('P002', 'Inca Kola 1.5L',     'bebidas',   6.50, 50);
$p3 = new Producto('P003', 'Pan de Molde Mass',  'panaderia', 7.20, 30);

$venta = new Venta($cliente, 'yape');
$venta->agregarProducto($p1, 5);
$venta->agregarProducto($p2, 2);
$venta->agregarProducto($p3, 1);

$hora = (int) date('H');
if ($hora >= 5  && $hora <= 11) $saludo = 'Buenos días';
elseif ($hora >= 12 && $hora <= 18) $saludo = 'Buenas tardes';
elseif ($hora >= 19 && $hora <= 23) $saludo = 'Buenas noches';
else $saludo = 'Tienda cerrada';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Venta - Tiendas Mass</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background-color: #f8f9fa; padding: 20px; font-size: 14px; color: #212529; }
        .ticket-box { max-width: 500px; background: #ffffff; margin: 0 auto; padding: 25px; border: 1px solid #dee2e6; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .brand { text-align: center; margin-bottom: 20px; }
        .brand h1 { margin: 0; color: #000000; font-size: 32px; font-weight: 900; letter-spacing: -1px; }
        .brand p { margin: 2px 0; font-size: 12px; color: #6c757d; }
        .divider { border-top: 1px dashed #000; margin: 15px 0; }
        .double-divider { border-top: 3px double #000; margin: 15px 0; }
        .saludo-banner { background: #fff9c4; padding: 8px; border-radius: 4px; text-align: center; font-weight: bold; margin-bottom: 15px; }
        .seccion-datos p { margin: 4px 0; }
        .tabla-productos { width: 100%; border-collapse: collapse; margin: 15px 0; }
        .tabla-productos th { border-bottom: 1px solid #000; text-align: left; padding: 6px 0; font-size: 12px; }
        .tabla-productos td { padding: 8px 0; vertical-align: top; font-size: 13px; }
        .text-right { text-align: right; }
        .bloque-totales { width: 100%; margin-top: 10px; }
        .fila-total { display: flex; justify-content: space-between; padding: 3px 0; }
        .gran-total { font-weight: bold; font-size: 16px; margin-top: 5px; padding-top: 5px; border-top: 1px dashed #000; }
        .info-pago { background-color: #e8f5e9; border: 1px solid #c8e6c9; padding: 12px; border-radius: 4px; margin-top: 15px; text-align: center; font-weight: bold; }
        .alert-box { background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 10px; border-radius: 4px; margin-top: 10px; font-size: 12px; font-weight: bold; text-align: center; }
        .ticket-footer { text-align: center; font-size: 11px; color: #6c757d; margin-top: 25px; }
    </style>
</head>
<body>
<div class="ticket-box">

    <div class="brand">
        <h1>MASS</h1>
        <p>TIENDAS MASS S.A.C. - RUC: 20556987412</p>
        <p>AV. EJÉRCITO 415 - AREQUIPA</p>
        <p>Fecha Emisión: <?php echo $venta->getFecha(); ?></p>
    </div>

    <div class="saludo-banner">
        ¡<?php echo $saludo; ?>, <?php echo htmlspecialchars($cliente->getNombre()); ?>!
    </div>

    <div class="seccion-datos">
        <p><strong>DNI CLIENTE:</strong> <?php echo htmlspecialchars($cliente->getDni()); ?></p>
        <p><strong>TIPO CLIENTE:</strong> <?php echo strtoupper($cliente->getTipo()); ?></p>
    </div>

    <div class="divider"></div>

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
            $p        = $linea['producto'];
            $cant     = $linea['cantidad'];
            $subtotal = $p->getPrecio() * $cant;
            $igvLinea = $subtotal * $p->tasaIGV();
            $total    = $subtotal + $igvLinea;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($p->getNombre()) . " ({$cant})"; ?></td>
                <td class="text-right">S/ <?php echo number_format($p->getPrecio(), 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($igvLinea, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($total, 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="double-divider"></div>

    <div class="bloque-totales">
        <div class="fila-total">
            <span>Subtotal Neto Afetado:</span>
            <span>S/ <?php echo number_format($venta->calcularSubtotal(), 2); ?></span>
        </div>
        <div class="fila-total">
            <span>IGV Acumulado Calculado:</span>
            <span>S/ <?php echo number_format($venta->calcularIGV(), 2); ?></span>
        </div>
        <div class="fila-total">
            <span>Descuento por Rango Escalar (<?php echo $venta->porcentajeDescuentoMonto(); ?>%):</span>
            <span>- S/ <?php echo number_format($venta->descuentoMontoSoles(), 2); ?></span>
        </div>
        <div class="fila-total">
            <span>Descuento por Fidelidad <?php echo ucfirst($cliente->getTipo()); ?> (<?php echo $venta->porcentajeDescuentoCliente(); ?>%):</span>
            <span>- S/ <?php echo number_format($venta->descuentoClienteSoles(), 2); ?></span>
        </div>
        <div class="fila-total gran-total">
            <span>TOTAL FINAL IMPORTE A PAGAR:</span>
            <span>S/ <?php echo number_format($venta->calcularTotal(), 2); ?></span>
        </div>
    </div>

    <div class="info-pago">
        ACCIÓN POS: <?php echo strtoupper($venta->mensajeMetodoPago()); ?>
    </div>

    <?php if ($venta->advertenciaSeguridad()): ?>
        <div class="alert-box">
            <?php echo $venta->advertenciaSeguridad(); ?>
        </div>
    <?php endif; ?>

    <div class="ticket-footer">
        <p>Venta procesada de manera exitosa en caja local.</p>
        <p>*** ¡Precios Mass Bajos Siempre! ***</p>
    </div>

</div>
</body>
</html>