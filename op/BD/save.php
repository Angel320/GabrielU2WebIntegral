<?php
require_once "conexion-ajax.php";
//Trae datos del formulario
$correo=$_POST['correo']; 
$psw=$_POST['psw'];



  //Buscar si ya existe ese correo
  $busqueda = "SELECT * FROM clientes WHERE correo='$correo'";
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
                    if (!empty($correo) && !empty($psw))
                    {
                      //Insertar datos en la tabla de la db  
                      $sql=$cnnPDO->prepare("INSERT INTO clientes
                        (correo, psw) VALUES (:correo, :psw)");

                      //Asignar el contenido de las variables a los parametros
                      $sql->bindParam(':correo',$correo);   
                      $sql->bindParam(':psw',$psw);  
                     
                      //Ejecutar la variable $sql
                      $sql->execute();
                    }
                    echo $cnnPDO->prepare($sql);  
          }





?>