<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

// Crea la conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisa la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM autores_aux ORDER BY id_autores ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Autores</title>
	<link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
	<style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
        }

        td, th {
          border: 1px solid #dddddd;
          padding: 3px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;
        }
    </style>
</head>
<body>
	<h1 align="center">Tabla de Autores</h1>
    <nav>
        <a href="/PruebasBD/index.html">Inicio</a> |
        <a href="/PruebasBD/MuestraAutores.php">Autores</a> |
        <a href="/PruebasBD/MuestraLibros.php">Libros</a> |
    </nav>

	<table class="data-table" align="center">
		<caption class="title"><b>Autores</caption>
		<thead>
			<tr>
				<th>ID Autores</th>
				<th>Nombre</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($row = mysqli_fetch_array($query)) {
				echo '<tr>
						<td align="center">'.$row['id_autores'].'</td>
	                    <td><a href="DatosAutor.php?autor='.$row['id_autores'].'">'.
	                    utf8_encode($row['nombre']).' '.
	                    utf8_encode($row['apellido_paterno']).' '.
	                    utf8_encode($row['apellido_materno']).
	                    '</a></td>
					</tr>';
			}
		?>
		</tbody>
		
	</table>
</body>
</html>