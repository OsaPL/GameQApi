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
$basePipe->post("/api/gameq", function (Request $req, Response $res) 
{
    // Get request data sent by the client
    $body = $req->getBody();

    ////TODO! Check data correctness!
    //if ($type === "" || $ip === "" || $port === "") {
	//	// Send an unsuccessful signal to the client
    //    $res->sendJson(array(
    //        "success" => false,
    //        "error" => "Parameters cant be empty!"
    //    ));
    //} else {
	
    $GameQ = new \GameQ\GameQ();
	
    $isArray = is_array($body["servers"]);

    // Checking if we have an array of servers to process.
	if($isArray)
    {
        foreach ($body["servers"] as &$value) 
        {
            $type = $value["type"];
            $ip = $value["ip"];
            $port = $value["port"];

	        $GameQ->addServer([
		        'type' => $type,
		        'host' => $ip . ':' . $port,
	        ]);
        }
	}
    // If single entry
    else
    {
        $type = $body["type"];
        $ip = $body["ip"];
        $port = $body["port"];

	    $GameQ->addServer([
		    'type' => $type,
		    'host' => $ip . ':' . $port,
	    ]);
	}

	$data = $GameQ->process();
    $res->sendJson($data);
});

// Our posts retrieving request
$basePipe->get("/api/gameq", function (Request $req, Response $res) 
{
    // Retrieve server state, from what is defined in server.json
	$GameQ = new \GameQ\GameQ();
	$GameQ->addServersFromFiles('servers.json');
	$data = $GameQ->process();
    $res->sendJSON($data);
});

// Run the pipe and serve the API
$basePipe->run();