<?php
// Replace 'data.json' with your desired JSON file name
$jsonFile = 'data.json';
$data = file_get_contents($jsonFile);

// Decode the JSON data
$decodedData = json_decode($data, true); // Set the second parameter to true for associative arrays

// Check if decoding was successful
if ($decodedData === null) {
    // Handle the error, e.g., JSON syntax error
    echo 'Error decoding JSON';
} else {
    // Access the data as a PHP array
    $employees = $decodedData['employees']; // pulls employee array {employee[{name:john,age:10}{name:bob,age:20}]}

    // Do something with the data
    foreach ($employees as $employee) {  // pulls data from each object
        echo 'Name: ' . $employee['name'] . ', Age: ' . $employee['age'] . '<br>';
    }
}
?>
