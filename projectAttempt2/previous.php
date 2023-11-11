<?php
$db_server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "pokemon1";
session_start();
if (!isset($_SESSION['x'])) {
    $_SESSION['x'] = 1; // Initial value
}

$x = $_SESSION['x'];
$x = $x - 1;
if($x<1){
    $x = 1;
}
$_SESSION['x'] = $x;

$connection = new mysqli($db_server_name, $db_username, $db_password, $db_name);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT * FROM Pokedex WHERE id = ?";
$stmt = $connection->prepare($sql);
        // Bind parameters
       
        $stmt->bind_param("s", $x);

        // Execute query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $data = array();

        // Close statement
        $stmt->close();
        if ($result->num_rows > 0) {// should work
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        echo json_encode($data);



$connection->close();

?>