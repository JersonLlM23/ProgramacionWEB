<?php

require_once '../conexion/bd.php';

/* consulta de datos con pdo - JOIN para obtener nombres de usuario y materia */
$query = "SELECT 
            notas.id,
            usuarios.nombre AS usuario_nombre, 
            materias.nombre AS materia_nombre, 
            notas.n1, 
            notas.n2, 
            notas.n3, 
            ROUND((notas.n1 + notas.n2 + notas.n3) / 3, 2) as promedio,
            CASE 
                WHEN ROUND((notas.n1 + notas.n2 + notas.n3) / 3, 2) >= 14 THEN 'APROBADO'
                ELSE 'DESAPROBADO'
            END as estado
          FROM notas
          JOIN usuarios ON notas.usuario_id = usuarios.id 
          JOIN materias ON notas.materia_id = materias.id
          ORDER BY notas.id";

$stmt = $pdo->prepare($query);
$stmt->execute();
$notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Notas Estelares - CRUD</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@magicbruno/swalstrap5@1.0.8/dist/css/swalstrap.min.css">
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
            margin-bottom: 2rem;
        }
        .table {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0;
        }
        .badge-aprobado {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
        }
        .badge-desaprobado {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
        }
        .table thead th {
            background-color: #1a1f35;
            color: white;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.98);
        }
        .table tbody tr:nth-of-type(even) {
            background-color: rgba(255, 255, 255, 0.95);
        }
        .table tbody tr:hover {
            background-color: rgba(74, 144, 226, 0.1);
        }
        .nota-celda {
            font-family: 'Consolas', monospace;
            text-align: center;
        }
        .promedio-celda {
            font-weight: bold;
            text-align: center;
            background-color: rgba(74, 144, 226, 0.1);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="text-center flex-grow-1">
                <i class="bi bi-stars" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h1>Registro Estelar de Calificaciones</h1>
                <p class="text-light">Observatorio de Rendimiento Académico</p>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-4">
 
            <div>
                <a href="../indexnotas.html" class="btn btn-secondary me-2">
                    <i class="bi bi-house-fill"></i> Inicio
                </a>
                <a href="ingresarnotas.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill"></i> Nueva Calificación
                </a>
            </div>
        </div>
    
<!-- verificar si hay notas -->

<?php if(!empty($notas)): ?>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Materia</th>
                    <th class="text-center">Nota 1</th>
                    <th class="text-center">Nota 2</th>
                    <th class="text-center">Nota 3</th>
                    <th class="text-center">Promedio</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>




                    <?php foreach($notas as $nota): ?>
            <tr>
                <td><?php echo htmlspecialchars($nota['usuario_nombre']); ?></td>
                <td><?php echo htmlspecialchars($nota['materia_nombre']); ?></td>
                <td class="nota-celda"><?php echo number_format($nota['n1'], 2); ?></td>
                <td class="nota-celda"><?php echo number_format($nota['n2'], 2); ?></td>
                <td class="nota-celda"><?php echo number_format($nota['n3'], 2); ?></td>
                <td class="promedio-celda"><?php echo number_format($nota['promedio'], 2); ?></td>
                <td class="text-center">
                    <?php 
                    $badgeClass = ($nota['estado'] === 'APROBADO') ? 'badge-aprobado' : 'badge-desaprobado';
                    ?>
                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $nota['estado']; ?></span>
                </td>
                <td class="text-center">
                    <a href="editar_nota.php?id=<?php echo $nota['id']; ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <button type="button" 
                            class="btn btn-danger btn-sm btnEliminarNota" 
                            data-id="<?php echo $nota['id']; ?>" 
                            data-estudiante="<?php echo htmlspecialchars($nota['usuario_nombre']); ?>"
                            data-materia="<?php echo htmlspecialchars($nota['materia_nombre']); ?>">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    
<div class="text-center mt-4">
    <a href="../indexnotas.html" class="btn btn-secondary">
        <i class="fas fa-home"></i> Volver al Inicio
    </a>
</div>

<?php else: ?>

<div class="text-center py-5">
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">¡No hay notas registradas!</h4>
        <p>Aún no se han registrado notas en el sistema.</p>
        <hr>
        <p class="mb-0">
            <a href="ingresarnotas.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ingresar primera nota
            </a>
        </p>
    </div>
    
    <div class="text-center mt-4">
        <a href="../indexnotas.html" class="btn btn-secondary">
            <i class="fas fa-home"></i> Volver al Inicio
        </a>
    </div>
</div>

<?php endif; ?>

</div>

<script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sweet Alert de bienvenida
 

    // Función para eliminar nota
    function eliminarNota(id, estudiante, materia) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `¿Deseas eliminar la calificación de ${estudiante} en la materia ${materia}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '¡Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('eliminar_nota.php', {
                    method: 'POST',
                    body: JSON.stringify({ id: id }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('¡Eliminado!', data.message, 'success')
                        .then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al eliminar la calificación', 'error');
                });
            }
        });
    }

    // Agregar event listeners a los botones de eliminar
    document.querySelectorAll('.btnEliminarNota').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const estudiante = this.getAttribute('data-estudiante');
            const materia = this.getAttribute('data-materia');
            eliminarNota(id, estudiante, materia);
        });
    });

    // Añadir botón de estadísticas
    const botonesContainer = document.querySelector('.d-flex.justify-content-between.mb-4 div');
    const btnEstadisticas = document.createElement('button');
    btnEstadisticas.className = 'btn btn-info';
    btnEstadisticas.innerHTML = '<i class="bi bi-graph-up"></i> Ver Estadísticas';
    btnEstadisticas.onclick = calcularEstadisticas;
    botonesContainer.appendChild(btnEstadisticas);
});

function calcularEstadisticas() {
    const filas = document.querySelectorAll('table tbody tr');
    const totalAlumnos = filas.length;
    let aprobados = 0;
    let sumaPromedios = 0;

    filas.forEach(fila => {
        const promedio = parseFloat(fila.querySelector('.promedio-celda').textContent);
        sumaPromedios += promedio;
        if (promedio >= 14) aprobados++;
    });

    const promedioGeneral = (sumaPromedios / totalAlumnos).toFixed(2);
    const porcentajeAprobados = ((aprobados / totalAlumnos) * 100).toFixed(1);

    Swal.fire({
        title: 'Estadísticas Generales',
        html: `
            <div class="text-start">
                <p><strong>Total de Alumnos:</strong> ${totalAlumnos}</p>
                <p><strong>Promedio General:</strong> ${promedioGeneral}</p>
                <p><strong>Porcentaje de Aprobados:</strong> ${porcentajeAprobados}%</p>
            </div>
        `,
        icon: 'info',
        background: 'linear-gradient(135deg, #1a1f35 0%, #2a3245 100%)',
        color: '#ffffff',
        confirmButtonColor: '#4a90e2'
    });
}
</script>

</body>
</html>
