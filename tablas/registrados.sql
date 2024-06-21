UPDATE `prueeba`.`registrados`
SET
`id` = <{id: }>,
`nombre` = <{nombre: }>,
`apellido` = <{apellido: }>,
`correo` = <{correo: }>,
`contraseña` = <{contraseña: }>,
`created_at` = <{created_at: CURRENT_TIMESTAMP}>
WHERE `id` = <{expr}>;