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
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
// $empleado_escogido_randonomicamente = isset( $_POST['empleado_escogido_randonomicamente'] ) ? $_POST['empleado_escogido_randonomicamente'] : '';

$email_error = '';
$message_error = '';
$nombre_error = '';

// Verificar errores
if (count($_POST)) {
    $errors = 0;

    if ($_POST['nombre'] == '') {
        $nombre_error = 'Please enter a valid name';
        $errors++;
    }

    if ($_POST['email'] == '') {
        $email_error = 'Please enter an email address';
        $errors++;
    }

    if ($_POST['message'] == '') {
        $message_error = 'Please enter a message';
        $errors++;
    }

    if ($errors == 0) {
        // Enviar a la base de datos
        $query = 'INSERT INTO contact (
                name,
                email,
                message,
                department_name,
                employee_name
            ) VALUES (
                "' . addslashes($_POST['nombre']) . '",
                "' . addslashes($_POST['email']) . '",
                "' . addslashes($_POST['message']) . '",
                "' . addslashes($_POST['departamento']) . '",
                "' . ($empleado_escogido_randonomicamente) . '"
            )';
        mysqli_query($connect, $query);

        $message = 'You have received a contact form submission:
            
Nombre: ' . $_POST['nombre'] . '
Email: ' . $_POST['email'] . '
Message: ' . $_POST['email'] . '
Departamento: ' . $_POST['departamento'];
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
    <link href="./style.css" rel="stylesheet">
    <title>PHP Contact Form</title>
</head>

<body>


    <div class="bg-sky-200 grid h-screen place-items-center">
        <div class="mx-auto max-w-[550px]">
            <h1 class="flex items-center justify-center p-12 font-bold">PHP Contact Form</h1>
            <form method="post" action="">
                <div class="mb-3">
                    Name:
                    <br>
                    <input class="w-full resize-none border border-gray-300 bg-white py-1 text-base font-normal transition-all duration-500 rounded-md focus:outline-none sm:focus:shadow-outline focus:border-none" type="text" name="nombre" value="<?php echo $nombre; ?>">
                    <?php echo $nombre_error; ?>
                </div>
                <br><br>
                <div class="mb-3">
                    Email Address:
                    <br>
                    <input class="w-full resize-none border border-gray-300 bg-white py-1 text-base font-normal transition-all duration-500 rounded-md focus:outline-none sm:focus:shadow-outline focus:border-none" type="text" name="email" value="<?php echo $email; ?>">
                    <?php echo $email_error; ?>
                </div>
                <br><br>
                <div class="mb-3">
                    Message:
                    <br>
                    <textarea class="w-full resize-none border border-gray-300 bg-white py-1 text-base font-normal transition-all duration-500 rounded-md focus:outline-none sm:focus:shadow-outline focus:border-none" name="message"><?php echo $message; ?></textarea>
                    <?php echo $message_error; ?>
                </div>
                <br><br>
                <div class="mb-3">
                    <label for="lang">Departamento:</label>
                    <select name="departamento" id="dep">
                        <option value="atencioncliente">Atención al Cliente</option>
                        <option value="soportetecnico">Soporte Técnico</option>
                        <option value="facturacion">Facturación</option>
                    </select>
                </div>

                <br><br>
                <div class="flex items-center justify-center">
                    <input class=" text-sky-400 cursor-pointer hover:bg-sky-900 focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1da1f2]/55 mr-2 mb-2 hover:shadow-lg transition-all duration-200 ease-in-out hover:scale-110 scale-90 gap-x-2 opacity-90 hover:opacity-100" type="submit" value="Continuar">
                </div>
            </form>
        </div>
    </div>
</body>

</html>