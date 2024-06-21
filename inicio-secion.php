<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles-inicio-sesion.css">   
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <form method="POST" action="login.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contraseña" placeholder="Contraseña" required><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php
        session_start();
        if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
            echo "<p class='error'>{$_SESSION['error_message']}</p>";
            echo "<a href='recuperar-contraseña.php'>Olvidé mi contraseña</a>";
            unset($_SESSION['error_message']); 
        }
        ?>
        <a href="registro-cuenta.php">Crear cuenta</a>
    </div>
</body>
</html>