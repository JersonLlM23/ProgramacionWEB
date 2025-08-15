<?php
header('Content-Type: application/json');
require_once '../conexion/bd.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de solicitud no válido');
    }

    // Validar que se recibieron todos los datos necesarios
    $camposRequeridos = ['usuario_id', 'materia_id', 'nota_1', 'nota_2', 'nota_3'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    // Validar que las notas estén en el rango correcto
    $notas = [
        'nota_1' => floatval($_POST['nota_1']),
        'nota_2' => floatval($_POST['nota_2']),
        'nota_3' => floatval($_POST['nota_3'])
    ];

    foreach ($notas as $nombre => $valor) {
        if ($valor < 0 || $valor > 20) {
            throw new Exception("La {$nombre} debe estar entre 0 y 20");
        }
    }

    $usuario_id = $_POST['usuario_id'];
    $materia_id = $_POST['materia_id'];
    $nota_1 = floatval($notas['nota_1']);
    $nota_2 = floatval($notas['nota_2']);
    $nota_3 = floatval($notas['nota_3']);
    $promedio = round(($nota_1 + $nota_2 + $nota_3) / 3, 2);

    // Asegurarnos de que el promedio esté calculado correctamente
    if ($promedio != round(($nota_1 + $nota_2 + $nota_3) / 3, 2)) {
        throw new Exception("Error en el cálculo del promedio");
    }

    // Verificar si ya existe una nota para este estudiante en esta materia
    $checkSql = "SELECT id FROM notas WHERE usuario_id = :usuario_id AND materia_id = :materia_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        ':usuario_id' => $usuario_id,
        ':materia_id' => $materia_id
    ]);

    if ($checkStmt->rowCount() > 0) {
        throw new Exception('Ya existen calificaciones registradas para este estudiante en esta materia');
    }

    $sql = "INSERT INTO notas (usuario_id, materia_id, n1, n2, n3, promedio) 
            VALUES (:usuario_id, :materia_id, :n1, :n2, :n3, :promedio)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':materia_id' => $materia_id,
        ':n1' => $nota_1,
        ':n2' => $nota_2,
        ':n3' => $nota_3,
        ':promedio' => $promedio
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Calificaciones registradas correctamente',
        'data' => [
            'promedio' => $promedio
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

?>