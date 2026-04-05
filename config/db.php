<?php
$host = getenv("DB_HOST");
$user = getenv("DB_USER");
$pass = getenv("DB_PASS");
$db   = getenv("DB_NAME");
$port = getenv("DB_PORT") ?: "5432"; // PostgreSQL usa 5432

$conn = pg_connect("
    host=$host 
    port=$port 
    dbname=$db 
    user=$user 
    password=$pass
");

if (!$conn) {
    die("Error de conexión a PostgreSQL");
}
?>