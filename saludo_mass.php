<?php
date_default_timezone_set('America/Lima');

$hora = (int)date("H"); 


if ($hora >= 5 && $hora <= 11) {
    $turno = "manana";
} elseif ($hora >= 12 && $hora <= 18) {
    $turno = "tarde";
} elseif ($hora >= 19 && $hora <= 23) {
    $turno = "noche";
} else {
    $turno = "cerrado"; 
}

switch ($turno) {
    case "manana":
        $saludo = "Buenos días, bienvenido a Mass";
        break;
    case "tarde":
        $saludo = "Buenas tardes, bienvenido a Mass";
        break;
    case "noche":
        $saludo = "Buenas noches, bienvenido a Mass";
        break;
    case "cerrado":
    default:
        $saludo = "Tienda cerrada en este horario";
        break;
}


echo "Hora actual: " . $hora . ":00 hrs.<br>";
echo "Mensaje:" . $saludo;
?>
