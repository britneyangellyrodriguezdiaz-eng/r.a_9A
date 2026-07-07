<?php
session_start();
require 'conexion.php';

// Si ya está logueado, redirigir al panel principal
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        // Por esto (encripta la contraseña que escribe el usuario en SHA1 y la compara):
            if (sha1($password) === $row['password']) {
            $_SESSION['usuario'] = $row['usuario'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
                        
                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" name="usuario" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>