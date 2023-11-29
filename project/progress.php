<?php

// Your PHP logic to calculate the progress value
// This is just an example; you need to replace it with your actual logic
$progressValue = rand(0, 100);

// Return the progress value as JSON
header('Content-Type: application/json');
echo json_encode(['value' => $progressValue]);

?>