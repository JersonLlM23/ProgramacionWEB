<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - CRUD</title>
    <link rel="stylesheet" href="../../../assets/bootstrap-5.3.5-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="form-page">

    <div class="container-fluid">
        <div class="form-container">
            <div class="form-header">
                <i class="bi bi-stars" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h2>Registro Estelar</h2>
                <p>Únete a nuestra comunidad astronómica</p>
            </div>
            
            <form action="guardar.php" method="POST" class="user-form">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" placeholder="Ingresa tu edad" min="1" max="120" class="form-control" required>
                </div>
                
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">
                        <span>💾</span> Guardar Usuario
                    </button>
                    <a href="../indexnotas.html" class="btn-cancel">
                        <span>↩️</span> Volver al Inicio
                    </a>
                </div>
            </form>
        </div>
    </div>

<script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>   
</body>
</html>