<?php

function contiene_inyeccion($valor) {
    $patrones = [
        "/(\%27)|(\')|(\-\-)|(\%23)|(#)/i",
        "/((\%27)|(\'))union/i",
        "/(\%27|\')\s+or\s+/i",
        "/or\s+1=1/i",
        "/select\s+.*\s+from/i"
    ];
    foreach ($patrones as $patron) {
        if (preg_match($patron, $valor)) {
            return true;
        }
    }
    return false;
}

function escanear_inyecciones($conn) {
    foreach ($_GET as $key => $valor) {
        if (contiene_inyeccion($valor)) {
            registrarAuditoria($conn, null, 'Inyección SQL', 'Patrón detectado en GET', "Parámetro '$key' => '$valor'");
        }
    }

    foreach ($_POST as $key => $valor) {
        if (contiene_inyeccion($valor)) {
            registrarAuditoria($conn, null, 'Inyección SQL', 'Patrón detectado en POST', "Parámetro '$key' => '$valor'");
        }
    }
}
