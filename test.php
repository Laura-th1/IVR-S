<?php
require_once "config/db.php";

$result = pg_query($conn, "SELECT NOW()");

if ($result) {
    $row = pg_fetch_assoc($result);
    echo "✅ Conectado a PostgreSQL: " . $row['now'];
} else {
    echo "❌ Error en la conexión";
}
?>