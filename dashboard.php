<?php
require 'tareas.php';

// Verifica si la sesión ya está iniciada antes de llamar a session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: inicio-secion.php");
    exit();
}

$tareasPendientes = obtenerTareas('pendiente');
$tareasEnProceso = obtenerTareas('en_proceso');
$tareasFinalizadas = obtenerTareas('finalizada');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles-tareas.css">
    <title>Dashboard</title>
</head>
<body>
    


    <?php include 'header.php'; ?>
    

    <div class="container">
    <!-- Título Principal -->
    <div class="jumbotron mt-5">
      <h1 class="display-5 text-center">GESTIONADOR DE TAREAS LOS ACEROS</h1>
    </div>
  </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#crearTareaModal">Agregar Tarea Nueva</button>
            <div>
                <button type="button" class="btn btn-outline-primary" id="btnPendientes">Pendientes</button>
                <button type="button" class="btn btn-outline-primary" id="btnEnProceso">En Proceso</button>
                <button type="button" class="btn btn-outline-primary" id="btnFinalizadas">Finalizadas</button>

                
            </div>

            <div>
                <!-- Botón para descargar el PDF generado -->
                <form id="formGenerarPDF" action="pdf/generar_pdf.php" method="post">
                    <button type="submit" class="btn btn-success">Descargar Informe de Tareas</button>
                </form>
            </div>

            



            <div class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar Tarea" aria-label="Buscar" id="buscarTarea">
            </div>
        </div>

        <div id="tareasPendientes" class="tareas-seccion mt-4">
            <h2 class="text-danger">Tareas Pendientes:</h2>
            <?php foreach ($tareasPendientes as $tarea): ?>
                <div class="card mt-3 tarea" data-nombre="<?= htmlspecialchars($tarea['nombre_tarea']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($tarea['nombre_tarea']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($tarea['descripcion']) ?></p>
                        <p class="card-text"><small class="text-muted">Fecha de Entrega: <?= htmlspecialchars($tarea['fecha_entrega']) ?></small></p>
                        <p class="card-text"><small class="text-muted">Asignado a: <?= htmlspecialchars($tarea['asignado_a']) ?></small></p>
                        <button class="btn btn-primary editarTareaBtn" data-id="<?= $tarea['id'] ?>">Editar</button>
                        <form action="tareas.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <button type="submit" name="eliminar_tarea" class="btn btn-danger">Eliminar</button>
                        </form>
                        <form action="tareas.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <input type="hidden" name="estado" value="en_proceso">
                            <button type="submit" name="cambiar_estado" class="btn btn-warning">Mover a En Proceso</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="tareasEnProceso" class="tareas-seccion mt-4" style="display:none;">
            <h2 class="text-warning">Tareas en Proceso:</h2>
            <?php foreach ($tareasEnProceso as $tarea): ?>
                <div class="card mt-3 tarea" data-nombre="<?= htmlspecialchars($tarea['nombre_tarea']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($tarea['nombre_tarea']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($tarea['descripcion']) ?></p>
                        <p class="card-text"><small class="text-muted">Fecha de Entrega: <?= htmlspecialchars($tarea['fecha_entrega']) ?></small></p>
                        <p class="card-text"><small class="text-muted">Asignado a: <?= htmlspecialchars($tarea['asignado_a']) ?></small></p>
                        <button class="btn btn-primary editarTareaBtn" data-id="<?= $tarea['id'] ?>">Editar</button>
                        <form action="tareas.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <button type="submit" name="eliminar_tarea" class="btn btn-danger">Eliminar</button>
                        </form>
                        <form action="tareas.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <input type="hidden" name="estado" value="finalizada">
                            <button type="submit" name="cambiar_estado" class="btn btn-success">Mover a Finalizadas</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="tareasFinalizadas" class="tareas-seccion mt-4" style="display:none;">
            <h2 class="text-success">Tareas Finalizadas:</h2>
            <?php foreach ($tareasFinalizadas as $tarea): ?>
                <div class="card mt-3 tarea" data-nombre="<?= htmlspecialchars($tarea['nombre_tarea']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($tarea['nombre_tarea']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($tarea['descripcion']) ?></p>
                        <p class="card-text"><small class="text-muted">Fecha de Entrega: <?= htmlspecialchars($tarea['fecha_entrega']) ?></small></p>
                        <p class="card-text"><small class="text-muted">Asignado a: <?= htmlspecialchars($tarea['asignado_a']) ?></small></p>
                        <button class="btn btn-primary editarTareaBtn" data-id="<?= $tarea['id'] ?>">Editar</button>
                        <form action="tareas.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                            <button type="submit" name="eliminar_tarea" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal Crear Tarea -->
    <div class="modal fade" id="crearTareaModal" tabindex="-1" role="dialog" aria-labelledby="crearTareaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTareaModalLabel">Crear Tarea Nueva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="tareas.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_tarea">Nombre de la Tarea</label>
                            <input type="text" class="form-control" id="nombre_tarea" name="nombre_tarea" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
                        </div>
                        <div class="form-group">
                            <label for="asignado_a">Asignado a</label>
                            <input type="text" class="form-control" id="asignado_a" name="asignado_a" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" name="crear_tarea" class="btn btn-primary">Crear Tarea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Tarea -->
    <div class="modal fade" id="editarTareaModal" tabindex="-1" role="dialog" aria-labelledby="editarTareaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTareaModalLabel">Editar Tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="tareas.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="id_editar" name="id">
                        <div class="form-group">
                            <label for="nombre_tarea_editar">Nombre de la Tarea</label>
                            <input type="text" class="form-control" id="nombre_tarea_editar" name="nombre_tarea" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_editar">Descripción</label>
                            <textarea class="form-control" id="descripcion_editar" name="descripcion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega_editar">Fecha de Entrega</label>
                            <input type="date" class="form-control" id="fecha_entrega_editar" name="fecha_entrega" required>
                        </div>
                        <div class="form-group">
                            <label for="asignado_a_editar">Asignado a</label>
                            <input type="text" class="form-control" id="asignado_a_editar" name="asignado_a" required>
                        </div>
                        <div class="form-group">
                            <label for="estado_editar">Estado</label>
                            <select class="form-control" id="estado_editar" name="estado">
                                <option value="pendiente">Pendiente</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="finalizada">Finalizada</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" name="editar_tarea" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="app.js"></script>
</body>
</html>