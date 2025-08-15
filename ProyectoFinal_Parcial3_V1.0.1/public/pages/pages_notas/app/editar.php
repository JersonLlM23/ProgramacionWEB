<?php
require_once '../conexion/bd.php';

// Verificar si se recibió un ID
if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

// Obtener datos del usuario
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si no existe el usuario, redirigir
if (!$usuario) {
    header('Location: listar.php');
    exit;
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];

    // Validar datos
    if (empty($nombre) || empty($email) || empty($edad)) {
        $error = "Todos los campos son obligatorios";
    } else {
        // Actualizar usuario
        $query = "UPDATE usuarios SET nombre = ?, email = ?, edad = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        
        try {
            $stmt->execute([$nombre, $email, $edad, $id]);
            header('Location: listar.php?mensaje=actualizado');
            exit;
        } catch (PDOException $e) {
            $error = "Error al actualizar el usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante - Sistema de Notas</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1f35 0%, #2a3245 100%);
            color: #ffffff;
            min-height: 100vh;
            padding-top: 40px;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-container form {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="text-center mb-4">
                <i class="bi bi-pencil-square" style="font-size: 3rem;"></i>
                <h1>Editar Estudiante</h1>
                <p class="text-light">Actualiza la información del estudiante</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="edad" class="form-label">Edad</label>
                    <input type="number" class="form-control" id="edad" name="edad" 
                           value="<?php echo htmlspecialchars($usuario['edad']); ?>" 
                           required min="0" max="120">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="listar.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
