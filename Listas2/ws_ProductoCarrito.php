<?php
// incluir en la página actual la página cls_Conectar.php
include("cls_conectar/cls_Conectar.php");

// crear objeto de la clase Conexion
$bean = new Conexion();

// sentencia SQL
$sql = "SELECT * FROM ProductoCarrito";

// ejecutar sentencia SQL y guardar su valor de retorno en una variable
$rsProductoCarrito = mysqli_query($bean->getConexion(), $sql);

// Manejar el envío del formulario para agregar un nuevo producto en el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores enviados del formulario
    $producto_carrito_id = $_POST['producto_carrito_id'];
    $producto_id = $_POST['producto_id'];
    $carrito_id = $_POST['carrito_id'];
    $cantidad = $_POST['cantidad'];

    // Consulta SQL de inserción
    $sql = "INSERT INTO ProductoCarrito (producto_carrito_id, producto_id, carrito_id, cantidad) VALUES ('$producto_carrito_id', '$producto_id', '$carrito_id', '$cantidad')";

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
    <h1 class="text-center mt-4">Listado de Productos en el Carrito</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoCarritoModal">Nuevo Producto en Carrito</button>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>Producto Carrito ID</th>
            <th>Producto ID</th>
            <th>Carrito ID</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // bucle para realizar recorrido sobre $rsProductoCarrito
        while ($fila = mysqli_fetch_array($rsProductoCarrito)) {
            ?>

            <tr>
                <td><?php echo $fila['producto_carrito_id'] ?></td>
                <td><?php echo $fila['producto_id'] ?></td>
                <td><?php echo $fila['carrito_id'] ?></td>
                <td><?php echo $fila['cantidad'] ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-editar" 
                    data-bs-toggle="modal" data-bs-target="#modalProductoCarrito">Editar</button>
                    <button type="button" class="btn btn-danger btn-eliminar" data-id="<?php echo $fila['producto_carrito_id'] ?>">Eliminar</button>
                </td>
            </tr>

            <?php
        }
        ?>

        </tbody>
    </table>
</div>

<!-- Modal Nuevo Producto en Carrito -->
<div class="modal fade" id="nuevoProductoCarritoModal" tabindex="-1" aria-labelledby="nuevoProductoCarritoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoProductoCarritoModalLabel">Producto en Carrito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="mb-3">
                        <label for="producto_carrito_id" class="form-label">Producto Carrito ID</label>
                        <input type="text" class="form-control" id="producto_carrito_id" name="producto_carrito_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="producto_id" class="form-label">Producto ID</label>
                        <input type="text" class="form-control" id="producto_id" name="producto_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="carrito_id" class="form-label">Carrito ID</label>
                        <input type="text" class="form-control" id="carrito_id" name="carrito_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" required>
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
