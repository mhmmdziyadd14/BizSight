<?php
$g = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
$r = stream_socket_client("ssl://claritylab.id:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
$cont = stream_context_get_params($r);
$cert = $cont["options"]["ssl"]["peer_certificate"];
$parsed = openssl_x509_parse($cert);
print_r($parsed);
