UPDATE `prueeba`.`tareas`
SET
`id` = <{id: }>,
`nombre_tarea` = <{nombre_tarea: }>,
`descripcion` = <{descripcion: }>,
`fecha_entrega` = <{fecha_entrega: }>,
`id_usuario` = <{id_usuario: }>,
`estado` = <{estado: pendiente}>,
`created_at` = <{created_at: CURRENT_TIMESTAMP}>,
`asignado_a` = <{asignado_a: }>
WHERE `id` = <{expr}>;
