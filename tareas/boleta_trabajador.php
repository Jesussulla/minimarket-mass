<?php
// PARTE 1: DEFINICIÓN DE VARIABLES Y DATOS DE ENTRADA
// En esta sección se registran todos los datos fijos del caso de estudio.
// Ningún valor se escribe directamente en el HTML; todo nace desde aquí.

// datos del trabajador 
$nombre_trabajador = "Carlos Eduardo Mamani Quispe";
$dni_trabajador = "74521893";
$cargo_trabajador = "Jefe de almacén";
$tienda_asignada = "Mass Cayma";
$periodo_mensual = "Mayo 2026";
$dias_laborados = 30;

// datos numéricos iniciales (Valores Base)
$sueldo_base = 2850.00;
$asignacion_familiar = 102.50; 
$cantidad_horas_extras = 12;
$tarifa_hora_extra = 18.50;

// Tasas de retención y aportes vigentes 
$porcentaje_afp = 0.13;
$porcentaje_renta_5ta = 0.08;
$porcentaje_essalud = 0.09;

// PARTE 2: PROCESAMIENTO Y CÁLCULOS AUTOMATIZADOS
// Aquí se ejecutan los operadores aritméticos obligatorios (+, -, *).
// Se aplica la función round() para garantizar precisión de centavos en soles.

// 1. Cálculo del monto por horas extras utilizando el operador de multiplicación (*)
$monto_horas_extras = $cantidad_horas_extras * $tarifa_hora_extra;

// 2. Cálculo del total de ingresos sumando todos los conceptos (+)
$total_ingresos = $sueldo_base + $asignacion_familiar + $monto_horas_extras;

// 3. Cálculo de retención AFP aplicando multiplicación (*) y redondeo
$descuento_afp = round($total_ingresos * $porcentaje_afp, 2);

// 4. Cálculo de retención de Quinta Categoría aplicando multiplicación (*) y redondeo
$descuento_renta = round($total_ingresos * $porcentaje_renta_5ta, 2);

// 5. Cálculo del total de descuentos sumando ambas retenciones (+)
$total_descuentos = $descuento_afp + $descuento_renta;

// 6. Cálculo del sueldo neto final restando los descuentos a los ingresos (-)
$sueldo_neto = $total_ingresos - $total_descuentos;

