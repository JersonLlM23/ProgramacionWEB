<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Materia</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        .card-header {
            background: rgba(74, 144, 226, 0.3) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .form-label {
            color: #ffffff;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #4a90e2;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-info {
            background-color: #4a90e2;
            border-color: #4a90e2;
            color: #ffffff;
        }
        .btn-info:hover {
            background-color: #357abd;
            border-color: #357abd;
            color: #ffffff;
        }
        .invalid-feedback {
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h2 class="text-center mb-0">Registrar Nueva Materia</h2>
            </div>
            
            <div class="card-body">
                <form id="formMateria" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Materia</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese el nombre de la materia
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo del Docente</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un correo válido
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nrc" class="form-label">NRC</label>
                        <input type="text" id="nrc" name="nrc" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese el NRC de la materia
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-info">
                            <i class="bi bi-save"></i> Registrar Materia
                        </button>
                        <a href="../indexnotas.html" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Inicio
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('formMateria').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('guardar_materia.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#17a2b8',
                        background: 'white'
                    }).then(() => {
                        window.location.href = 'listar_materias.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#17a2b8',
                        background: 'white'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud',
                    icon: 'error',
                    confirmButtonColor: '#17a2b8',
                    background: 'white'
                });
            });
        });
    </script>
</body>
</html>
