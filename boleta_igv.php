<?php
$subtotal  = "120.50";
$igv       = 0.18;
$total     = ($subtotal * $igv);

echo "Subtotal: S/ " . $subtotal . "<br>";
echo "<hr>";
echo "IGV (18%): S/ " . number_format($total, 2) . "<br>";
echo "<hr>";
echo "Total a pagar: S/ " . number_format($subtotal + $total, 2);
echo "<hr>";
echo "Gracias por su compra!";
?>  
