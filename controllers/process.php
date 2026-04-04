<?php
header("Content-Type: text/xml");

$name = isset($_POST['SpeechResult']) ? trim($_POST['SpeechResult']) : '';

$step = isset($_GET['step']) ? $_GET['step'] : 0;

echo "<Response>";

if ($step == 1 && !empty($name)) {
    echo "<Say voice='Polly.Lupe'>Hola $name, gracias por proporcionar tu nombre.</Say>";
    echo "<Hangup/>";
} else {
    // If no name or invalid step, perhaps repeat
    echo "<Say voice='Polly.Lupe'>No entendí tu nombre. Por favor, inténtalo de nuevo.</Say>";
    echo "<Gather input='speech' method='POST' language='es-ES' speechTimeout='auto' action='https://ivr-3knv.onrender.com/controllers/process.php?step=1'>";
    echo "</Gather>";
}

echo "</Response>";
?> 