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

    $sql = "SELECT id, nombre, email, edad FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        echo json_encode($usuario);
    } else {
        throw new Exception('Usuario no encontrado');
    }

} catch (Exception $e) {
    http_response_code(404);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}

?>