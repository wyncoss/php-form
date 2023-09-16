<?php

// Conectando a la base de datos
$connect = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_DBNAME'],
);

// Query
$query = "SELECT * FROM contact ORDER BY id DESC LIMIT 1";

// Consultar la base de datos
$redb = mysqli_query($connect, $query);

?>

<!doctype html>
<html>
    <head>
        <title>Thank You</title>
    </head>
    <body>
    
        <h1>¡Gracias! :)</h1>
        <?php while ( $msgd = mysqli_fetch_assoc($redb)): ?>
        <p>Apreciado cliente, <b><?php echo $msgd['name']; ?></b> </p>
        <br>
        <p>Gracias por confiar en nosotros. Su solicitud ha sido recibida y se ha abierto un ticket con código # <b><?php echo $msgd['id']; ?></b> desde el departamento de <b><?php echo $msgd['department_name']; ?></b> y será atendido por <b><?php echo $msgd['employee_name']; ?></b>. ¡Feliz día! :) </p>
            <?php endwhile; ?>
    </body>
</html>

<?php
    mysqli_close($connect);
?>
