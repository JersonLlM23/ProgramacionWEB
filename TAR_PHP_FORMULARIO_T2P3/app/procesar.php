<?php
header('Content-Type: text/plain; charset=utf-8');

// Obtener la operación solicitada
$operacion = $_POST['operacion'] ?? '';

switch ($operacion) {
    case 'suma':
        $num1 = $_POST['numero1'] ?? 0;
        $num2 = $_POST['numero2'] ?? 0;
        $resultado = $num1 + $num2;
        echo "El resultado de la suma es: $resultado";
        break;

    case 'tabla':
        $numero = $_POST['numeroTabla'] ?? 0;
        $tabla = "<ul style='list-style-type: none; padding: 0; margin: 0;'>";
        for ($i = 1; $i <= 10; $i++) {
            $resultado = $numero * $i;
            $tabla .= "<li>$numero × $i = $resultado</li>";
        }
        $tabla .= "</ul>";
        header('Content-Type: text/html; charset=utf-8');
        echo $tabla;
        break;

    case 'parimpar':
        $numero = $_POST['numeroParImpar'] ?? 0;
        $resultado = ($numero % 2 == 0) ? "Par" : "Impar";
        echo "El número $numero es: $resultado";
        break;

    case 'edad':
        $anioNacimiento = $_POST['anioNacimiento'] ?? 0;
        $anioActual = date('Y');
        $edad = $anioActual - $anioNacimiento;
        echo "Tu edad actual es: $edad años";
        break;

    default:
        echo "Operación no válida";
}
?>
