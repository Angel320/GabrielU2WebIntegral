<?php

require_once "conexion-ajax.php";

// Trae datos del formulario
// Verifica si la clave "correolog" está definida en $_POST
$correo = isset($_POST['correolog']) ? $_POST['correolog'] : '';

// Verifica si la clave "pswlog" está definida en $_POST
$psw = isset($_POST['pswlog']) ? $_POST['pswlog'] : '';


//$correo = 'angel@gmail.co'; 
//$psw = '1234';

$usuario = "master";
$contra = "12345";

// Buscar si ya existe ese correo
$busqueda = "SELECT * FROM clientes WHERE correo='$correo' && psw='$psw'";
$stmt = $cnnPDO->prepare($busqueda);
$stmt->execute();
$campo = $stmt->fetch(PDO::FETCH_ASSOC);


// Verificar si es el usuario admin
if ($correo == $usuario && $psw == $contra) {
    session_start();
    $_SESSION['correo'] = $correo;
    echo 1;
} elseif ($campo && is_array($campo) && $correo == $campo['correo'] && $psw == $campo['psw']) {
    session_start();
    $_SESSION['correo'] = $correo;
    echo 2;
  //  echo $correo.' '.$campo['correo'];
   // echo $campo['psw'];

   
} else {
    echo 3;
    var_dump($correo, $psw);

   // echo ' el correo es '$correo;
    //echo ' la contra es '$psw;
}





/*
  //Buscar si ya existe ese correo
  $busqueda = "SELECT * FROM social WHERE correo='$correo'";
  $stmt = $cnnPDO->prepare($busqueda);
  $stmt->execute();
  $campo = $stmt->fetch(PDO::FETCH_ASSOC);

  //Condicional para correo repetido
      if ($correo == $campo['correo']) {
        echo 2;   //R toma cualquier valor final que quede en este documento, incluido los errores, para entenderlo mejor, vizualisa esto en una pagina, y todo lo que aparesca en la pag sera el valor que obtendra r   
      }   
          else{
            echo 1;
            
                    //Validar que las cajas no esten vacias
                    if (!empty($correo) && !empty($psw) && !empty($pais))
                    {
                      //Insertar datos en la tabla de la db  
                      $sql=$cnnPDO->prepare("INSERT INTO social
                        (correo, psw, pais) VALUES (:correo, :psw, :pais)");

                      //Asignar el contenido de las variables a los parametros
                      $sql->bindParam(':correo',$correo);   
                      $sql->bindParam(':psw',$psw);  
                      $sql->bindParam(':pais',$pais);    
                     
                      //Ejecutar la variable $sql
                      $sql->execute();
                    }
                    echo $cnnPDO->prepare($sql);  
          }


*/


?>