<?php
$g = stream_context_create(array("ssl" => array(
    "capture_peer_cert_chain" => true,
    "verify_peer" => false,
    "verify_peer_name" => false
)));
$r = stream_socket_client("ssl://claritylab.id:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
$cont = stream_context_get_params($r);
$chain = $cont["options"]["ssl"]["peer_certificate_chain"];
foreach ($chain as $index => $cert) {
    echo "--- Certificate #$index ---\n";
    $parsed = openssl_x509_parse($cert);
    echo "Subject: " . $parsed['name'] . "\n";
    echo "Issuer: " . (is_array($parsed['issuer']) ? implode(', ', $parsed['issuer']) : $parsed['issuer']) . "\n";
    if (isset($parsed['extensions'])) {
        echo "Key Usage: " . ($parsed['extensions']['keyUsage'] ?? 'None') . "\n";
        echo "Extended Key Usage: " . ($parsed['extensions']['extendedKeyUsage'] ?? 'None') . "\n";
    }
    echo "\n";
}
