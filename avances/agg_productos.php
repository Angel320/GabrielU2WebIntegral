<!DOCTYPE html>
<html lang="es">
    <head>
       <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CompuShop</title>
        <!-- Favicon-->
        <link rel="icon" href="https://exploralat.am/images/shadowlight.png" />

      <!-- LIBRERIAS-->

      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/agg_producto.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


        <!-- Libreria estilos de la animación-->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <!-- Libreria para validar con JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
        <!-- Libreria de sweetalert 2-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- Libreria para Iconos-->
        <script src="https://kit.fontawesome.com/0727983454.js" crossorigin="anonymous"></script>
      <!-- LIBRERIAS-->

  <!-- Librerias de sweetalert 2-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/alertas.js"></script>


      <!-- ESTILOS-->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Estilo de contactos-->
        <link rel="stylesheet" href="css/contacto.css">
        <!-- ESTILO FORMU-->
        <link rel="stylesheet" href="css/estilos.css">


        <!-- Estilo componente y carrusel -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Estilo de HOME -->
      <link rel="stylesheet" href="css/home.css">
      <!-- Estilo Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- ESTILOS-->


      </head>

<!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="https://cdn-icons-png.flaticon.com/512/2039/2039006.png" width="60" height="60" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item active">
                                 <a class="nav-link" href="admin.php">Home</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>            
 <!-- header -->
 
 <body>
  <?php
# ob_start();
  // traemos el nav de la master_page
 # require_once 'master_page.php';
  // validamos si es admin si no lo sacamos por rata
#  if (isset($_SESSION['rol']) != "administrador") {
 #   header("Location:login.html");
 # }
  ?>
  <div class="container">
    <div class="add-product-container">
      <h2 class="text-center">Agregar Producto:</h2>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Nombre del producto:</label>
          <input type="text" class="form-control" id="name" name="nombre" placeholder="Ingrese el nombre del producto"
            required>
        </div>

        <div class="form-group">
          <label for="price">Precio del producto:</label>
          <input type="number" class="form-control" id="price" name="precio"
            placeholder="Ingrese el precio del producto" required>
        </div>
          </select>
        </div>
        <div class="form-group">
          <label for="image">Imagen del producto:</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="imagen_producto" name="imagen_producto" required>
            <label class="custom-file-label" for="imagen_producto">Seleccionar archivo</label>
          </div>
        </div>

        <button type="submit" name="subir_producto" class="btn btn-primary btn-block">Agregar Producto</button>
      </form>
    </div>
  </div>
</body>

</html>

<?php
require_once 'conexion.php';

if (isset($_POST['subir_producto'])) {
  // Obtener los valores de los campos del formulario
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $imagen_producto = $_FILES['imagen_producto'];

  // Ruta de la carpeta donde se guardarán las imágenes
  $directorio_imagenes = 'D:\xampp\htdocs\web_services\imgProductos\\';

  // Verificar si los campos no están vacíos
  if (!empty($nombre) && !empty($precio) && !empty($imagen_producto) && !empty($cantidad)) {
    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = $imagen_producto['name'];
    $extension_archivo = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

    // Generar un nombre único para el archivo combinando uniqid() y la extensión del archivo original
    $nombre_unico = uniqid() . '.' . $extension_archivo;

    // Ruta completa del archivo en la carpeta de imágenes
    $ruta_imagen = $directorio_imagenes . $nombre_unico;

    // Guardar el nombre único como código de imagen
    $codigo_imagen = $nombre_unico;

    // Mover el archivo a la carpeta de imágenes
    move_uploaded_file($imagen_producto['tmp_name'], $ruta_imagen);

    // Realizar las operaciones de registro en la base de datos
    $sql = $cnnPDO->prepare("INSERT INTO productos (nombre, precio,codigo_imagen) VALUES (:nombre, :precio,:codigo_imagen)");

    $sql->bindParam(':nombre', $nombre);
    $sql->bindParam(':precio', $precio);
    $sql->bindParam(':codigo_imagen', $codigo_imagen);

    $sql->execute();
    unset($sql);

    // Redireccionar a otra página después del registro exitoso
    header("location:agProducto.php?mensaje2=Se registró el producto exitosamente");

    exit();
  } else {
    echo "Por favor, completa todos los campos.";
  }
}
ob_end_flush();
?>