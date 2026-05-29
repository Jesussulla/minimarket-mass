<?php
date_default_timezone_set('America/Lima');

// Datos del Cliente
$cliente_nombre = "Carlos Quispe";
$cliente_dni    = "45788836"; 
$cliente_tipo   = "frecuente"; //(regular / frecuente / vip)

// Datos del Método de Pago
$metodo_pago = "yape"; // Opciones: efectivo / yape / plin / tarjeta

// Productos Comprados
$p1_nombre    = "Arroz Costeño 1kg";
$p1_categoria = "abarrotes"; // Tasa: 18%
$p1_precio    = 4.50;
$p1_cantidad  = 5;

$p2_nombre    = "Inca Kola 1.5L";
$p2_categoria = "bebidas";   // Tasa: 18%
$p2_precio    = 6.50;
$p2_cantidad  = 2;

$p3_nombre    = "Pan de Molde Mass";
$p3_categoria = "panaderia"; // Tasa: inafecto (0%)
$p3_precio    = 7.20;
$p3_cantidad  = 1;


// ==========================================
// 1. VALIDACIÓN DE DNI 
// ==========================================

if (strlen($cliente_dni) !== 8) {
    // Primer error: No tiene 8 caracteres
    echo "<div style='color:#721c24; background-color:#f8d7da; padding:15px; border:1px solid #f5c6cb; font-family:sans-serif; border-radius:4px; margin:20px;'>";
    echo "[ERROR DNI]: El DNI debe contener exactamente 8 caracteres. El tuyo tiene " . strlen($cliente_dni) . ".";
    echo "</div>";
    exit(); 

} elseif (!ctype_digit($cliente_dni)) {
    // Segundo error: Contiene letras o caracteres extraños
    echo "<div style='color:#721c24; background-color:#f8d7da; padding:15px; border:1px solid #f5c6cb; font-family:sans-serif; border-radius:4px; margin:20px;'>";
    echo "[ERROR DNI]: El DNI no puede contener letras ni espacios. Debe ser completamente numérico.";
    echo "</div>";
    exit(); 

}

// ==========================================
// 2. DETERMINACIÓN DE IGV SEGÚN CATEGORÍA 
// ==========================================

function obtener_tasa_igv($categoria) {
    switch ($categoria) {
        case "abarrotes":
        case "bebidas":
        case "lacteos":
        case "limpieza":
        case "aseo personal":
            return 0.18; 
        case "panaderia":
        case "frutas y verduras":
            return 0.00; // Inafecto / Exonerado
        default:
            return 0.18; 
    }
}

$p1_tasa = obtener_tasa_igv($p1_categoria);
$p2_tasa = obtener_tasa_igv($p2_categoria);
$p3_tasa = obtener_tasa_igv($p3_categoria);


// ==========================================
// 3. CÁLCULOS LOGÍSTICOS POR PRODUCTO
// ==========================================
// Producto 1
$p1_subtotal = $p1_precio * $p1_cantidad;
$p1_igv_calc = $p1_subtotal * $p1_tasa;
$p1_total    = $p1_subtotal + $p1_igv_calc;

// Producto 2
$p2_subtotal = $p2_precio * $p2_cantidad;
$p2_igv_calc = $p2_subtotal * $p2_tasa;
$p2_total    = $p2_subtotal + $p2_igv_calc;

// Producto 3
$p3_subtotal = $p3_precio * $p3_cantidad;
$p3_igv_calc = $p3_subtotal * $p3_tasa;
$p3_total    = $p3_subtotal + $p3_igv_calc;

// Acumuladores Generales 
$total_subtotal_global = $p1_subtotal + $p2_subtotal + $p3_subtotal;
$total_igv_global      = $p1_igv_calc + $p2_igv_calc + $p3_igv_calc;
$total_inicial_bruto   = $total_subtotal_global + $total_igv_global;


// ==========================================
// 4. DESCUENTO POR MONTO TOTAL 
// ==========================================
$porcentaje_desc_monto = 0;

if ($total_inicial_bruto >= 200.00) {
    $porcentaje_desc_monto = 15;
} elseif ($total_inicial_bruto >= 100.00) {
    $porcentaje_desc_monto = 10;
} elseif ($total_inicial_bruto >= 30.00) {
    $porcentaje_desc_monto = 5;
} else {
    $porcentaje_desc_monto = 0;
}

$desc_por_monto_soles = $total_inicial_bruto * ($porcentaje_desc_monto / 100);


// ==========================================
// 5. DESCUENTO ADICIONAL POR TIPO DE CLIENTE 
// ==========================================
$porcentaje_desc_cliente = 0;

if ($cliente_tipo === "vip") {
    $porcentaje_desc_cliente = 5;
} elseif ($cliente_tipo === "frecuente") {
    $porcentaje_desc_cliente = 2;
} else {
    $porcentaje_desc_cliente = 0; // Regular o desconocido
}

$desc_por_cliente_soles = $total_inicial_bruto * ($porcentaje_desc_cliente / 100);

