<?php
require_once '../conexion/bd.php';

// Obtener datos del body
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos requeridos
if (!isset($data['id']) || !isset($data['nombre']) || !isset($data['email'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan datos requeridos'
    ]);
    exit;
}

try {
    // Preparar la consulta
    $query = "UPDATE materias SET nombre = ?, email = ?, nrc = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    
    // Ejecutar la consulta
    $stmt->execute([
        $data['nombre'],
        $data['email'],
        $data['nrc'],
        $data['id']
    ]);

    // Verificar si se actualizó la materia
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Materia actualizada con éxito'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró la materia o no se realizaron cambios'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al actualizar la materia: ' . $e->getMessage()
    ]);
}
