<?php
//Parametros para la api de inicio de sesión
//Include Configuration File
include('config.php');

$login_button = '';

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

//Ancla para iniciar sesión
if (!isset($_SESSION['access_token'])) {
$login_button = '<a class="icon" href="' . $google_client->createAuthUrl() . '"><i class="fa-brands fa-google-plus-g"></i></a>';
                                        }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="recursos-formu/estilo-formu.css">
    <!-- Libreria para validar con JQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"> </script>
        <!-- Libreria de sweetalert 2-->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- ESTILO FORMU-->
        <link rel="stylesheet" href="recursos-formu/estilo-validacion.css">
    <title>Unete a la tienda</title>

    <style type="text/css">
        

    </style>
</head>

<body>

    <div class="container" id="container">
        
        <div class="form-container sign-up">
            <form  name="form-ajax" id="form-ajax" method="post" action="#">
                <h1>Registrarse</h1>
                <span>para acceder a la tienda</span>
                 <!-- Grupo: Correo Electronico -->
                    <div class="formulario__grupo" id="grupo__correo">
                       <!-- <label for="correo" class="formulario__label">Correo Electrónico</label>-->
                        <div class="formulario__grupo-input">
                            <input type="email" class="formulario__input" name="correo" id="correo" placeholder="correo@correo.com">
                            <i class="formulario__validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="formulario__input-error" ></p>
                    </div>
                <!-- Grupo: Contraseña -->
                    <div class="formulario__grupo" id="grupo__psw">
                        <div class="formulario__grupo-input" >
                            <input type="password" class="formulario__input" name="psw" id="psw">
                            <i class="formulario__validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="formulario__input-error"></p>
                    </div>
                    <!-- Grupo: Confirmar -->
                    <div class="formulario__grupo" id="grupo__confirmar">
                        <div class="formulario__grupo-input">
                            <input type="password" class="formulario__input" name="confirmar" id="confirmar">
                            <i class="formulario__validacion-estado fas fa-times-circle"></i>
                        </div>
                        <p class="formulario__input-error"></p>
                    </div>
                <!-- Captcha -->
                    <div class="mb-3">
                        <div  class="g-recaptcha" data-sitekey="6LfMy1ceAAAAAIIsLiFMwkhYxX324aXV3hPSKoq3"></div>
                    </div>
                <button type="button" class="btn-desactivada"  id="registrarse" disabled="">Crear cuenta</button>
            </form>
        </div>




        
        <div class="form-container sign-in">
            <form id="form-login">
                <h1>Inicia sesión con</h1>
                <div class="social-icons">
                    <?php
                    //Ancla para iniciar sesión
                            echo $login_button;
                      ?>
                </div>
                <span>o usa tu contraseña y correo para continuar</span>
                <input type="email" placeholder="correo" name="correolog" id="correolog">
                <input type="password" placeholder="Contraseña" name="pswlog" id="pswlog">
                <a href="../">Volver</a>
                <button id="entrar" class="btn">Iniciar</button>
            </form>
        </div>
        <!-- Paneles -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenido de vuelta!</h1>
                    <p>Inicia sesión para poder acceder a todos tus beneficios</p>
                    <button class="hidden btn" id="login">Iniciar sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hola Amigo!</h1>
                    <p>Registrate para poder hacer uso de todo lo que ofrece nuestro sitio</p>
                    <button class="hidden btn" id="register">Registrarse</button>
                </div>
            </div>
        </div>
        <!-- Paneles -->


    </div>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="recursos-formu/script-formu.js"></script>
<!-- Captcha-->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Formulario-->
<script src="recursos-formu/formulario.js"></script>


</body>
</html>













