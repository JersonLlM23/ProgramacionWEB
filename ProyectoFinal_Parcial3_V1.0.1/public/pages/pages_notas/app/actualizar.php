<?php
header('Content-Type: application/json');
require_once '../conexion/bd.php';

try {
    $request = json_decode(file_get_contents('php://input'), true);
    
    // Validar que vengan todos los campos requeridos
    if (!isset($request['id'], $request['nombre'], $request['email'], $request['edad'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    $id = filter_var($request['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        throw new Exception('ID inválido');
    }

    $nombre = trim($request['nombre']);
    if (empty($nombre)) {
        throw new Exception('El nombre no puede estar vacío');
    }

    $email = filter_var(trim($request['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception('Correo electrónico inválido');
    }

    $edad = filter_var($request['edad'], FILTER_VALIDATE_INT);
    if ($edad === false || $edad < 0 || $edad > 120) {
        throw new Exception('Edad inválida');
    }

    // Verificar si el email ya existe para otro usuario
    $checkEmail = "SELECT id FROM usuarios WHERE email = :email AND id != :id";
    $stmtEmail = $pdo->prepare($checkEmail);
    $stmtEmail->execute([':email' => $email, ':id' => $id]);
    
    if ($stmtEmail->rowCount() > 0) {
        throw new Exception('El correo electrónico ya está registrado para otro usuario');
    }

    // Actualizar usuario
    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, edad = :edad WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $result = $stmt->execute([
        ':id' => $id,
        ':nombre' => $nombre,
        ':email' => $email,
        ':edad' => $edad
    ]);

    if ($result && $stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente'
        ]);
    } else {
        throw new Exception('No se encontró el usuario o no hay cambios para actualizar');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

?>