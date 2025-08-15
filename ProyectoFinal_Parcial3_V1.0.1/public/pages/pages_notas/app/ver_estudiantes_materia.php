<?php
require_once '../conexion/bd.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: listar_materias.php');
    exit;
}

$materia_id = $_GET['id'];

// Obtener información de la materia
$queryMateria = "SELECT id, nombre, email, COALESCE(nrc, 'No asignado') as nrc FROM materias WHERE id = :id";
$stmtMateria = $pdo->prepare($queryMateria);
$stmtMateria->execute([':id' => $materia_id]);
$materia = $stmtMateria->fetch(PDO::FETCH_ASSOC);

if (!$materia) {
    header('Location: listar_materias.php');
    exit;
}

// Obtener estudiantes y sus notas en esta materia
$queryEstudiantes = "
    SELECT 
        u.id,
        u.nombre,
        u.email,
        n.n1,
        n.n2,
        n.n3,
        n.promedio
    FROM usuarios u
    LEFT JOIN notas n ON u.id = n.usuario_id AND n.materia_id = :materia_id
    ORDER BY u.nombre";

$stmtEstudiantes = $pdo->prepare($queryEstudiantes);
$stmtEstudiantes->execute([':materia_id' => $materia_id]);
$estudiantes = $stmtEstudiantes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes en <?php echo htmlspecialchars($materia['nombre']); ?></title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1f35 0%, #2a3245 100%);
            color: #ffffff;
        }
        .table-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
        }
        .table {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            overflow: hidden;
        }
        .materia-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="materia-info">
            <h2><i class="bi bi-journal-text"></i> <?php echo htmlspecialchars($materia['nombre']); ?></h2>
            <p><strong>NRC:</strong> <?php echo isset($materia['nrc']) ? htmlspecialchars($materia['nrc']) : 'No asignado'; ?></p>
            <p><strong>Docente:</strong> <?php echo htmlspecialchars($materia['email']); ?></p>
        </div>

        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-white">Estudiantes Matriculados</h3>
                <div>
                    <a href="listar_materias.php" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Volver a Materias
                    </a>
                    <a href="../indexnotas.html" class="btn btn-info">
                        <i class="bi bi-house-fill"></i> Inicio
                    </a>
                </div>
            </div>

            <?php if (!empty($estudiantes)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tablaEstudiantes">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Nota 1</th>
                                <th>Nota 2</th>
                                <th>Nota 3</th>
                                <th>Promedio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($estudiante['email']); ?></td>
                                    <td><?php echo $estudiante['n1'] ? number_format($estudiante['n1'], 2) : 'N/A'; ?></td>
                                    <td><?php echo $estudiante['n2'] ? number_format($estudiante['n2'], 2) : 'N/A'; ?></td>
                                    <td><?php echo $estudiante['n3'] ? number_format($estudiante['n3'], 2) : 'N/A'; ?></td>
                                    <td>
                                        <?php if ($estudiante['promedio']): ?>
                                            <strong><?php echo number_format($estudiante['promedio'], 2); ?></strong>
                                        <?php else: ?>
                                            Sin notas
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($estudiante['promedio']): ?>
                                            <?php if ($estudiante['promedio'] >= 14): ?>
                                                <span class="badge bg-success">Aprobado</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Desaprobado</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Pendiente</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle-fill"></i> No hay estudiantes registrados en esta materia.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablaEstudiantes').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                order: [[0, 'asc']], // Ordenar por nombre
                responsive: true
            });
        });
    </script>
</body>
</html>
