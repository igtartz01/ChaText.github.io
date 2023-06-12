<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once "chat_conns.php";
  header('Content-Type: application/json');
  $out_id = $_SESSION["user_id"];

  $input = file_get_contents("php://input");
  $decode = json_decode($input, true);

  $inUnique_id = mysqli_real_escape_string($conn, $decode['inUniqueID']);
  $message = mysqli_real_escape_string($conn, $decode['userMsg']);

  if (!empty($message)) {
    $sql = "INSERT INTO messages (in_msg_id, out_msg_id, msg)
            VALUES ('$inUnique_id', '$out_id', '$message')";

    if (mysqli_query($conn, $sql)) {
      echo "Message inserted successfully.";
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }
}
?>
