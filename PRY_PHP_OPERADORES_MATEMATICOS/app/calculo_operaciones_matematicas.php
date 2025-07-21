<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Resultado </title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>
    
    <h1 class="text-center mt-5">Resultado de las Operaciones Matemáticas</h1>

    <?php
    /* capturar datos del fomulario */
    $numero1 = $_GET['txt_numero1'];
    $numero2 = $_GET['txt_numero2'];
    $suma = $numero1 + $numero2;
    $resta = $numero1 - $numero2;
    $multiplicacion = $numero1 * $numero2;
    $division = $numero1 / $numero2;
    ?>

 <div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card mt-5">
                <div class="card-body">
                    <h3 class="alert alert-warning">Resultados de las Operaciones</h3>
                    <div class="alert alert-info" role="alert">Suma: <?php echo $suma; ?></div>
                    <div class="alert alert-success">Resta: <?php echo $resta; ?></div>
                    <div class="alert alert-info">Multiplicación: <?php echo $multiplicacion; ?></div>
                    <div class="alert alert-success">División: <?php echo $division; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-1">
        <a href="../index.html" class="btn btn-primary">Volver al Inicio</a>
 </div>
   

 <script src="../public/lib/bootstrap-5.3.5-dist/js/bootstrap.min.js"></script>    
</body>
</html>