<?php
// Incluir la conexión a la base de datos
require_once '../conexion/bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí va el código para manejar el formulario enviado

    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $edad = $_POST['edad'] ?? '';


    // Preparar consulta de inserción SQL
    $sql = "INSERT INTO usuarios (nombre, email, edad) VALUES (:nombre, :email, :edad)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':edad', $edad);

    // Ejecutar inserción
    try {
        $stmt->execute();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Usuario guardado exitosamente',
                    background: '#1a1a2e',
                    color: '#fff',
                    confirmButtonColor: '#4a90e2',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '../indexnotas.html';
                });
            </script>
        </body>
        </html>
        <?php
        exit();
    } catch (PDOException $e) {
        echo "Error al insertar datos: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>