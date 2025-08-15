<?php
require_once '../conexion/bd.php';

$query = "SELECT * FROM materias ORDER BY nombre";
$stmt = $pdo->prepare($query);
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materias</title>
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
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #4a90e2;
            border-radius: 5px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white"><i class="bi bi-journal-text"></i> Lista de Materias</h2>
                <div>
                    <a href="../indexnotas.html" class="btn btn-secondary me-2">
                        <i class="bi bi-house-fill"></i> Inicio
                    </a>
                    <a href="crear_materia.php" class="btn btn-info">
                        <i class="bi bi-plus-circle-fill"></i> Nueva Materia
                    </a>
                </div>
            </div>

            <?php if (!empty($materias)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tablaMaterias">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo Docente</th>
                                <th>NRC</th>
                                <th class="text-center">Estudiantes</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $materia): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($materia['id']); ?></td>
                                    <td><?php echo htmlspecialchars($materia['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($materia['email']); ?></td>
                                    <td><?php echo htmlspecialchars($materia['NRC'] ?? 'N/A'); ?></td>
                                    <td class="text-center">
                                        <a href="ver_estudiantes_materia.php?id=<?php echo $materia['id']; ?>" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-people-fill"></i> Ver Estudiantes
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm btnEditarMateria" data-id="<?php echo $materia['id']; ?>">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btnEliminarMateria" 
                                                data-id="<?php echo $materia['id']; ?>"
                                                data-nombre="<?php echo htmlspecialchars($materia['nombre']); ?>">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle-fill"></i> No hay materias registradas aún.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal para editar materia -->
    <div class="modal fade" id="modalEditarMateria" tabindex="-1" aria-labelledby="modalEditarMateriaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditarMateriaLabel">
                        <i class="bi bi-pencil-square"></i> Editar Materia
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarMateria">
                        <input type="hidden" id="materia_id" name="id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Materia</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo del Docente</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="nrc" class="form-label">NRC</label>
                            <input type="text" class="form-control" id="nrc" name="nrc">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarCambios">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#tablaMaterias').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                order: [[1, 'asc']], // Ordenar por nombre
                responsive: true
            });

            // Inicializar Modal
            const modalElement = document.getElementById('modalEditarMateria');
            const modal = new bootstrap.Modal(modalElement);

            // Función para eliminar materia
            function eliminarMateria(id, nombre) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `¿Deseas eliminar la materia "${nombre}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('eliminar_materia.php', {
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
                                .then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Ocurrió un error al eliminar la materia', 'error');
                        });
                    }
                });
            }

            // Click en botón editar
            $('.btnEditarMateria').click(function() {
                const id = $(this).data('id');
                
                // Obtener datos de la materia
                fetch('obtener_materia.php', {
                    method: 'POST',
                    body: JSON.stringify({ id: id }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Error', data.error, 'error');
                        return;
                    }
                    
                    // Llenar el formulario
                    $('#materia_id').val(data.id);
                    $('#nombre').val(data.nombre);
                    $('#email').val(data.email);
                    $('#nrc').val(data.nrc);
                    
                    // Mostrar modal
                    modal.show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'No se pudieron cargar los datos de la materia', 'error');
                });
            });

            // Click en botón eliminar
            $('.btnEliminarMateria').click(function() {
                const id = $(this).data('id');
                const nombre = $(this).data('nombre');
                eliminarMateria(id, nombre);
            });

            // Click en guardar cambios
            $('#btnGuardarCambios').click(function() {
                const formData = {
                    id: $('#materia_id').val(),
                    nombre: $('#nombre').val(),
                    email: $('#email').val(),
                    nrc: $('#nrc').val()
                };

                // Validar campos requeridos
                if (!formData.nombre || !formData.email) {
                    Swal.fire('Error', 'Por favor complete los campos requeridos', 'error');
                    return;
                }

                // Enviar datos
                fetch('actualizar_materia.php', {
                    method: 'POST',
                    body: JSON.stringify(formData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: '¡Actualizado!',
                            text: data.message,
                            icon: 'success'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Ocurrió un error al actualizar la materia', 'error');
                });
            });

            // Limpiar formulario al cerrar el modal
            modalElement.addEventListener('hidden.bs.modal', function () {
                $('#formEditarMateria')[0].reset();
            });
        });
    </script>
</body>
</html>
