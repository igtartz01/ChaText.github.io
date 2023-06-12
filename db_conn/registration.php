<?php
require "./chat_conns.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');

  // Validate and sanitize user input data
  $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
  $cellphone = filter_var($_POST["cellphone"], FILTER_SANITIZE_STRING);
  $birthdate = filter_var($_POST["birthdate"], FILTER_SANITIZE_STRING);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $ran_id = rand(time(), 100000000);
  $status = "Active now";

  // Check if the username already exists in the database
  $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
  $stmt->bind_param("s", $username);
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

  // Insert new user registration data into the database
  $stmt = $conn->prepare("INSERT INTO users (unique_id, username, email, cellphoneNumber, birthdate, password, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssss", $ran_id, $username, $email, $cellphone, $birthdate, $password, $status);
  if ($stmt->execute()) {
    // Return a response to the frontend JavaScript function
    $response = array(
      "status" => "success",
      "message" => "User registered successfully"
    );
    echo json_encode($response);
  } else {
    $response = array(
      "status" => "error",
      "message" => "Error in user registration"
    );
    echo json_encode($response);
  }

  // Close database connection
  $stmt->close();
  $conn->close();
}
