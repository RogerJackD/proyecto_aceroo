<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles-registro-cuenta.css">   
    <title>Registro de Cuenta</title>
</head>
<body>
    <div class="container">
        <h1>REGISTRO DE CUENTA</h1>
        <!-- Aquí se mostrará el mensaje de advertencia -->
        <?php if(isset($mensaje)): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form method="POST" action="registro.php">
            <input type="text" name="nombre" placeholder="Nombre" required><br>
            <input type="text" name="apellido" placeholder="Apellido" required><br>
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contraseña" placeholder="Contraseña" required><br>
            <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required><br>
            <button type="submit">CREAR CUENTA</button>
        </form>
        <a href="inicio-secion.php">Iniciar Sesión</a>
    </div>
</body>
</html>

