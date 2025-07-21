<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada</title>
    <link rel="stylesheet" href="../public/lib/bootstrap-5.3.5-dist/css/bootstrap.min.css">
</head>
<body>

<h1 class="text-center mt-5">Resultado de Verificación de Edad</h1>

<!-- Capturar valores del formulario -->
 <?php
    $txt_edad1 = $_GET['txt_edad1'];
    $txt_edad2 = $_GET['txt_edad2'];
 ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h3>Control de personas</h3>
                </div>
                <div class="card-body">
                    <?php
                    if($txt_edad1>=18){ ?>
                        <div class="alert alert-success text-center">
                            <h4> Persona 1 puede ingresar</h4>
                            </div>
                    <?php
                    } else { ?>
                        <div class="alert alert-danger text-center">
                            <h4>Persona 1 no puede ingresar</h4>
                            </div>
                    <?php } ?>

                    <?php
                    if($txt_edad2<18){ ?>
                        <div class="alert alert-danger text-center">
                            <h4>Persona 2 no puede ingresar</h4>
                            </div>
                    <?php
                    } else { ?>
                        <div class="alert alert-success text-center">
                            <h4>Persona 2 puede ingresar</h4>
                            </div>
                    <?php } ?>
                                    
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="../index.html" class="btn btn-primary">Volver al Inicio</a>
    </div>
</div>


</body>
</html>