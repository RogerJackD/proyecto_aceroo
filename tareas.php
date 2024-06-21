<?php
require 'database.php';

// Verifica si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function obtenerTareas($estado) {
    global $pdo;
    $id_usuario = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT id, nombre_tarea, descripcion, fecha_entrega, estado, asignado_a FROM tareas WHERE id_usuario = ? AND estado = ?");
    $stmt->execute([$id_usuario, $estado]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_POST['crear_tarea'])) {
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $id_usuario = $_SESSION['user_id'];
    $asignado_a = $_POST['asignado_a'];
    $estado = 'pendiente';

    $stmt = $pdo->prepare("INSERT INTO tareas (nombre_tarea, descripcion, fecha_entrega, id_usuario, estado, asignado_a) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$nombre_tarea, $descripcion, $fecha_entrega, $id_usuario, $estado, $asignado_a])) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if (isset($_POST['editar_tarea'])) {
    $id = $_POST['id'];
    $nombre_tarea = $_POST['nombre_tarea'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $estado = $_POST['estado'];
    $asignado_a = $_POST['asignado_a'];

    $stmt = $pdo->prepare("UPDATE tareas SET nombre_tarea = ?, descripcion = ?, fecha_entrega = ?, estado = ?, asignado_a = ? WHERE id = ?");
    if ($stmt->execute([$nombre_tarea, $descripcion, $fecha_entrega, $estado, $asignado_a, $id])) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if (isset($_POST['eliminar_tarea'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ?");
    if ($stmt->execute([$id])) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if (isset($_POST['cambiar_estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    $stmt = $pdo->prepare("UPDATE tareas SET estado = ? WHERE id = ?");
    if ($stmt->execute([$estado, $id])) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT id, nombre_tarea, descripcion, fecha_entrega, estado, asignado_a FROM tareas WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}
?>