<?php
	session_start();
	if (!isset($_SESSION["user_id"])) {
		header('Location: ../welcome.php');
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Css/chatStyle.css">
  <title>iChatexT</title>
</head>
<body>

  <main class="main-cont">
    <div class="title-cont">
      <label for="" class="title"><span>#</span>iChatexT</label>
    </div>
    <div class="content-cont">
      <section class="left-cont">
        <div class="profile-cont">
          <img src="../IMG/default.png" alt="" class="profile-img">
          <label for="" class="profile-name"></label>
          <ul class="pofile-options">
            <li><a href="../db_conn/log-out.php" class="logout-btn">Log-out</a></li>
            <li><a href="#" class="edit_profile-btn">Edit Profile</a></li>
          </ul>
          <hr>
          <ul class="profile_info-cont">
            <li class="profile-info">Birth Date: <span class="profile-data" id="bday"></span></li>
            <li class="profile-info">Email: <span class="profile-data" id="email"></span></li>
            <li class="profile-info">Cellphone Number: <span class="profile-data" id="cellNum"></span></li>
          </ul>
        </div>
        <nav class="nav-cont">
          <ul class="nav-lists">
            <li>
              <a href="#" class="nav-link" id="worldChat"><span class="nav-icons">∞</span>World Chat <span id="arrow">☼</span></a>
            </li>
            <li>
              <a href="#" class="nav-link userBtn"><span class="nav-icons">☺</span>Users <span id="arrow">☼</span></a>
            </li>
            <div class="users_dropdown-menu">
              <div class="users-dropdown">
              </div>
            </div>
            <li>
              <a href="#" class="nav-link dark-mode"><div class="dark-wrap"><span class="dark">&#9728;</span></div> Switch Color<span id="arrow">☼</span><div></div></a>
            </li>
          </ul>
        </nav>
      </section>
      <div class="middle-cont">
        <div class="label-wrapp">
          <label for="" id="chat-label">World Chat</label>
        </div>
        <!-- world chat Chat-box -->
        <div class="chat-wrapper world-wrapp" id="world-wrapp">
          <div class="messages-cont world-msg-cont" id="world-msg-cont">
            <span class="blankMsgAlert">--No Message Sent!--</span>
          </div>
          <div class="message_input-cont">
            <div class="chat-input" id="world-input" contenteditable="true"></div>
            <input type="submit" class="chat_submit-btn world-btn" id="world-btn" value="&#10148">
          </div>
        </div>

      </div>
      <section class="right-cont">
        <div class="profile-cont other-user-cont">
          <img src="../IMG/default.png" alt="" class="profile-img other-user">
          <label for="" class="profile-name other-name" id="otherName">User</label>
          <hr>
          <ul class="profile_info-cont other-user">
            <li class="profile-info other-user">Birth Date: <span  class="profile-data" id="otherBDay"></span></li>
            <li class="profile-info other-user">Email: <span  class="profile-data" id="otherEmail"></span></li>
            <li class="profile-info other-user">Cellphone Number: <span class="profile-data" id="otherCellNum"></span></li>
          </ul>
        </div>
      </section>
    </div>
   
  </main>
  <div id="edit-modal" class="modal edit">
    <div class="modal-content edit-profile">
      <span class="close">&times;</span>
      <h2 class="edit-label">Edit Profile:</h2>
      <form>
        <label class="edit-label">Username:</label>
        <input type="text" id="username" name="username">
        <label class="edit-label">Birthdate:</label>
        <input type="text" id="birthdate" name="birthdate">
        <label class="edit-label">Email:</label>
        <input type="text" id="e-mail" name="email">
        <label class="edit-label">CellNumber:</label>
        <input type="text" id="cellNumber" name="cellNumber">
        <button type="submit" class="edit-label">Save</button>
      </form>
    </div>
  </div>
  <script src="../Js/chatScript.js"></script>
</body>
</html>