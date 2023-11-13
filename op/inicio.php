<?php 
//Obtiene las variables de sesión de config y defines las variables de sesion
include('config.php');
if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['id'])) {
             $_SESSION['user_id'] = $data['id'];
         }

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}


ob_start();
if (isset($_SESSION['correo']) && $_SESSION['correo'] != '' || isset($_SESSION['user_first_name']) && $_SESSION['user_first_name'] != '') {
    // Tu código aquí


 ?>



<?php
if (isset($_SESSION['user_first_name'])) {
    // Incluir el archivo de conexión a la base de datos
    require_once "BD/conexion-ajax.php";

    // Obtener datos de la sesión
    $correo = $_SESSION['user_email_address'];
    $psw = $_SESSION['user_id'];

    // Verificar si el correo ya está registrado
    $busqueda = "SELECT * FROM clientes WHERE correo=:correo";
    $stmt = $cnnPDO->prepare($busqueda);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $campo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si la consulta fue exitosa
    if ($stmt) {
        // Si el correo ya está registrado
        if ($stmt->rowCount() > 0) {
            // Ya no sigue porque ya está registrado
            // Puedes agregar aquí algún código adicional si es necesario
        } else {
            // Validar que las cajas no estén vacías
            if (!empty($correo) && !empty($psw)) {
                // Insertar datos en la tabla de la base de datos
                $sql = $cnnPDO->prepare("INSERT INTO clientes (correo, psw) VALUES (:correo, :psw)");

                // Asignar el contenido de las variables a los parámetros
                $sql->bindParam(':correo', $correo);
                $sql->bindParam(':psw', $psw);

                // Ejecutar la consulta
                $sql->execute();
            }
        }
    }
}
?>






<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>LATAM-erica</title>
        <!-- Favicon-->
        <link rel="icon" href="https://exploralat.am/images/shadowlight.png" />

      <!-- LIBRERIAS-->
        <!-- Libreria estilos de la animación-->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <!-- Libreria para validar con JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
        <!-- Libreria de sweetalert 2-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- Libreria para Iconos-->
        <script src="https://kit.fontawesome.com/0727983454.js" crossorigin="anonymous"></script>
      <!-- LIBRERIAS-->


      <!-- ESTILOS-->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- ESTILO FORMU-->
        <link rel="stylesheet" href="../css/estilos.css">


        <!-- Estilo componente y carrusel -->
      <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Estilo de HOME -->
      <link rel="stylesheet" href="../css/home.css">
      <!-- Estilo Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- ESTILOS-->

<style type="text/css">
   body{
       background-color: #c9d6ff;
       background: linear-gradient(to right, #e2e2e2, #c9d6ff);
   }

   .card-body{
      background-color: #fff;
    border-radius: 0px 0px 30px 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
   }

   .card-header{
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
   }


   .btn{ 
    position: absolute;
    right: 5%; /* Ajusta el porcentaje según tus necesidades */
    top: 5%;



    background-color: #008ACA;
    color: #fff;
    font-size: 12px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
     }
</style>
      </head>
   <body>

        <!-- Cargador  -->
      <div class="loader_bg">
         <div class="loader"><img src="../images/loading.gif" alt="#" /></div>
      </div>
      <!-- Cargador -->


     

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
                              <a href="api-google/logout.php"><img src="https://cdn-icons-png.flaticon.com/512/2039/2039006.png" width="60" height="60" alt="#" /></a>
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
                                 <a class="nav-link" href="#">Perfil</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="glasses.html">Productos</a>
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


  

      <!-- PRIMER CONTENEDOR-->
         <section class="py-5">
            <div data-aos="fade-up" class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                     <div class="card-header"> Bienvenido Usuario </div>
                     <div class="card-body">
                      <h1>Tu perfil</h1>
                      
                      
                     <?php 

                      if (isset($_SESSION['user_first_name'])) {
                        echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container" style="width: 130px; height: 100px;" alt="#"/>';
                        echo'
                        <p class="lead" > '. $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'] .'.</p>
                        <h2>Correo:</h2>
                        <p class="lead">'. $_SESSION['user_email_address'].' .</p>
                        <h2>ID:</h2>';
                        echo 'User ID: '. $_SESSION['user_id'].'
                        <h3><a class="btn" href="api-google/logout.php">Logout</a></h3>
                        ';

                                
                              } else {
                                 
                                  echo '<img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" class="rounded-circle container" style="width: 130px; height: 100px;" alt="#"/>';
                                  echo'
                        <h2>Correo:</h2>
                        <p class="lead" > '.$_SESSION['correo'].'.</p>
                        <h3><a class="btn" href="BD/salir.php">Logout</a></h3>
                        ';
                              }
                        
                     
                              /*// Accede a las variables de sesión
                              if (isset($_SESSION['user_first_name'])) {
                                  $user_first_name = $_SESSION['user_first_name'];
                                  // Puedes hacer lo que quieras con $user_first_name
                                  echo "Hola, $user_first_name";
                              } else {
                                  echo "Usuario no autenticado.";
                              }*/
                      ?>
                           
                        
                     </div>
                    </div>
                </div>
            </div>
        </section>
      <!-- PRIMER CONTENEDOR-->  



  <!-- PIE DE PAGINA-->
        <footer class="py-5 bg-dark">
            
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; CompuShop Website 2023</p></div>
            <div class="container"><p class="m-0 text-center text-white">Derechos reservados</p></div>
        </footer>
        <!-- PIE DE PAGINA-->


         <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Captcha-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <!-- Libreria script de las animaciones-->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <!-- Iniciador de las animaciones-->
        <script>
          AOS.init();
        </script>

        <!-- Script Cargador-->
        <script src="../js/jquery.min.js"></script>
        <script src="../js/custom.js"></script>
        <!-- Script Cargador-->

        <!-- Script Carrusel-->
        <script src="../js/bootstrap.bundle.min.js"></script>


  </body>
</html>


<?php  

}
else{
header("Location:Mensajes/error.php");
ob_end_flush();
}
?>