<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Verificar si el correo electrónico ya está en uso
    $servername = "localhost";
    $username = "root"; 
    $password = "mysql114114"; 
    $dbname = "prueeba"; 

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT correo FROM registrados WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensaje = "El correo electrónico ya está en uso.";
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }

    // Verificar si las contraseñas coinciden
    if ($contraseña !== $confirmar_contraseña) {
        $mensaje = "Las contraseñas no coinciden.";
    }

    // Hashear la contraseña
    $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario
    if (!isset($mensaje)) {
        try {
            $stmt = $conn->prepare("INSERT INTO registrados (nombre, apellido, correo, contraseña) VALUES (:nombre, :apellido, :correo, :contrasena)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contraseña_hashed); 
            $stmt->execute();

            echo "¡Cuenta creada correctamente!";
            header("Location:dashboard.php");
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }
}
?>
