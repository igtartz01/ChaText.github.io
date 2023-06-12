<?php
session_start();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once "chat_conns.php";
    $sessionID = $_SESSION["user_id"];
    // Get the submitted data
    $username = $_POST['username'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $cellNumber = $_POST['cellNumber'];

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND id != ?");
    $stmt->bind_param("si", $username, $sessionID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response = array(
            "status" => "error",
            "message" => "Username already exists"
        );
        echo json_encode($response);
        exit();
    }

    // Update the data in the database
    $query = "UPDATE users SET 
                username = '$username', 
                birthdate = '$birthdate', 
                email = '$email', 
                cellphoneNumber = '$cellNumber' 
              WHERE id = $sessionID ";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Create a success response
        $response = array(
            'success' => true,
            'message' => 'Data updated successfully.'
        );
    } else {
        // Create an error response
        $response = array(
            'success' => false,
            'message' => 'Error updating data: ' . mysqli_error($conn)
        );
    }

    // Convert the response to JSON format
    $jsonResponse = json_encode($response);

    // Set the response content type
    header('Content-Type: application/json');

    // Send the JSON response
    echo $jsonResponse;
}
?>
