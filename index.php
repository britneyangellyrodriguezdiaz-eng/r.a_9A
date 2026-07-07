<?php
session_start();
require 'conexion.php';

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Consultar los registros de la base de datos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Mi Aplicación Web</span>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Inventario de Productos</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Producto</th>
                            <th>Precio</th>
                            <th>Stock Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            // Corrección aquí también por si acaso:
            echo "<td>$" . number_format($row['precio'], 2) . "</td>";
            echo "<td>" . $row['stock'] . " u</td>";
            echo "</tr>";
        }
    } else {
        // AQUÍ ESTABA EL ERROR (Faltaba el echo y las comillas):
        echo "<tr><td colspan='4' class='text-center'>No hay registros disponibles.</td></tr>";
    }
    ?>
</tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>