<?php
// URL 
$url = "https://sysweb.unach.mx/Siae/api/Alertas/Obtener"; 

// inicia el cURL
$ch = curl_init();

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar si hay problemas con SSL

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

