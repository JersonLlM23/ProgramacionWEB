<?php
require_once '../conexion/bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener la nota actual
    $stmt = $pdo->prepare("SELECT * FROM notas WHERE id = ?");
    $stmt->execute([$id]);
    $nota = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nota) {
        header('Location: mostrarnotas.php');
        exit;
    }

    // Obtener lista de usuarios y materias para los select
    $stmtUsuarios = $pdo->query("SELECT id, nombre FROM usuarios ORDER BY nombre");
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    $stmtMaterias = $pdo->query("SELECT id, nombre FROM materias ORDER BY nombre");
    $materias = $stmtMaterias->fetchAll(PDO::FETCH_ASSOC);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar la actualización
    $id = $_POST['id'];
    $usuario_id = $_POST['usuario_id'];
    $materia_id = $_POST['materia_id'];
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    $n3 = $_POST['n3'];

    try {
        $stmt = $pdo->prepare("UPDATE notas SET usuario_id = ?, materia_id = ?, n1 = ?, n2 = ?, n3 = ? WHERE id = ?");
        $stmt->execute([$usuario_id, $materia_id, $n1, $n2, $n3, $id]);
        
        header('Location: mostrarnotas.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error al actualizar la nota: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Calificación - Sistema de Notas</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1f35 0%, #2a3245 100%);
            color: #ffffff;
            min-height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="form-container">
        <div class="text-center mb-4">
            <i class="bi bi-stars" style="font-size: 3rem;"></i>
            <h1>Editar Calificación</h1>
            <p class="text-light">Actualiza los datos de la calificación</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="editar_nota.php">
            <input type="hidden" name="id" value="<?php echo $nota['id']; ?>">
            
            <div class="mb-3">
                <label for="usuario_id" class="form-label">Estudiante</label>
                <select class="form-select" id="usuario_id" name="usuario_id" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>" 
                                <?php echo ($usuario['id'] == $nota['usuario_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($usuario['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="materia_id" class="form-label">Materia</label>
                <select class="form-select" id="materia_id" name="materia_id" required>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['id']; ?>"
                                <?php echo ($materia['id'] == $nota['materia_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($materia['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="n1" class="form-label">Nota 1</label>
                    <input type="number" class="form-control" id="n1" name="n1" 
                           value="<?php echo $nota['n1']; ?>" required step="0.01" min="0" max="20">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="n2" class="form-label">Nota 2</label>
                    <input type="number" class="form-control" id="n2" name="n2" 
                           value="<?php echo $nota['n2']; ?>" required step="0.01" min="0" max="20">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="n3" class="form-label">Nota 3</label>
                    <input type="number" class="form-control" id="n3" name="n3" 
                           value="<?php echo $nota['n3']; ?>" required step="0.01" min="0" max="20">
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="mostrarnotas.php" class="btn btn-secondary me-md-2">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
