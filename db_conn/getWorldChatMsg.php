<?php
session_start();
// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  include_once "chat_conns.php";
  // Retrieve data where out_msg_id = user session ID or not equal to user session ID from the "messages" table

  $user_id = $_SESSION['user_id'];

  // Create a JSON response
  $response = array('user_id' => $user_id);
  $sql = "SELECT * FROM messages WHERE in_msg_id = 0";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Fetch the message data and store it in an array
      $messages = array();
      while ($row = $result->fetch_assoc()) {
          $messages[] = $row;
      }

      // Return the message data as JSON response
      header('Content-Type: application/json');
      echo json_encode(array($response, $messages));
  } else {
      // No data found
      echo json_encode(array($response, array()));
  }
  // Close the database connection
  $conn->close();
} else {
  // Invalid request method
  echo "Invalid request method.";
}
?>