<!--VALIDAR CAPTCHA-->
<script type="text/javascript">
   // Validar apretando un boton con el id validar
   /* $(document).on('click', '#validar', function()
    {
        var response = grecaptcha.getResponse();
        alert(response);

        if (response != "") {
              alert("captcha Valido");
        }   else{
              alert("Comprueba el captcha");
            }
        }) */

      function ValidarCap()
    {
        var response = grecaptcha.getResponse();
        alert(response);

        if (response != "") {
              alert("captcha Valido");
        }   else{
              alert("Comprueba el captcha");
            }
    }
 //document.getElementById('correo').addEventListener('keyup', ValidarCap);
</script>
<!--VALIDAR CAPTCHA-->










<!--Deshabilitar y habilitar-->
<script type="text/javascript">

  
// Cambiar clases en lugar de deshabilitar el botón

function activar() {
    var correo = document.getElementById('correo').value;
    var psw = document.getElementById('psw').value;
    var confirmar = document.getElementById('confirmar').value;

    console.log('Valor de correo: ', correo);
    console.log('Valor de psw: ', psw);
    console.log('Valor de confirmar: ', confirmar);

    var registrarseBtn = document.getElementById('registrarse');
    
    if (correo !== "" && psw !== "" && confirmar !== "") {
                console.log("Agregando clases...");
        // Agregar clase de activación y quitar clase de desactivación
        document.getElementById('registrarse').disabled=false
        registrarseBtn.classList.add('btn-activada'); // Reemplaza 'clase-activada' con tu clase real para el estado activado
        registrarseBtn.classList.remove('btn-desactivada'); // Reemplaza 'clase-desactivada' con tu clase real para el estado desactivado
    } else {
                console.log("Quitando clases...");

        document.getElementById('registrarse').disabled=true
        // Agregar clase de desactivación y quitar clase de activación
        registrarseBtn.classList.add('btn-desactivada'); // Reemplaza 'clase-desactivada' con tu clase real para el estado desactivado
        registrarseBtn.classList.remove('btn-activada'); // Reemplaza 'clase-activada' con tu clase real para el estado activado
    }
}

// EVENTOS
document.getElementById('correo').addEventListener('keyup', activar);
document.getElementById('psw').addEventListener('keyup', activar);
document.getElementById('confirmar').addEventListener('keyup', activar);

</script>
<!--Deshabilitar y habilitar-->















<!-- ALERTAS DEL REGISTRO-->
<script type="text/javascript">
$(document).ready(function() {
    let emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    let passwordReg = /^.{4,12}$/;

        var datos = $('#form-ajax').serialize();

    $("#registrarse").click(function() {
    var datos = $('#form-ajax').serialize();
    


        //ESTRUCTURA DE ALERTA DEL CORREO
        if (!emailreg.test($("#correo").val())) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                //  Aqui pones el mensaje donde diga tittle
                title: 'Ingrese un correo Valido: correo@ejemplo.com'
            })
            return false;
        } 
        //ESTRUCTURA DE ALERTA DEL EMAIL


        //ESTRUCTURA DE ALERTA DE LA CONTRASEÑA
            else if ($("#psw").val() == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: 'Contraseña incompleta, llena este campo'
            })
            return false;
        }



        if (!passwordReg.test($("#psw").val())) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            Toast.fire({
                icon: 'error',
                title: 'La contraseña debe tener entre 4 y 12 caracteres'
            });
            return false;
        }




        //CONFIRMAR CONTRASEÑAS 

                if ($("#confirmar").val() != $("#psw").val()) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                //  Aqui pones el mensaje donde diga tittle
                title: 'Las contraseñas no coinciden'
            })
            return false;
        }



