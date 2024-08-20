<?php
// Incluir la página cls_Conectar.php
include("cls_conectar/cls_Conectar.php");

// Crear objeto de la clase Conexion
$bean = new Conexion();

// Sentencia SQL
$sql = "SELECT * FROM DetallePedido";

// Ejecutar la consulta SQL y guardar el resultado en una variable
$rsDetallePedido = mysqli_query($bean->getConexion(), $sql);

// Manejar el envío del formulario para agregar un nuevo detalle de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados del formulario
    $detalle_pedido_id = $_POST['detalle_pedido_id'];
    $pedido_id = $_POST['pedido_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $precio_unitario = $_POST['precio_unitario'];

    // Consulta SQL de inserción
    $sql = "INSERT INTO DetallePedido (detalle_pedido_id, pedido_id, producto_id, cantidad, precio_unitario) VALUES ('$detalle_pedido_id', '$pedido_id', '$producto_id', '$cantidad', '$precio_unitario')";

    // Ejecutar la consulta de inserción
    if (mysqli_query($bean->getConexion(), $sql)) {
        // Redirigir a la página actual para evitar el envío duplicado del formulario
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        // Manejar el error en caso de que la inserción falle
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
    <h1 class="text-center mt-4">Listado de Detalles de Pedido</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoDetallePedidoModal">Nuevo Detalle de Pedido</button>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Pedido ID</th>
            <th>Producto ID</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Bucle para recorrer $rsDetallePedido
        while ($fila = mysqli_fetch_array($rsDetallePedido)) {
            ?>
            <tr>
                <td><?php echo $fila['detalle_pedido_id'] ?></td>
                <td><?php echo $fila['pedido_id'] ?></td>
                <td><?php echo $fila['producto_id'] ?></td>
                <td><?php echo $fila['cantidad'] ?></td>
                <td><?php echo $fila['precio_unitario'] ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-editar" 
                    data-bs-toggle="modal" data-bs-target="#modalDetallePedido">Editar</button>
                    <button type="button" class="btn btn-danger btn-eliminar" data-id="<?php echo $fila['detalle_pedido_id'] ?>">Eliminar</button>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Nuevo Detalle de Pedido -->
<div class="modal fade" id="nuevoDetallePedidoModal" tabindex="-1" aria-labelledby="nuevoDetallePedidoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoDetallePedidoModalLabel">Detalle de Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="detalle_pedido_id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="detalle_pedido_id" name="detalle_pedido_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="pedido_id" class="form-label">Pedido ID</label>
                        <input type="text" class="form-control" id="pedido_id" name="pedido_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Producto ID</label>
                        <input type="text" class="form-control" id="producto_id" name="producto_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_unitario" class="form-label">Precio Unitario</label>
                        <input type="text" class="form-control" id="precio_unitario" name="precio_unitario" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
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
