<?php
	/* Definir las variables para la conexion al PDO */
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'ecomerce');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');

	try {
		/* Conectar a una base de datos de MySQL Local */
		$cnnPDO = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
	} catch (PDOException $e) {

		echo "<div style='width:35%;margin:0 auto; margin-top:50px;'>
			<h2>Ha surgido un error y no se puede conectar a la base de datos!
				<br><br>Verifique el nombre de su 
				<br>| base de datos |<br> </h2>
			 </div>	";
	}

	?>