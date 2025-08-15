<?php
header('Content-Type: application/json');
require_once '../conexion/bd.php';

try {
    $request = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($request['id'])) {
        throw new Exception('ID de usuario no proporcionado');
    }

    $id = filter_var($request['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        throw new Exception('ID inválido');
    }

    // Verificar si existen notas y materias asociadas al usuario
    $checkNotas = "SELECT COUNT(*) as total FROM notas WHERE usuario_id = :id";
    $stmtNotas = $pdo->prepare($checkNotas);
    $stmtNotas->execute([':id' => $id]);
    $totalNotas = $stmtNotas->fetch(PDO::FETCH_ASSOC)['total'];

    // Comenzar transacción
    $pdo->beginTransaction();

    // Verificar si existe la tabla estudiantes_materias
    $tableExists = $pdo->query("SHOW TABLES LIKE 'estudiantes_materias'")->rowCount() > 0;
    
    if ($tableExists) {
        // Eliminar registros de estudiantes_materias si la tabla existe
        $deleteMateriasQuery = "DELETE FROM estudiantes_materias WHERE usuario_id = :id";
        $stmtMaterias = $pdo->prepare($deleteMateriasQuery);
        $stmtMaterias->execute([':id' => $id]);
    }

    try {
        // Las notas se eliminarán automáticamente por la restricción ON DELETE CASCADE
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([':id' => $id]);

        if ($result && $stmt->rowCount() > 0) {
            $pdo->commit();
            $message = 'Usuario eliminado correctamente';
            if ($totalNotas > 0) {
                $message .= " junto con sus $totalNotas calificaciones asociadas";
            }
            echo json_encode([
                'status' => 'success',
                'message' => $message
            ]);
        } else {
            throw new Exception('No se encontró el usuario o ya fue eliminado');
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}