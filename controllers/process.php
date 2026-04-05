<?php 
require_once __DIR__ . "/../config/db.php";

header("Content-Type: text/xml");

// Debug temporal (opcional)
@file_put_contents("log.txt", print_r($_POST, true) . "\n--- " . date('Y-m-d H:i:s') . " ---\n", FILE_APPEND);

$telefono = $_POST['From'] ?? '';
$respuesta = $_POST['SpeechResult'] ?? '';
$step = $_GET['step'] ?? 1;

echo "<Response>";

// Validar respuesta vacía
if (empty($respuesta)) {
    echo "<Say voice='Polly.Lupe'>No entendí tu respuesta. Intenta nuevamente por favor.</Say>";
    echo "<Redirect>https://ivr-3knv.onrender.com/controllers/voice.php</Redirect>";
    echo "</Response>";
    exit;
}

if ($step == 1) {

    // Guardar nombre
    $result = pg_query_params(
        $conn,
        "INSERT INTO respuestas (telefono, pregunta, respuesta) VALUES ($1, $2, $3)",
        [$telefono, 'Nombre', $respuesta]
    );

    if (!$result) {
        echo "<Say voice='Polly.Lupe'>Error al guardar. Intenta nuevamente.</Say>";
    } else {
        echo "<Say voice='Polly.Lupe'>Gracias $respuesta. Ahora dime tu edad.</Say>";
    }

    echo "<Gather input='speech' method='POST' timeout='5' language='es-ES' speechTimeout='auto'
          action='https://ivr-3knv.onrender.com/controllers/process.php?step=2'></Gather>";

} elseif ($step == 2) {

    // Guardar edad
    $result = pg_query_params(
        $conn,
        "INSERT INTO respuestas (telefono, pregunta, respuesta) VALUES ($1, $2, $3)",
        [$telefono, 'Edad', $respuesta]
    );

    if (!$result) {
        echo "<Say voice='Polly.Lupe'>Error al guardar edad.</Say>";
    } else {
        echo "<Say voice='Polly.Lupe'>Gracias. Tus datos han sido guardados correctamente.</Say>";
    }
}

echo "</Response>";
?>