// Cierre de Caja Matemático
$total_descuentos_deducidos = $desc_por_monto_soles + $desc_por_cliente_soles;
$total_final_pagar          = $total_inicial_bruto - $total_descuentos_deducidos;


// ==========================================
// 6. VALIDACIÓN Y MENSAJES DE MÉTODO DE PAGO 
// ==========================================
$mensaje_metodo_pago = "";
$advertencia_seguridad = "";

switch ($metodo_pago) {
    case "efectivo":
        $mensaje_metodo_pago = "Pago en efectivo - exacto preferido";
        if ($total_final_pagar > 500.00) {
            $advertencia_seguridad = "ALERTA DE SEGURIDAD: Se sugiere otro método para montos altos.";
        }
        break;
    case "yape":
    case "plin":
        $mensaje_metodo_pago = "Mostrar QR del comercio";
        break;
    case "tarjeta":
        $mensaje_metodo_pago = "Insertar tarjeta en POS";
        break;
    default:
        $mensaje_metodo_pago = "Método no especificado - Validar en caja";
        break;
}


// ==========================================
// 7. SALUDO CRONOLÓGICO SEGÚN HORA ACTUAL 
// ==========================================
$hora_actual = (int)date("H");
$saludo_periodo = "";

if ($hora_actual >= 5 && $hora_actual <= 11) {
    $saludo_periodo = "Buenos días";
} elseif ($hora_actual >= 12 && $hora_actual <= 18) {
    $saludo_periodo = "Buenas tardes";
} elseif ($hora_actual >= 19 && $hora_actual <= 23) {
    $saludo_periodo = "Buenas noches";
} else {
    $saludo_periodo = "Tienda cerrada (Modo simulación nocturna)";
}

$fecha_legible = date("d/m/Y H:i:s");
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
        .brand h1 { margin: 0; color: #ff1919; font-size: 32px; font-weight: 900; letter-spacing: -1px; }
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
        <p>Fecha Emisión: <?php echo $fecha_legible; ?></p>
    </div>

    <div class="saludo-banner">
        ¡<?php echo $saludo_periodo; ?>, <?php echo htmlspecialchars($cliente_nombre); ?>!
    </div>

    <div class="seccion-datos">
        <p><strong>DNI CLIENTE:</strong> <?php echo htmlspecialchars($cliente_dni); ?></p>
        <p><strong>TIPO CLIENTE:</strong> <?php echo strtoupper($cliente_tipo); ?></p>
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
            <tr>
                <td><?php echo htmlspecialchars($p1_nombre) . " (" . $p1_cantidad . ")"; ?></td>
                <td class="text-right">S/ <?php echo number_format($p1_precio, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p1_igv_calc, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p1_total, 2); ?></td>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($p2_nombre) . " (" . $p2_cantidad . ")"; ?></td>
                <td class="text-right">S/ <?php echo number_format($p2_precio, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p2_igv_calc, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p2_total, 2); ?></td>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($p3_nombre) . " (" . $p3_cantidad . ")"; ?></td>
                <td class="text-right">S/ <?php echo number_format($p3_precio, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p3_igv_calc, 2); ?></td>
                <td class="text-right">S/ <?php echo number_format($p3_total, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="double-divider"></div>

    <div class="bloque-totales">
        <div class="fila-total">
            <span>Subtotal Neto Afetado:</span>
            <span>S/ <?php echo number_format($total_subtotal_global, 2); ?></span>
        </div>
        <div class="fila-total">
            <span>IGV Acumulado Calculado:</span>
            <span>S/ <?php echo number_format($total_igv_global, 2); ?></span>
        </div>
        <div class="fila-total">
            <span>Descuento por Rango Escalar (<?php echo $porcentaje_desc_monto; ?>%):</span>
            <span>- S/ <?php echo number_format($desc_por_monto_soles, 2); ?></span>
        </div>
        <div class="fila-total">
            <span>Descuento por Fidelidad <?php echo ucfirst($cliente_tipo); ?> (<?php echo $porcentaje_desc_cliente; ?>%):</span>
            <span>- S/ <?php echo number_format($desc_por_cliente_soles, 2); ?></span>
        </div>
        <div class="fila-total gran-total">
            <span>TOTAL FINAL IMPORTE A PAGAR:</span>
            <span>S/ <?php echo number_format($total_final_pagar, 2); ?></span>
        </div>
    </div>

    <div class="info-pago">
        ACCIÓN POS: <?php echo strtoupper($mensaje_metodo_pago); ?>
    </div>

    <?php if (!empty($advertencia_seguridad)): ?>
        <div class="alert-box">
            <?php echo $advertencia_seguridad; ?>
        </div>
    <?php endif; ?>

    <div class="ticket-footer">
        <p>Venta procesada de manera exitosa en caja local.</p>
        <p>*** ¡Precios Mass Bajos Siempre! ***</p>
    </div>

</div>

</body>
</html>