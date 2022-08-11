<?php
/**
 * WHMCS SDK Sample Addon Module Hooks File
 *
 * Hooks allow you to tie into events that occur within the WHMCS application.
 *
 * This allows you to execute your own code in addition to, or sometimes even
 * instead of that which WHMCS executes by default.
 *
 * @see https://developers.whmcs.com/hooks/
 *
 * @copyright Copyright (c) WHMCS Limited 2017
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */

// Require any libraries needed for the module to function.
// require_once __DIR__ . '/path/to/library/loader.php';
//
// Also, perform any initialization required by the service's library.

/**
 * Register a hook with WHMCS.
 *
 * This sample demonstrates triggering a service call when a change is made to
 * a client profile within WHMCS.
 *
 * For more information, please refer to https://developers.whmcs.com/hooks/
 *
 * add_hook(string $hookPointName, int $priority, string|array|Closure $function)
 */
 
add_hook('ProductEdit', 1, function($vars) {
	
	// MINECRAFT
	
	if ($vars["pid"] == "2"){
		$preciodelservicio = "999 ARS - 10 USD";
	} else if ($vars["pid"] == "14"){
		$preciodelservicio = "1499 ARS - 15 USD";
	} else if ($vars["pid"] == "4"){
		$preciodelservicio = "1999 ARS - 20 USD";
	} else if ($vars["pid"] == "5"){
		$preciodelservicio = "2499 ARS - 25 USD";
	} else if ($vars["pid"] == "6"){
		$preciodelservicio = "2999 ARS - 30 USD";
	} else if ($vars["pid"] == "7"){
		$preciodelservicio = "3499 ARS - 35 USD";
	} else if ($vars["pid"] == "8"){
		$preciodelservicio = "3999 ARS - 40 USD";
	} else if ($vars["pid"] == "9"){
		$preciodelservicio = "4499 ARS - 45 USD";
	} else if ($vars["pid"] == "58"){
		$preciodelservicio = "4999 ARS - 50 USD";
		
	// VPS
	
	} else if ($vars["pid"] == "47"){
		$preciodelservicio = "4000 ARS - 40 USD";
	} else if ($vars["pid"] == "74"){
		$preciodelservicio = "8000 ARS - 80 USD";
	} else if ($vars["pid"] == "27"){
		$preciodelservicio = "16000 ARS - 160 USD";
	} else {
		$preciodelservicio = "Precio desconocido, notificar.";
	}
	
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	
    if (($vars["pid"] == 2 || $vars["pid"] == 1 || $vars["pid"] == 14 || $vars["pid"] == 4 || $vars["pid"] == 5 || $vars["pid"] == 6 || $vars["pid"] == 7 || $vars["pid"] == 8 || $vars["pid"] == 9 || $vars["pid"] == 58 || $vars["pid"] == 47 || $vars["pid"] == 74 || $vars["pid"] == 27) && $vars["qty"] >= 1) {
		
		// Replace the URL with your own webhook url
		$url = "LA URL DEL WEBHOOK ACA";

		$hookObject = json_encode([
			/*
			 * The general "message" shown above your embeds
			 */
			//"content" => "@everyone",
			/*
			 * The username shown in the message
			 */
			"username" => "Cambios de stock ─ minehost.com.ar",
			/*
			 * The image location for the senders image
			 */
			"avatar_url" => "https://cdn.discordapp.com/avatars/830103900404449290/cae17e26282021269f839a3082591071.webp?size=512",
			/*
			 * Whether or not to read the message in Text-to-speech
			 */
			"tts" => false,
			/*
			 * File contents to send to upload a file
			 */
			// "file" => "",
			/*
			 * An array of Embeds
			 */
			"embeds" => [
				/*
				 * Our first embed
				 */
				[
					// Set the title for your embed
					"title" => "STOCK MODIFICADO EN UNO DE NUESTROS SERVICIOS",

					// The type of your embed, will ALWAYS be "rich"
					"type" => "rich",

					// A description for your embed
					"description" => "",

					// The URL of where your title will be a link to
					"url" => "https://minehost.com.ar/",

					/* A timestamp to be displayed below the embed, IE for when an an article was posted
					 * This must be formatted as ISO8601
					 */

					// The integer color to be used on the left side of the embed
					"color" => hexdec( "FF0000" ),

					// Footer object
					"footer" => [
						"text" => "Ingresa para realizar el pedido rápidamente antes de que alguien más lo pida.",
					],

					// Field array of objects
					"fields" => [
						// Field 1
						[
							"name" => "Producto modificado",
							"value" => $vars["name"],
							"inline" => true
						],
						// Field 2
						[
							"name" => "Cantidad de stock actual",
							"value" => $vars["qty"],
							"inline" => true
						],
						// Field 3
						[
							"name" => "Hora argentina actual",
							"value" => date("d-m-Y H:i:s", $_SERVER['REQUEST_TIME']),
							"inline" => false
						],
						// Field 4
						[
							"name" => "Precio del servicio",
							"value" => $preciodelservicio,
							"inline" => true
						],
						// Field 5
						[
							"name" => "Tiempo de entrega estimado",
							"value" => "~ 30 minutos",
							"inline" => true
						]
					]
				]
			]

		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

		$ch = curl_init();

		curl_setopt_array( $ch, [
			CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $hookObject,
			CURLOPT_HTTPHEADER => [
				"Content-Type: application/json"
			]
		]);

		$response = curl_exec( $ch );
		curl_close( $ch );
	}
});
