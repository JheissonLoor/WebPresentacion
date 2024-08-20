<?php
// incluir en la página actual la página cls_Conectar.php
include("cls_conectar/cls_Conectar.php");

// crear objeto de la clase Conexion
$bean = new Conexion();

// sentencia SQL
$sql = "SELECT * FROM Cliente";

// ejecutar sentencia SQL y guardar su valor de retorno en una variable
$rsCliente = mysqli_query($bean->getConexion(), $sql);

// Manejar el envío del formulario para agregar un nuevo cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados del formulario
    $cliente_id = $_POST['cliente_id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL de inserción
    $sql = "INSERT INTO Cliente (cliente_id, nombre, email, contraseña) VALUES ('$cliente_id', '$nombre', '$email', '$contrasena')";

    // Ejecutar la consulta de inserción
    if (mysqli_query($bean->getConexion(), $sql)) {
        // Redirigir a la página actual para evitar envío duplicado del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Manejar el error en caso de fallar la inserción
        echo "Error: " . mysqli_error($bean->getConexion());
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div class="container">
    <h1 class="text-center mt-4">Listado de Clientes</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">Nuevo Cliente</button>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // bucle para realizar recorrido sobre $rsCliente
        while ($fila = mysqli_fetch_array($rsCliente)) {
            ?>

            <tr>
                <td><?php echo $fila[0] ?></td>
                <td><?php echo $fila[1] ?></td>
                <td><?php echo $fila[2] ?></td>
                <td><?php echo $fila[3] ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-editar" 
                    data-bs-toggle="modal" data-bs-target="#modalCliente">Editar</button>
                    <button type="button" class="btn btn-danger btn-eliminar" data-id="<?php echo $fila[0] ?>">Eliminar</button>
                </td>
            </tr>

            <?php
        }
        ?>

        </tbody>
    </table>
</div>

<!-- Modal Nuevo Cliente -->
<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoClienteModalLabel">Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="cliente_id" name="cliente_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<script>
  //asignar evento click a todos los botones con nombre de clase "btn-editar"
  //para este caso usaremos JQUERY
  $(document).on("click",".btn-editar",function(){
    alert("hola");
  })
</script>
</body>
</html>

