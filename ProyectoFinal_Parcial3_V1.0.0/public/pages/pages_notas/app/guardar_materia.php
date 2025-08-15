<?php
header('Content-Type: application/json');
require_once '../conexion/bd.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método de solicitud no válido');
    }

    // Validar que se recibieron todos los datos necesarios
    $camposRequeridos = ['nombre', 'email', 'nrc'];
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("El campo {$campo} es requerido");
        }
    }

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $nrc = trim($_POST['nrc']);

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El formato del correo electrónico no es válido');
    }

    // Validar si ya existe el email o NRC
    $checkSql = "SELECT id FROM materias WHERE email = :email OR NRC = :nrc";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        ':email' => $email,
        ':nrc' => $nrc
    ]);

    if ($checkStmt->rowCount() > 0) {
        throw new Exception('Ya existe una materia con ese correo o NRC');
    }

    // Insertar la nueva materia
    $sql = "INSERT INTO materias (nombre, email, NRC) VALUES (:nombre, :email, :nrc)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':email' => $email,
        ':nrc' => $nrc
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Materia registrada correctamente'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
