<?php
	session_start();
	if (isset($_SESSION["user_id"])) {
		header('Location: ./Pages/chat.php');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Css/accountStyle.css">
  <title>Welcome: Account Set-up</title>
</head>
<body>
  <div class="main-container">
    <h2 id="welcome">`Welcome to <label class="main-title">"iChatexT"</label></h2>
    <p>"Communicate with your friends anytime, anywhere."</p>
    <div class="buttons">
      <a href="#" class="button" id="login-btn">Log in</a>
      <a href="#" class="button" id="register-btn">Register</a>
    </div>
  </div>
  <!-- login Modal -->
  <div id="login-modal" class="modal login">
    <div class="modal-content log">
      <span class="close">&times;</span>
      <h2>Login</h2>
      <form>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required placeholder="user01">
        <label for="password">Password:</label>
        <div class="password-container">
          <input type="password" id="password" name="password" required placeholder="********">
          <label for="show-password" class="show-password-icon"></label>
          <input type="checkbox" id="show-password" class="show-password" hidden>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>

  <!-- Register Modal -->
  <div id="register-modal" class="modal register">
    <div class="modal-content reg">
      <span class="close">&times;</span>
      <h2>Register</h2>
      <form>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required placeholder="ex: user01">
        <label for="username">Email:</label>
        <input type="text" id="email" name="email" required placeholder="ex: email@email.com">
        <label for="new-username">Cellphone Number:</label>
        <input type="text" id="cellphone" name="cellphone" required placeholder="ex: 09*********">
        <label for="new-username">Birthdate:</label>
        <input type="text" id="birthdate" name="birthdate" required placeholder="MM-DD-YYYY">
        <label for="new-password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="********">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required placeholder="********">
        <button type="submit">Register</button>
      </form>
    </div>
  </div>
  <script src="./Js/accountScript.js"></script>
</body>
</html>