<?php

require_once '../conexion/bd.php';

/* consulta de datos con pdo */
$query = "SELECT * FROM usuarios ORDER BY id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Estudiantes - Sistema de Notas</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
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
            color: #333;
        }
        /* Estilos para la tabla y contenedor */
    </style>
</head>
<body>

<div class="container py-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="text-center flex-grow-1">
                <i class="bi bi-stars" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h1>Registro de Exploradores Estelares</h1>
                <p class="text-light">Administra los miembros de nuestra comunidad astronómica</p>
            </div>
        </div>
        <div class="text-end mb-4">
            <a href="crear.php" class="btn btn-primary">
                <i class="bi bi-person-plus-fill"></i> Nuevo Explorador
            </a>
        </div>
    
<!-- verificar si hay usuarios -->

<?php if(!empty($usuarios)): ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="tablaUsuarios">
            <thead class="table-dark">
                <tr> 
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Edad</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
        <tbody>
            <?php foreach($usuarios as $usuario): ?>
            <tr>
 
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td><?php echo htmlspecialchars($usuario['edad']); ?></td>
                <td>
                    <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>



                    <!-- <a href="eliminar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm" 
                       onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
 -->
                    <button type="button" 
                    class="btn btn-danger btn-sm btnEliminarUsuario" 
                    data-id="<?php echo $usuario['id']; ?>" 
                    data-nombre="<?php echo htmlspecialchars($usuario['nombre']); ?>"
                    >Eliminar</button>

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
        <h4 class="alert-heading">¡No hay usuarios registrados!</h4>
        <p>Aún no se han registrado usuarios en el sistema.</p>
        <hr>
        <p class="mb-0">
            <a href="crear.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear primer usuario
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




<!-- Modal para eliminar usuario -->

</div>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTable
    
    // Inicializar DataTable
    $('#tablaUsuarios').DataTable({
        pageLength: 10,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Función para eliminar usuario con confirmación personalizada
function EliminarUsuario(id, nombre) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Estás seguro de eliminar el usuario "${nombre}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '¡Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Usar fetch para eliminar el usuario
            fetch('eliminar.php', {
                method: 'POST',
                body: JSON.stringify({ id: id }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.status === 'success') {
                    Swal.fire('¡Eliminado!', data.message, 'success')
                    .then(() => {
                        // Recargar la página para actualizar la tabla
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(function(error) {
                console.error('Error al eliminar el usuario:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar el usuario', 'error');
            });
        }
    });
}




    // Manejar clic en botón eliminar
    $('.btnEliminarUsuario').click(function() {
        var idUser = $(this).data('id');
        var nombreUser = $(this).data('nombre');
        EliminarUsuario(idUser, nombreUser);
    });
});



</script>
</body>
</html>