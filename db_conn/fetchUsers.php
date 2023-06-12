<?php
session_start();
include_once "chat_conns.php";
$out_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE NOT id = {$out_id} ORDER BY username";
$query = mysqli_query($conn, $sql);
$output = [];

if (mysqli_num_rows($query) == 0) {
    $output[] = "No users are available to chat";
} else {
    while ($row = mysqli_fetch_assoc($query)) {
        $user = array(
            'unique_id' => $row['id'],
            'username' => $row['username'],
            'email' => $row['email'],
            'cellphoneNumber' => $row['cellphoneNumber'],
            'birthdate' => $row['birthdate']
        );
        $output[] = $user;
    }
}

$response = array(
    'session_id' => $_SESSION["user_id"],
    'names' => $output
);
header('Content-Type: application/json');
echo json_encode($response);
?>
