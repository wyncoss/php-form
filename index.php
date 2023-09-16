<?php

require __DIR__ . '/./vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeload();

// Conectar con la base de datos (Método local)
// $connect = mysqli_connect('localhost', 'usb', 'usb2022', 'formulatio');

// Conectar con la base de datos (Usar el .env para la conexión)
$connect = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_DBNAME'],
);

$connect->set_charset('utf8');

// Seleccionar empleado al azar
$empleados_soporte = array("Jaime Rubiano", "Maria Garcia", "Pedro Sanchez", "Arley Ramirez");
$empleado_escogido_randonomicamente = $empleados_soporte[array_rand($empleados_soporte, 1)];

// Obtener datos mediante POST
$nombre = isset( $_POST['nombre'] ) ? $_POST['nombre'] : '';
$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
$departamento = isset( $_POST['departamento'] ) ? $_POST['departamento'] : '';
// $empleado_escogido_randonomicamente = isset( $_POST['empleado_escogido_randonomicamente'] ) ? $_POST['empleado_escogido_randonomicamente'] : '';

$email_error = '';
$message_error = '';
$nombre_error = '';

// Verificar errores
if (count($_POST))
{ 
    $errors = 0;

    if ($_POST['nombre'] == '')
    {
        $nombre_error = 'Please enter a valid name';
        $errors ++;
    }

    if ($_POST['email'] == '')
    {
        $email_error = 'Please enter an email address';
        $errors ++;
    }

    if ($_POST['message'] == '')
    {
        $message_error = 'Please enter a message';
        $errors ++;
    }

    if ($errors == 0)
    {
        // Enviar a la base de datos
        $query = 'INSERT INTO contact (
                name,
                email,
                message,
                department_name,
                employee_name
            ) VALUES (
                "'.addslashes($_POST['nombre']).'",
                "'.addslashes($_POST['email']).'",
                "'.addslashes($_POST['message']).'",
                "'.addslashes($_POST['departamento']).'",
                "'.($empleado_escogido_randonomicamente).'"
            )';
        mysqli_query($connect, $query);

        $message = 'You have received a contact form submission:
            
Nombre: '.$_POST['nombre'].'
Email: '.$_POST['email'].'
Message: '.$_POST['email'].'
Departamento: '.$_POST['departamento'];
// Empleado: '.$_POST['empleado_escogido_randonomicamente'];

        // mail( 'poveda.geovanny@hotmail.com', 
        //     'Contact Form Cubmission',
        //     $message );

        header('Location: thankyou.php');
        die();

    }
}

?>
<!doctype html>
<html>
    <head>
        <title>PHP Contact Form</title>
    </head>
    <body>
    
        <h1>PHP Contact Form</h1>

        <form method="post" action="">

            Name:
            <br>
            <input type="text" name="nombre" value="<?php echo $nombre; ?>">
            <?php echo $nombre_error; ?>

            <br><br>
        
            Email Address:
            <br>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php echo $email_error; ?>

            <br><br>

            Message:
            <br>
            <textarea name="message"><?php echo $message; ?></textarea>
            <?php echo $message_error; ?>

            <br><br>

            <label for="lang">Departamento</label>
            <select name="departamento" id="dep">
            <option value="atencioncliente">Atención al Cliente</option>
            <option value="soportetecnico">Soporte Técnico</option>
            <option value="facturacion">Facturación</option></select>
            </select>

            <br><br>

            <input type="submit" value="Submit">
        
        </form>
    
    </body>
</html>
