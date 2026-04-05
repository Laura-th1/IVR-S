<?php
require_once "../config/bd.php";

header("Content-Type: text/xml");

//debug temporal
@file_put_contents("log.txt", print_r($_POST, true) . "\n--- " . date('Y-m-d H:i:s') . " ---\n", FILE_APPEND);

$telefono = $_POST['From'] ?? '';
$respuesta = $_POST['SpeechResult'] ?? '';
$step = $_GET['step'] ?? 1;

if (empty($respuesta)) {
    echo "<Response>";
    echo "<Say voice='Polly.Lupe'>No entendí tu respuesta. Intenta nuevamente por favor.</Say>";
    echo "<Redirect>https://ivr-3knv.onrender.com/controllers/voice.php</Redirect>";
    echo "</Response>";
    exit;
}

echo "<Response>";

if ($step == 1) {

    // Guardar nombre
    $query = "INSERT INTO respuestas (telefono, pregunta, respuesta) VALUES ('" . pg_escape_string($telefono) . "', 'Nombre', '" . pg_escape_string($respuesta) . "')";
    $result = pg_query($conn, $query);
    
    if (!$result) {
        echo "<Say voice='Polly.Lupe'>Error al guardar. Intenta nuevamente.</Say>";
    } else {
        echo "<Say voice='Polly.Lupe'>Gracias $respuesta. Ahora dime tu edad.</Say>";
    }

    echo "<Gather input='speech' method='POST' timeout='5'
          action='https://ivr-3knv.onrender.com/controllers/process.php?step=2'></Gather>";

} 

if ($curlError) {
    echo "<Say voice='Polly.Lupe'>Tus datos fueron guardados, pero hubo un error al enviar el mensaje.</Say>";
} elseif ($httpCode == 201) {
    echo "<Say voice='Polly.Lupe'>Tus datos fueron guardados y el mensaje fue enviado correctamente.</Say>";
} else {
    echo "<Say voice='Polly.Lupe'>Tus datos fueron guardados, pero el mensaje no pudo enviarse.</Say>";
}

echo "</Response>";