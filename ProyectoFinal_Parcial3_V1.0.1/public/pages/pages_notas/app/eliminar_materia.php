<?php
require_once '../conexion/bd.php';

// Obtener el ID del body
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID no proporcionado'
    ]);
    exit;
}

try {
    // Iniciar transacción
    $pdo->beginTransaction();

    // Primero eliminar las notas asociadas
    $query = "DELETE FROM notas WHERE materia_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    // Verificar si existe la tabla estudiantes_materias
    $stmt = $pdo->query("SHOW TABLES LIKE 'estudiantes_materias'");
    if ($stmt->rowCount() > 0) {
        // Si existe la tabla, eliminar las relaciones
        $query = "DELETE FROM estudiantes_materias WHERE materia_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
    }

    // Finalmente eliminar la materia
    $query = "DELETE FROM materias WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    // Verificar si se eliminó la materia
    if ($stmt->rowCount() > 0) {
        $pdo->commit();
        echo json_encode([
            'status' => 'success',
            'message' => 'Materia eliminada con éxito'
        ]);
    } else {
        $pdo->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'No se encontró la materia'
        ]);
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al eliminar la materia: ' . $e->getMessage()
    ]);
}
