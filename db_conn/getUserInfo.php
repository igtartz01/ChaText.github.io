<?php
session_start();
include_once "chat_conns.php";
$sessionID = $_SESSION["user_id"];
$sql = "SELECT id, username, email, cellphoneNumber, birthdate FROM users WHERE id = {$sessionID}";
$query = mysqli_query($conn, $sql);

if ($query) {
  $user = mysqli_fetch_assoc($query);
  $jsonResult = json_encode($user);
  echo $jsonResult;
} else {
  $error = mysqli_error($conn);
  $response = array("error" => $error);
  $jsonResult = json_encode($response);
  echo $jsonResult;
}
?>
