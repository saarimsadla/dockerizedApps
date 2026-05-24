<?php

/*session_start();
header('Content-Type: application/json'); // Ensure JSON response
//echo "Executing User: " . shell_exec('whoami');
 
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}
*/



// Check if parameters are set before accessing them
$envName = isset($_GET['envName']) ? $_GET['envName'] : null;
$database_name = isset($_GET['dbName']) ? $_GET['dbName'] : null;
$collection_name = isset($_GET['colName']) ? $_GET['colName'] : null;
$cmdToRun = isset($_GET['fnc']) ? $_GET['fnc'] : null;
$qry = isset($_GET['qry']) ? $_GET['qry'] : null;

// Validate required parameters
if (!$envName || !$database_name || !$collection_name || !$cmdToRun || !$qry) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit();
}

// Decode URL-encoded JSON string
$decoded_qry = urldecode($qry);

// Validate JSON structure to prevent injection
json_decode($decoded_qry);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Invalid JSON query format"]);
    exit();
}

//print_r($decoded_qry);

// Escape inner double quotes for shell
$escaped_qry = addcslashes($decoded_qry, '"');

//print_r($escaped_qry);

// Build the command safely
/*$initial_command = "python ./pythonScripts/mongodb_query_V2.py " .
    escapeshellarg($envName) . " " .
    escapeshellarg($database_name) . " " .
    escapeshellarg($collection_name) . " " .
    escapeshellarg($cmdToRun) . " \"" .
    $escaped_qry."\"";*/
	
$is_windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

// Use appropriate path separator
$script_path = $is_windows ? '.\\pythonScripts\\mongodb_query_V2.py' : './pythonScripts/mongodb_query_V2.py';

// Build the command
$initial_command = "python $script_path " .
    escapeshellarg($envName) . " " .
    escapeshellarg($database_name) . " " .
    escapeshellarg($collection_name) . " " .
    escapeshellarg($cmdToRun) . " \"" .
    $escaped_qry . "\"";


//print_r($initial_command);


$initial_output = shell_exec($initial_command);

$initial_data = json_decode($initial_output, true);
if (!$initial_data) {
	die('{"Error": "Customers data not found."}');
}
$data=json_encode($initial_data);

header('Content-Type: application/json');
print_r($data);


?>

