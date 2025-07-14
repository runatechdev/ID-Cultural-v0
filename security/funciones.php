<?php
function limpiar_entrada($dato) {
    return htmlspecialchars(strip_tags(trim($dato)), ENT_QUOTES, 'UTF-8');
}

function encriptar_clave($clave) {
    return password_hash($clave, PASSWORD_DEFAULT);
}

function verificar_clave($clave_ingresada, $hash_guardado) {
    return password_verify($clave_ingresada, $hash_guardado);
}
?>