// Cálculos adicionales para los indicadores de gestión 
$aporte_essalud = round($sueldo_base * $porcentaje_essalud, 2);
$costo_total_empresa = $total_ingresos + $aporte_essalud;
$fecha_emision_sistema = date("d/m/Y");
$dias_proporcionales_simulacion = 22; 
$sueldo_proporcional_simulado = round(($sueldo_base / $dias_laborados) * $dias_proporcionales_simulacion, 2);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Pago — Minimarket Mass</title>
    <style>
        /* PARTE 3: DISEÑO VISUAL Y ESTILOS (CSS)
           Aquí definimos los colores solicitados: Celeste oscuro (#2b5b84), 
           rojo suave (#b83c3c) para los descuentos, gris de fondo y amarillo oro.*/

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
            color: #333333;
        }
        .boleta-principal {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border: 1px solid #d3dfeb;
            border-top: 8px solid #2b5b84; 
            border-radius: 6px;
        }
        .text-center {
            text-align: center;
        }
        .cabecera-linea {
            border-bottom: 2px solid #2b5b84;
            padding-bottom: 12px;
            margin-bottom: 25px;
        }
        h1 {
            font-size: 22px;
            color: #2b5b84;
            margin: 0;
            text-transform: uppercase;
        }
        h3 {
            font-size: 13px;
            color: #5a6a85;
            margin: 6px 0 0 0;
            font-weight: normal;
        }
        .barra-azul-titulo {
            background-color: #4a709c;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 12px;
            border-radius: 3px;
        }
        .tabla-estructurada {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 13px;
        }
        .tabla-estructurada td {
            padding: 8px 12px;
            border: 1px solid #e1e8ed;
        }
        .celda-etiqueta-gris {
            background-color: #f7fafc;
            font-weight: bold;
            color: #4a5568;
            width: 18%;
        }
        .tabla-tres-columnas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .columna-contenedor {
            width: 33.33%;
            padding: 0 7px;
            vertical-align: top;
        }
        .tarjeta-interna {
            border: 1px solid #d3dfeb;
            border-radius: 4px;
            background-color: #ffffff;
        }
        .titulo-columna {
            background-color: #2b5b84; 
            color: #ffffff;
            padding: 9px;
            font-size: 12px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .titulo-columna.variante-rojo-suave {
            background-color: #b83c3c; 
        }
        .tabla-calculos-internos {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .tabla-calculos-internos td {
            padding: 8px 10px;
            color: #4a5568;
        }
        .relleno-alineacion-filas {
            height: 60px; 
        }
        .fila-totales-bloque {
            background-color: #f7fafc;
            border-top: 1px solid #cbd5e0;
            color: #2b5b84;
        }
        .texto-amarillo-elegante {
            color: #c2930a;
            text-align: right;
        }
        .fila-totales-bloque.variante-descuentos {
            background-color: #fff5f5;
            border-top: 1px solid #fed7d7;
            color: #b83c3c;
        }
        .tabla-resumen-neto {
            width: 100%;
            border-collapse: collapse;
            background-color: #2b5b84; 
            color: #ffffff;
            font-weight: bold;
            font-size: 18px;
            border-radius: 4px;
        }
        .tabla-resumen-neto td {
            padding: 15px 20px;
        }
        .monto-destacado-neto {
            color: #ffe685; 
            font-size: 20px;
            text-align: right;
        }
        .bloque-indicadores-adicionales {
            margin-top: 25px;
            background-color: #f7fafc;
            border: 1px solid #d3dfeb;
            padding: 18px;
            border-radius: 4px;
        }
        .tarjeta-indicador-individual {
            border: 1px solid #d3dfeb;
            background-color: #ffffff;
            padding: 14px;
            border-radius: 4px;
        }
        .titulo-indicador-label {
            font-size: 11px;
            color: #718096;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 600;
        }
        .valor-indicador-text {
            font-size: 16px;
            color: #c2930a; 
            font-weight: bold;
        }
        .linea-division-firma {
            width: 220px;
            border-top: 1px solid #a0aec0;
            margin: 50px auto 0 auto;
            padding-top: 6px;
            font-size: 13px;
            color: #4a5568;
        }
    </style>
</head>
<body>

    <div class="boleta-principal">
        
        <div class="text-center cabecera-linea">
            <h1>Boleta de Pago</h1>
            <h3>MINIMARKETS MASS S.A.C. &middot; Periodo: <?php echo $periodo_mensual; ?></h3>
        </div>

        <div class="barra-azul-titulo">Datos del Trabajador</div>
        <table class="tabla-estructurada">
            <tr>
                <td class="celda-etiqueta-gris">Nombres:</td>
                <td><?php echo $nombre_trabajador; ?></td>
                <td class="celda-etiqueta-gris">DNI:</td>
                <td><?php echo $dni_trabajador; ?></td>
            </tr>
            <tr>
                <td class="celda-etiqueta-gris">Cargo:</td>
                <td><?php echo $cargo_trabajador; ?></td>
                <td class="celda-etiqueta-gris">Tienda:</td>
                <td><?php echo $tienda_asignada; ?></td>
            </tr>
            <tr>
                <td class="celda-etiqueta-gris">Días Lab.:</td>
                <td><?php echo $dias_laborados . " días"; ?></td>
                <td class="celda-etiqueta-gris">F. Emisión:</td>
                <td><?php echo $fecha_emision_sistema; ?></td>
            </tr>
        </table>

        <table class="tabla-tres-columnas">
            <tr>
                
                <td class="columna-contenedor">
                    <div class="tarjeta-interna">
                        <div class="titulo-columna">Remuneraciones</div>
                        <table class="tabla-calculos-internos">
                            <tr>
                                <td>Sueldo Base</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($sueldo_base, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Asig. Familiar</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($asignacion_familiar, 2); ?></td>
                            </tr>
                            <tr>
                                <td>H. Extras (<?php echo $cantidad_horas_extras; ?> h)</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($monto_horas_extras, 2); ?></td>
                            </tr>
                            <tr class="relleno-alineacion-filas"><td></td><td></td></tr>
                            <tr class="fila-totales-bloque">
                                <td><strong>Total Rem.</strong></td>
                                <td class="texto-amarillo-elegante"><strong><?php echo "S/ " . number_format($total_ingresos, 2); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="columna-contenedor">
                    <div class="tarjeta-interna">
                        <div class="titulo-columna variante-rojo-suave">Retenciones / Descuentos</div>
                        <table class="tabla-calculos-internos">
                            <tr>
                                <td>AFP Obligatorio (13%)</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($descuento_afp, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Impuesto 5ta (8%)</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($descuento_renta, 2); ?></td>
                            </tr>
                            <tr><td>&nbsp;</td><td></td></tr>
                            <tr class="relleno-alineacion-filas"><td></td><td></td></tr>
                            <tr class="fila-totales-bloque variante-descuentos">
                                <td><strong>Total Desc.</strong></td>
                                <td class="texto-amarillo-elegante"><strong><?php echo "S/ " . number_format($total_descuentos, 2); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td class="columna-contenedor">
                    <div class="tarjeta-interna">
                        <div class="titulo-columna">Aportaciones Empleador</div>
                        <table class="tabla-calculos-internos">
                            <tr>
                                <td>EsSalud (9%)</td>
                                <td style="text-align: right;"><?php echo "S/ " . number_format($aporte_essalud, 2); ?></td>
                            </tr>
                            <tr><td>&nbsp;</td><td></td></tr>
                            <tr><td>&nbsp;</td><td></td></tr>
                            <tr class="relleno-alineacion-filas"><td></td><td></td></tr>
                            <tr class="fila-totales-bloque">
                                <td><strong>Total Aporte</strong></td>
                                <td class="texto-amarillo-elegante"><strong><?php echo "S/ " . number_format($aporte_essalud, 2); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

        <table class="tabla-resumen-neto">
            <tr>
                <td><strong>NETO A PAGAR</strong></td>
                <td class="monto-destacado-neto"><strong><?php echo "S/ " . number_format($sueldo_neto, 2); ?></strong></td>
            </tr>
        </table>

        <div class="bloque-indicadores-adicionales">
            <h4 style="margin: 0 0 12px 0; color: #2b5b84; font-size: 13px; text-transform: uppercase; border-bottom: 1px solid #d3dfeb; padding-bottom: 6px;">
                Indicadores de Gestión Humana
            </h4>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; padding: 10px; vertical-align: top;">
                        <div class="tarjeta-indicador-individual">
                            <div class="titulo-indicador-label">Costo Total de la Plaza (Empresa)</div>
                            <div class="valor-indicador-text"><?php echo "S/ " . number_format($costo_total_empresa, 2); ?></div>
                        </div>
                    </td>
                    <td style="width: 50%; padding: 10px; vertical-align: top;">
                        <div class="tarjeta-indicador-individual">
                            <div class="titulo-indicador-label">Sueldo Proporcional Simulador (<?php echo $dias_proporcionales_simulacion; ?> Días)</div>
                            <div class="valor-indicador-text"><?php echo "S/ " . number_format($sueldo_proporcional_simulado, 2); ?></div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="text-center">
            <div class="linea-division-firma">Firma del Trabajador</div>
        </div>

    </div>

</body>
</html>