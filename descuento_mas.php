<?php
$monto = 10;

if ($monto < 30) {
    $descuento = 0;

} elseif ($monto > 30 && $monto <= 99.99) {
    $descuento = 5;

}elseif ($monto > 100 && $monto <= 199.99) {
    $descuento = 10;
    
}else {
    $descuento = 15;
}

$monto_des = $monto * ( $descuento /100 );
$monto_final = $monto - $monto_des;

echo "Monto original: S/ " . number_format($monto, 2) . "<br>";
echo "Porcentaje aplicado: " . $descuento . "%<br>";
echo "Monto del descuento: S/ " . number_format($monto_des, 2) . "<br>";
echo "Monto final: S/ " . number_format($monto_final, 2) . "<br>";

?>