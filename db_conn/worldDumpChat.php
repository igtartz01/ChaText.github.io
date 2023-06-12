<?php

session_start();
if (isset($_SESSION['user_id'])) {
  include_once "chat_conns.php";
  $out_id = $_SESSION["user_id"];
  $message = json_decode(file_get_contents('php://input'));
  
  if (!empty($message)) {
      $sql = 
        mysqli_query($conn, "INSERT INTO messages (out_msg_id, msg)
        VALUES ({$out_id}, '{$message}')") or die();
  }
  $conn->close();
}
?>
