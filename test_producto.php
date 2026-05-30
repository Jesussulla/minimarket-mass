<?php
header('Content-Type: text/plain');
require_once __DIR__ . '/clases/Producto.php';

echo "=== TEST CLASE PRODUCTO ===\n\n";

// --- Producto gravado con IGV ---
$arroz = new Producto('P001', 'Arroz Costeño 1kg', 'abarrotes', 4.50, 10);

echo "Nombre:        " . $arroz->getNombre() . "\n";
echo "Precio s/IGV:  S/ " . number_format($arroz->getPrecio(), 2) . "\n";
echo "Tasa IGV:      " . ($arroz->tasaIGV() * 100) . "%\n";
echo "Precio c/IGV:  S/ " . number_format($arroz->precioConIGV(), 2) . "\n";
echo "Stock actual:  " . $arroz->getStock() . "\n";
echo "¿Stock p/5?    " . ($arroz->haySuficienteStock(5) ? 'Sí' : 'No') . "\n";
$arroz->descontarStock(5);
echo "Stock tras -5: " . $arroz->getStock() . "\n";

echo "\n";

// --- Producto exonerado ---
$pan = new Producto('P003', 'Pan de Molde Mass', 'panaderia', 7.20, 5);

echo "Nombre:        " . $pan->getNombre() . "\n";
echo "Tasa IGV:      " . ($pan->tasaIGV() * 100) . "%  <- inafecto\n";
echo "Precio c/IGV:  S/ " . number_format($pan->precioConIGV(), 2) . "  <- igual al neto\n";

echo "\n";

// --- Test excepción por stock insuficiente ---
echo "Test excepción (pedir 99 unidades de pan, stock=5):\n";
try {
    $pan->descontarStock(99);
} catch (RuntimeException $e) {
    echo "CAPTURADO -> " . $e->getMessage() . "\n";
}

echo "\n=== FIN TEST ===\n";