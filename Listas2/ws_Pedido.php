<?php
// incluir en la página actual la página cls_Conectar.php
include("cls_conectar/cls_Conectar.php");

// crear objeto de la clase Conexion
$bean = new Conexion();

// sentencia SQL
$sql = "SELECT * FROM Pedido";

// ejecutar sentencia SQL y guardar su valor de retorno en una variable
$rsPedido = mysqli_query($bean->getConexion(), $sql);

// Manejar el envío del formulario para agregar un nuevo pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados del formulario
    $pedido_id = $_POST['pedido_id'];
    $cliente_id = $_POST['cliente_id'];
    $fecha = $_POST['fecha'];
    $delivery_id = $_POST['delivery_id'];

    // Consulta SQL de inserción
    $sql = "INSERT INTO Pedido (pedido_id, cliente_id, fecha, delivery_id) VALUES ('$pedido_id', '$cliente_id', '$fecha', '$delivery_id')";

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
    <h1 class="text-center mt-4">Listado de Pedidos</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoPedidoModal">Nuevo Pedido</button>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Cliente ID</th>
            <th>Fecha</th>
            <th>Delivery ID</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // bucle para realizar recorrido sobre $rsPedido
        while ($fila = mysqli_fetch_array($rsPedido)) {
            ?>

            <tr>
                <td><?php echo $fila['pedido_id'] ?></td>
                <td><?php echo $fila['cliente_id'] ?></td>
                <td><?php echo $fila['fecha'] ?></td>
                <td><?php echo $fila['delivery_id'] ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-editar" 
                    data-bs-toggle="modal" data-bs-target="#modalPedido">Editar</button>
                    <button type="button" class="btn btn-danger btn-eliminar" data-id="<?php echo $fila['pedido_id'] ?>">Eliminar</button>
                </td>
            </tr>

            <?php
        }
        ?>

        </tbody>
    </table>
</div>

<!-- Modal Nuevo Pedido -->
<div class="modal fade" id="nuevoPedidoModal" tabindex="-1" aria-labelledby="nuevoPedidoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoPedidoModalLabel">Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="pedido_id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="pedido_id" name="pedido_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente ID</label>
                        <input type="text" class="form-control" id="cliente_id" name="cliente_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="delivery_id" class="form-label">Delivery ID</label>
                        <input type="text" class="form-control" id="delivery_id" name="delivery_id" required>
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
