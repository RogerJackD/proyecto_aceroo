<?php
$servername = "localhost";
$username = "root";
$password = "mysql114114";
$dbname = "prueeba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

require_once('db_connection.php');

// Consultar las tareas desde la base de datos
$sql = "SELECT nombre_tarea, descripcion, fecha_entrega, estado, created_at, asignado_a FROM tareas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Crear una matriz para almacenar las tareas
    $tareas = array();
    while ($row = $result->fetch_assoc()) {
        $tareas[] = $row;
    }

    // Convertir las tareas a JSON y guardarlas en un archivo
    $tareas_json = json_encode($tareas);
    $ruta_json = 'datos_tareas.json';
    file_put_contents($ruta_json, $tareas_json);

    // Ejecutar el script Python para generar el PDF
    $command = 'python generar_pdf.py';
    $output = shell_exec($command);

    // Verificar si se generó correctamente el archivo PDF
    $ruta_archivo = 'C:/Users/USUARIO/proyecto_acero/pdf/informe_tareas.pdf';
    if (file_exists($ruta_archivo)) {
        // Descargar el archivo PDF generado
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($ruta_archivo));
        header('Content-Length: ' . filesize($ruta_archivo));
        readfile($ruta_archivo);
        exit;
    } else {
        echo "Error: El archivo PDF no se ha generado correctamente.";
    }

} else {
    echo "No se encontraron tareas.";
}

$conn->close();
?>