//ESTRUCTURA DE ALERTA DEL CAPTCHA
    //Variable que valida captcha
    
    var response = grecaptcha.getResponse();
        if (response == "")  {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                //  Aqui pones el mensaje donde diga tittle
                title: 'Compruebe el captcha'
            })
            return false;
        } 
        //ESTRUCTURA DE ALERTA DEL CAPTCHA

         

        //ESTRUCTURA DEL AJAX
                else  {
                $.ajax({
                    type:"POST",
                    url:"BD/save.php",
                    data:datos,
                    success:function(r){
                         //R estaba tomando el mensaje de error
                        if (r!=2) {
                            //alert(r)

                            //ALERTA DE EXITO, TIENE QUE HABER UNA PARA QUE TE LIMPIE EL FORMULARIO
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Registrado correctamente'
                                })

                                                $('#correo').val('');
                                                $('#psw').val('');
                                                $('#confirmar').val('');
                           
                        }//CIERRE IF R DIFERENTE DE 2
                                            else {
                                                //Muestra el valor con alert(r)
                                                const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                                 })
                                                Toast.fire({
                                                    icon: 'error',
                                                    //  Aqui pones el mensaje donde diga tittle
                                                    title: 'El correo ya existe, intenta con otro'
                                                })
                                                //El swal detiene cualquier accion que haya por debajo de el
                                                            swal ("¡Se Generó un Error Al Intentar Registrar!");

                                            }
                    }//CIERRE FUNCION R
                });//CIERRE DEL ELSE DEL AJAX
                return false;
                }//CIERRE ELSE
                

    });

});
</script>
<!-- ALERTAS DEL REGISTRO-->













<!-- ALERTAS DEL Inicio-->
<script type="text/javascript">
$(document).ready(function() {
    let emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var datos = $('#form-login').serialize();

    $("#entrar").click(function() {
    var datos = $('#form-login').serialize();
    


        //ESTRUCTURA DE ALERTA DEL CORREO
        if ($("#correolog").val() == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                //  Aqui pones el mensaje donde diga tittle
                title: 'Escriba un correo, llene el campo'
            })
            return false;
        } 
        //ESTRUCTURA DE ALERTA DEL EMAIL


        //ESTRUCTURA DE ALERTA DE LA CONTRASEÑA
            else if ($("#pswlog").val() == "") {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'error',
                title: 'Escriba la contraseña, llene el campo'
            })
            return false;
        }

         

        //ESTRUCTURA DEL AJAX
                else  {
                $.ajax({
                    type:"POST",
                    url:"BD/iniciar.php",
                    data:datos,
                    success:function(r){
                         //R estaba tomando el mensaje de error
                         //alert(r)
                        if (r==1) {
                           // alert(r)

                            //ALERTA DE EXITO, TIENE QUE HABER UNA PARA QUE TE LIMPIE EL FORMULARIO
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        //toast.addEventListener('mouseenter', Swal.stopTimer)
                                        //toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Bienvenido usuario moderador'
                                })

                                                //$('#correo').val('');
                                                //$('#psw').val('');
                                                //$('#confirmar').val('');
                                                //$('#pais').val('');



                                                 setTimeout( function() { window.location.href = "#"; }, 5000 );
                        
                        }//CIERRE IF R DIFERENTE DE 2
                        else if (r==2) {
                            //alert(r)

                            //ALERTA DE EXITO, TIENE QUE HABER UNA PARA QUE TE LIMPIE EL FORMULARIO
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        //toast.addEventListener('mouseenter', Swal.stopTimer)
                                        //toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Bienvenido usuario'
                                })

                                                //$('#correo').val('');
                                                //$('#psw').val('');
                                                //$('#confirmar').val('');
                                                //$('#pais').val('');



                                                 setTimeout( function() { window.location.href = "inicio.php"; }, 5000 );






                           
                        }//CIERRE IF R DIFERENTE DE 2
                                            else {
                                                //Muestra el valor con 
                                                //alert(r)
                                                const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 5000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                                 })
                                                Toast.fire({
                                                    icon: 'error',
                                                    //  Aqui pones el mensaje donde diga tittle
                                                    title: 'El correo o la contraseña no son validos'
                                                })
                                                //El swal detiene cualquier accion que haya por debajo de el
                                                            swal ("¡Se Generó un Error Al Intentar Registrar!");

                                            }
                    }//CIERRE FUNCION R
                });//CIERRE DEL ELSE DEL AJAX
                return false;
                }//CIERRE ELSE
                

    });

});
</script>
<!-- ALERTAS DEL Inicio-->