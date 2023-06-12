<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  include_once "chat_conns.php";
  $user_id = $_SESSION['user_id'];
  $incoming_id = mysqli_real_escape_string($conn, $_GET['otherUserUID']);

  // Prepare the query
  $query = "SELECT * FROM messages
  LEFT JOIN users ON users.id = messages.out_msg_id
  WHERE (messages.out_msg_id = {$user_id} AND messages.in_msg_id = {$incoming_id})
  OR (messages.out_msg_id = {$incoming_id} AND messages.in_msg_id = {$user_id}) ORDER BY msg_id";


  // Execute the query
  $result = mysqli_query($conn, $query);

  // Check if the query was successful
  if ($result) {
    // Initialize an array to store the messages
    $messages = array();

    // Fetch all the messages
    while ($message = mysqli_fetch_assoc($result)) {
      // Add each message to the array
      $messages[] = $message;
    }

    // Return the messages array
    echo json_encode($messages);
  } else {
    // Query execution failed
    echo json_encode(array('error' => 'Query execution failed.'));
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
