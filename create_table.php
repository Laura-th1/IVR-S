<?php
require_once "config/db.php"; // reutiliza tu conexión

$sql = "CREATE TABLE IF NOT EXISTS respuestas (
    id SERIAL PRIMARY KEY,
    telefono VARCHAR(20),
    pregunta VARCHAR(255),
    respuesta TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

$result = pg_query($conn, $sql);

if ($result) {
    echo "Tabla creada correctamente";
} else {
    echo "Error al crear tabla";
}
?>