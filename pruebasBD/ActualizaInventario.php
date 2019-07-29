<?php
// ************************************************************************************************
//  Maneja la modificación de inventario, la idea es bastante similar a Ventas.php
//  Hace una búsqueda para después elegir los libros a modificar el número de ejemplares que se
//  se tienen declarados, (aún por escribir) se crea un registro de las modificaciones y se actualiza
//  la cantidad en la base (tabla de inventario)
// ************************************************************************************************

// Crea la conexión a la db
require_once("db_connect.php");

// IMPORTANTE, hace funcionar los acentos en las querys
$acentos = $conn->query("SET NAMES 'utf8'");

// Espera a que se haga la búsqueda para realizar la consulta
if($_GET) {
    $busqueda = $_GET["q"];

    $busqueda = trim($busqueda);
    $busqueda = stripslashes($busqueda);
    $busqueda = htmlspecialchars($busqueda);

    $sql = "SELECT libros_aux.id_libros, titulo, ejemplares FROM inventario_aux
            JOIN libros_aux
            ON inventario_aux.id_libros = libros_aux.id_libros
            WHERE titulo LIKE '%$busqueda%' ORDER BY titulo ASC";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Actualiza Inventario</title>
    <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    <link rel="stylesheet" type="text/css" href="css/menu2.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/grid.css">
    <meta name="viewport" content="initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            padding: 3px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .boton {
            border: none;
            color: white;
            padding: 4px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 13px 2px;
            cursor: pointer;
            opacity: 1;
        }
        .button1 {
            opacity: 1;
            color: #456; 
            border: 1px solid #456;
        }
        .button1:hover {
            background-color: #456;
            color: white;
        }
        p.busqueda {
            padding-left: 5%;
        }
        input[type=text] {
            padding: 6px 4px;
            width: 77%;
            margin: 2px 0;
            box-sizing: border-box;
            border: none;
            background:rgba(0,0,0,0.1);
        }
        li a, .dropbtn {
          display: inline-block;
          text-align: center;
          text-decoration: none;
        }
        li a:hover, .dropdown:hover .dropbtn {
          background-color: none;
        }
        li.dropdown {
          display: inline-block;
        }
        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #678;
          min-width: 150px;
        }
        .dropdown-content a {
          text-decoration: none;
          display: block;
          text-align: left;
          padding-left: 4px;
        }
        .dropdown:hover .dropdown-content {
          display: block;
        }
    </style>
</head>

<body>
    <div id="contenedor">

        <div id="encabezado">
            <div id="logoizq" onclick="window.open('http://www.unam.mx');" style="cursor:pointer;">
            </div>
            <div id="logomid">
            </div>
            <div id="logoder" onclick="window.open('http://www.matem.unam.mx');" style="cursor:pointer;">
            </div>
        </div>

        <div id="menuencabezado"></div>
        <script>
            $(function(){
                $("#menuencabezado").load("menu_encabezado.html");
            });
        </script>

        <div id="contenido">

            <h1 align="center">Actualiza Inventario</h1>

            <form action="ActualizaInventario.php" method="GET">
                <fieldset>
                    <p class="busqueda">            
                        Buscar libro:<input type="text" name="q" placeholder="Título, Autor">
                        <input type="submit" class="boton button1" value="Buscar">
                    </p>
                </fieldset>
            </form>

            <?php
            if($_GET) {
                echo '
                <br>
                <form method="post">
                    <table>
                        <caption class="title"><b>Resultados de '.$busqueda.'</caption>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Ejemplares</th>
                            </tr>
                        </thead>
                        <tbody>';

                        while ($row = mysqli_fetch_array($query)) {
                            echo '<tr>
                                    <td><input class="input enable" type="checkbox" name="busq[]" value="'.$row['id_libros'].'">'.$row['titulo'].'</td>
                                    <td align="center"><input type="number" name="cantidad[]" value="'.$row['ejemplares'].'" min="0" disabled></td>
                                </tr>';
                        }

                        echo '
                        </tbody>    
                    </table>
                    <input class="boton button1" type="submit" value="Actualizar">
                </form>';

            }

            ?>
            <!-- https://stackoverflow.com/questions/29596147/relate-a-checkbox-with-another-input -->
            <script type="text/javascript">
                $('.enable').change(function(){
                    var set =  $(this).is(':checked') ? false : true;
                    $(this).closest('td').siblings().find('input').attr('disabled',set);  
                });
            </script>

            <?php
            if($_POST) {
                $venta = $_POST['busq'];
                $cant = $_POST['cantidad'];
                for($i = 0; $i < count($venta); $i++) { 
                    $sql_venta  = "UPDATE inventario_aux
                    SET ejemplares = '$cant[$i]'
                    WHERE id_libros = '$venta[$i]'";

                    $query2 = mysqli_query($conn, $sql_venta);

                    if (!$query2) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    } else {
                        echo "Cambio exitoso!<br>";
                    }
                }
            }

            ?>

        </div>
    </div>
    
</body>
</html>