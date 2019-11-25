<?php

// Require composer autoload file
require "./vendor/autoload.php";

// Require the main WaterPipe class
use ElementaryFramework\WaterPipe\WaterPipe;

// Require the Request class
use ElementaryFramework\WaterPipe\HTTP\Request\Request;
// Require the Response class
use ElementaryFramework\WaterPipe\HTTP\Response\Response;

// Create the base pipe
$basePipe = new WaterPipe;

// Our login request
$basePipe->post("/api/gameq", function (Request $req, Response $res) {
    // Get request data sent by the client
    $body = $req->getBody();
    $type = $body["type"];
    $ip = $body["ip"];
    $port = $body["port"];

	////TODO! Check data correctness!
    //if ($type === "" || $ip === "" || $port === "") {
	//	// Send an unsuccessful signal to the client
    //    $res->sendJson(array(
    //        "success" => false,
    //        "error" => "Parameters cant be empty!"
    //    ));
    //} else {
	// Send a successful signal to the client
	$GameQ = new \GameQ\GameQ();
	$GameQ->addServer([
		'type' => $type,
		'host' => $ip . ':' . $port,
	]);
	$data = $GameQ->process();
    $res->sendJson($data);
});

// Our posts retrieving request
$basePipe->get("/api/gameq", function (Request $req, Response $res) {
    // Retrieve server state, from what is defined in server.json
	$GameQ = new \GameQ\GameQ();
	$GameQ->addServersFromFiles('servers.json');
	$data = $GameQ->process();
    $res->sendJSON($data);
});

// Run the pipe and serve the API
$basePipe->run();