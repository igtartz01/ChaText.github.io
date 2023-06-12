<?php
require "./chat_conns.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  header('Content-Type: application/json');

  // Validate and sanitize user input data
  $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
  $password = $_POST["password"];

  // Retrieve user data from the database
  $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Check if the provided password matches the hashed password stored in the database
    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
      // Start user session and redirect to the dashboard
      session_start();
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["username"] = $user["username"];
      $response = array(
        "status" => "success",
        "redirect" => "./Pages/chat.php"
      );
      echo json_encode($response);
      exit();
    }
  }

  // Return an error response to the frontend JavaScript function
  $response = array(
    "status" => "error",
    "message" => "Invalid username or password"
  );
  echo json_encode($response);

  // Close database connection
  $conn->close();
}
