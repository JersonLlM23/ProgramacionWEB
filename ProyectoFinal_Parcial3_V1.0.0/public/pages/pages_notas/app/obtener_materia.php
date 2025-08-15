<?php
require_once '../conexion/bd.php';

// Obtener el ID de la materia del body
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Consultar la materia
$query = "SELECT id, nombre, email, nrc FROM materias WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$materia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$materia) {
    echo json_encode(['error' => 'Materia no encontrada']);
    exit;
}

// Devolver los datos de la materia
echo json_encode($materia);
