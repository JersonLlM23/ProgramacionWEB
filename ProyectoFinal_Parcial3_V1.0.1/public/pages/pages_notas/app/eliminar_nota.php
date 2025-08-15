<?php
require_once '../conexion/bd.php';

// Recibir datos JSON
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if ($id) {
    try {
        // Preparar la consulta para eliminar la nota
        $stmt = $pdo->prepare("DELETE FROM notas WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Nota eliminada correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontró la nota']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al eliminar la nota: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de nota no proporcionado']);
}
?>
