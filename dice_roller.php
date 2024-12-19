<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $dieType = $input['dieType'];
    $modifier = $input['modifier'];

    // Pass input to Python script
    $command = escapeshellcmd("C:\\Python311\\python.exe " . __DIR__ . "/DiceRoller.py $dieType $modifier 2>&1"); // Capture errors
    $output = shell_exec($command);

    // Log the raw output for debugging
    error_log("Python output: $output");

    // Return Python output as JSON
    header('Content-Type: application/json');

    // Check if the output is empty
    if (empty($output)) {
        echo json_encode(['error' => 'No response from Python script']);
    } else {
        echo $output;
    }
}
?>
