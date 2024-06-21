<?php
session_start();

$error_message = ""; // Inicializa la variable de mensaje de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $servername = "localhost";
    $username = "root"; 
    $password = "mysql114114"; 
    $dbname = "prueeba"; 

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM registrados WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if (password_verify($contraseña, $usuario['contraseña'])) {
                $_SESSION['user_id'] = $usuario['id'];
                header("Location: inicio-secion.php"); 
                exit();
            } else {
                // Define el mensaje de error si la contraseña es incorrecta
                $error_message = "Contraseña incorrecta.";
            }
        } else {
            $error_message = "Usuario no encontrado.";
        }
    } catch(PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
    $_SESSION['error_message'] = $error_message; // Guarda el mensaje de error en la sesión
    header("Location: inicio-secion.php"); // Redirige de vuelta al formulario de inicio de sesión
    exit();
}
?>
