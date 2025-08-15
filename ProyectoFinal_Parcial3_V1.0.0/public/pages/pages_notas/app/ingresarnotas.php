
<?php
require_once '../conexion/bd.php';

$query = "SELECT * FROM usuarios";
$stm = $pdo->prepare($query);
$stm->execute();
$usuarios = $stm->fetchAll(PDO::FETCH_ASSOC);

$queryMaterias = "SELECT * FROM materias";
$stmMaterias = $pdo->prepare($queryMaterias);
$stmMaterias->execute();
$materias = $stmMaterias->fetchAll(PDO::FETCH_ASSOC);


?>
<!-- Consultar usuarios de base de datos -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Calificaciones Estelares</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@magicbruno/swalstrap5@1.0.8/dist/css/swalstrap.min.css">
</head>
<body class="form-page">

<div class="container-fluid">
    <div class="form-container">
        <div class="form-header">
            <i class="bi bi-stars" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h2>Registro de Calificaciones Estelares</h2>
            <p>Sistema de Evaluación Astronómica</p>
        </div>

    <form action="guardar_notas.php" id="formIngresarNotas" method="POST" class="user-form">
        <div class="form-group">
            <label for="usuario_id">Estudiante</label>
            <select name="usuario_id" id="usuario_id" class="form-control" required>
                <option value="">Selecciona un estudiante</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>"><?= $usuario['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="materia_id">Constelación de Estudio</label>
            <select name="materia_id" id="materia_id" class="form-control" required>
                <option value="">Selecciona una materia</option>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?= $materia['id'] ?>"><?= $materia['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nota_1">Primera Nota</label>
                    <input type="number" name="nota_1" id="nota1" class="form-control" step="0.01" required max="20" min="0" placeholder="0.00">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nota_2">Segunda Nota</label>
                    <input type="number" name="nota_2" id="nota2" class="form-control" step="0.01" max="20" min="0" placeholder="0.00">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nota_3">Tercera Nota</label>
                    <input type="number" name="nota_3" id="nota3" class="form-control" step="0.01" required max="20" min="0" placeholder="0.00">
                </div>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">
                <i class="bi bi-stars"></i> Registrar Calificaciones
            </button>
            <a href="../indexnotas.html" class="btn-cancel">
                <i class="bi bi-arrow-left-circle-fill"></i> Volver al Inicio
            </a>
        </div>
    </form>

<script src="../../../assets/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
<script>
    const formIngresarNotas = document.getElementById('formIngresarNotas');
    formIngresarNotas.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(formIngresarNotas);
        fetch('guardar_notas.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.text();
        })
        .then(function(data) {
            console.log(data);
            Swal.fire({
                title: '¡Éxito Estelar!',
                text: 'Las calificaciones han sido registradas en el observatorio',
                icon: 'success',
                confirmButtonText: 'Continuar',
                background: 'linear-gradient(135deg, #1a1f35 0%, #2a3245 100%)',
                color: '#ffffff',
                iconColor: '#4a90e2',
                confirmButtonColor: '#4a90e2'
            });
            formIngresarNotas.reset();
        })
        .catch(function(error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error en la Transmisión',
                text: 'Hubo un problema al registrar las calificaciones',
                icon: 'error',
                confirmButtonText: 'Intentar de nuevo',
                background: 'linear-gradient(135deg, #1a1f35 0%, #2a3245 100%)',
                color: '#ffffff',
                iconColor: '#ff416c',
                confirmButtonColor: '#4a90e2'
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@magicbruno/swalstrap5@1.0.8/dist/js/swalstrap5_all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>