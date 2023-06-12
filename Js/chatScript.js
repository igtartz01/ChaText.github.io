// VIEW User-Client info -----------------------------------------
const leftCont = document.querySelector('.left-cont');
const profileName = document.querySelector('.profile-name');
const bday = document.querySelector('#bday');
const email = document.querySelector('#email');
const cellNum = document.querySelector('#cellNum');
const fetchUserInfo = () => {
  fetch('../db_conn/getUserInfo.php')
  .then(response => response.json())
  .then(data => {
    profileName.textContent = data.username;
    bday.textContent = data.birthdate;
    email.textContent = data.email;
    cellNum.textContent = data.cellphoneNumber;
  })
  .catch(error => {
    console.log('An error occurred while fetching user info:', error);
  });
};


// OPEN AND CLOSE edit PROFILE -------------------------------------------------------
const closeBtns = document.querySelector(".close");
const modal = document.querySelector(".modal");
const edit_profile_btn = document.querySelector('.edit_profile-btn');

const edit_username = document.querySelector('#username');
const edit_birthdate = document.querySelector('#birthdate');
const edit_email = document.querySelector('#e-mail');
const edit_cellNum = document.querySelector('#cellNumber');

edit_profile_btn.addEventListener('click', (e)=>{
  e.preventDefault();
  fetch('../db_conn/getUserInfo.php')
  .then(response => response.json())
  .then(data => {
    edit_username.value = data.username;
    edit_birthdate.value = data.birthdate;
    edit_email.value = data.email;
    edit_cellNum.value = data.cellphoneNumber;
  });

  modal.style.display = "flex";
});
closeBtns.addEventListener("click", () => {
  modal.style.display = "none";
});

// UPDATE PROFILE INFOS -------------------------------------------------
const editForm = document.querySelector('#edit-modal form');
editForm.addEventListener('submit', async (e) => {
  e.preventDefault();

  const formData = new FormData(editForm);

  const response = await fetch('../db_conn/updateProfileInfo.php', {
    method: 'POST',
    body: formData
  });

  const result = await response.json();

  if (result.success) {
    alert(result.message);
    modal.style.display = "none";
    location.href = "chat.php";
  } else {
    alert(result.message);
  }
});



const worldMsgBox = document.querySelector('#world-msg-cont');
const worldMsgInput = document.querySelector('#world-input');
const worldMsgSendBtn = document.querySelector('#world-btn');
const blankMsgAlert = document.querySelector('.blankMsgAlert')
// World Chat message ---------------------------------------------
worldMsgSendBtn.addEventListener('click', (e)=> {
  const worldMsgs = worldMsgInput.textContent.trim();
  e.preventDefault();
  if (worldMsgs === "") {
    blankMsgAlert.classList.add('alert')
    worldMsgBox.insertBefore(blankMsgAlert, worldMsgBox.firstChild);
  }else{
    fetch('../db_conn/worldDumpChat.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(worldMsgs),
    })
  }
  worldMsgInput.textContent = "";
});


let lastFetchedData = []; // Variable to store the last fetched data
let sessionId = ""; // Variable to store the session ID

// Start the interval after retrieving the session ID
setInterval(() => {
  fetch('../db_conn/getWorldChatMsg.php', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
  })
  .then(response => response.json())
  .then(data => {
    
    sessionId = data[0].user_id;
    // Compare the new data with the last fetched data
    if (JSON.stringify(data) !== JSON.stringify(lastFetchedData)) {

      // Update the last fetched data
      lastFetchedData = data;

      // Update the UI with the fetched data
      worldMsgBox.innerHTML = ""; // Clear existing content

      for (const outID of data[1]) {
        const msgCont = document.createElement('div')
        const msg = document.createElement('span')

        if (outID.out_msg_id !== String(sessionId)) {
          msgCont.classList.add('recipient-cont');
          msg.classList.add('recipient');
        }else{
          msgCont.classList.add('sender-cont');
          msg.classList.add('sender');
        }
        msg.textContent = outID.msg;
        msgCont.appendChild(msg);
        worldMsgBox.insertBefore(msgCont, worldMsgBox.firstChild);
      }
    }
  });
}, 500);


const darkMode = document.querySelector('.dark-mode');
const darkWrap = document.querySelector('.dark-wrap');
const darkSpan = document.querySelector('.dark');

const profileCont = document.querySelector('.profile-cont');
const otherProfile = document.querySelector('.other-user-cont');
const middleCont = document.querySelector('.middle-cont');
const navCont = document.querySelector('.nav-cont');
const labelWrapp = document.querySelector('.label-wrapp');
const titleCont = document.querySelector('.title-cont');
const chatBtn = document.querySelectorAll('.chat_submit-btn');
const usersLink = document.getElementsByClassName('users-link');
// dark mode ------------------------------------------
darkMode.addEventListener('click', (e)=>{
  e.preventDefault();
  darkWrap.classList.toggle('switch-bg')
  darkSpan.classList.toggle('switch-dark')
  profileCont.classList.toggle('switch-color-1')
  otherProfile.classList.toggle('switch-color-1')
  middleCont.classList.toggle('switch-color-1')
  navCont.classList.toggle('switch-color-1')
  labelWrapp.classList.toggle('switch-color-2')
  titleCont.classList.toggle('switch-color-2')
  
  for(let i = 0; i < chatBtn.length; i++) {
    chatBtn[i].classList.toggle('switch-color-2')
  }
  for(let i = 0; i < usersLink.length; i++) {
    usersLink[i].classList.toggle('users-link-01')
  }
});


// show/HIDE users --------------------------------------------------
const users = document.querySelector('.users_dropdown-menu');
const usersBtn = document.querySelector('.userBtn');

usersBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  users.classList.toggle('showUsers');
});


const worldChatBtn = document.querySelector('#worldChat');
const worldChatBox = document.querySelector('.world-wrapp');
const chatBoxLabel = document.querySelector('#chat-label');
const otherUserCont = document.querySelector('.other-user-cont');
// show world message Chat Box -------------------------------------------
worldChatBtn.addEventListener('click', (e)=>{
  e.preventDefault();
  const userChatBox = document.querySelector('.user-box-wrap');
  if(userChatBox){
    chatBoxLabel.textContent = "World Chat";
    worldChatBox.classList.remove('hideWorldChat');
    userChatBox.classList.remove('showUserChat')
    otherUserCont.style.display = "none"
  }
});


let userLastFetchedData = []; // Variable to store the last fetched data
let inUniqueID = ""; // Variable to store the session ID
// GET 1on1 users Messages -----------------------------------------
const get1on1Chat = (otherUserUID) => {
  const userMsgCont = document.querySelector('#userMsgCont');
  fetch(`../db_conn/get1on1Chat.php?otherUserUID=${encodeURIComponent(otherUserUID)}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
    return response.json();
  })
  .then(data => {
    
    inUniqueID = otherUserUID;

    if (JSON.stringify(data) !== JSON.stringify(userLastFetchedData)) {
      userLastFetchedData = data;

      userMsgCont.innerHTML = ""; // Clear existing content
      // Process the retrieved data

      for (const message of data) {
        const msgCont = document.createElement('div');
        const msg = document.createElement('span');

        if (message.out_msg_id === String(inUniqueID)) {
          msgCont.classList.add('recipient-cont');
          msg.classList.add('recipient');
        } else {
          msgCont.classList.add('sender-cont');
          msg.classList.add('sender');
        }

        msg.textContent = message.msg;
        msgCont.appendChild(msg);
        userMsgCont.insertBefore(msgCont, userMsgCont.firstChild);
      }
    }
  });
};


// 1:1 Users message ---------------------------------------------
const sendUserChat = (event) => {
  event.preventDefault();
  const userMsgCont = document.querySelector('#userMsgCont');
  const msgInput = document.querySelector('#chat-input');
  const inUniqueID = document.querySelector('#inUnique_id');

  const userMsg = msgInput.textContent.trim();
  
  if (userMsg === "") {
    blankMsgAlert.classList.add('alert')
    userMsgCont.insertBefore(blankMsgAlert, userMsgCont.firstChild);
  } else {
    blankMsgAlert.classList.remove('alert')
    fetch('../db_conn/dumpChats.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify
      ({
        'userMsg': userMsg,
      'inUniqueID': inUniqueID.value
      }),
    });
  }
  
  msgInput.textContent = "";
};


const viewOtherUserInfo =(username, email, cellNum, bDay)=>{
  const otherName = document.querySelector('#otherName');
  const otherBDay = document.querySelector('#otherBDay');
  const otherEmail = document.querySelector('#otherEmail');
  const otherCellNum = document.querySelector('#otherCellNum');

  otherUserCont.style.display = "flex"
  otherName.textContent = username;
  otherBDay.textContent = email;
  otherEmail.textContent = cellNum;
  otherCellNum.textContent = bDay;
}

function escapeHtml(text) {
  if (typeof text !== 'string') {
    text = String(text);
  }
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
  };
  return text.replace(/[&<>"']/g, (char) => map[char]);
}

let intervalId;
const createUserChatBox = (inUnique_id, username, email, cellNum, bDay, event) => {
  event.preventDefault();
  viewOtherUserInfo(username, email, cellNum, bDay);
  const sanitizedUniqueId = escapeHtml(inUnique_id);
  const msgsBox =  `
    <div class="chat-wrapper user-box-wrap">
      <div class="messages-cont" id="userMsgCont">
      </div>
      <div class="message_input-cont">
        <input type="text" id="inUnique_id" value="${sanitizedUniqueId}" name="inUnique_id" hidden>
        <div class="chat-input" id="chat-input" name="chatMsg" contenteditable="true"></div>
        <input type="submit" class="chat_submit-btn userSubBtn" value="&#10148" onClick="sendUserChat(event)">
      </div>
    </div>`;

  const existingUserChatBox = document.querySelector('.user-box-wrap');
  if (existingUserChatBox) {
    const existingID = document.querySelector('#inUnique_id');
    existingID.value = sanitizedUniqueId;
  }
  if(!existingUserChatBox){
    middleCont.insertAdjacentHTML('beforeend', msgsBox);
  }

  const userChatBox = document.querySelector('.user-box-wrap');
  chatBoxLabel.textContent = "1:1 Chat";
  worldChatBox.classList.add('hideWorldChat');
  userChatBox.classList.add('showUserChat');
  

  // Clear the previous interval, if any
  clearInterval(intervalId);

  // Set the new interval and store the ID
  intervalId = setInterval(() => {
    get1on1Chat(sanitizedUniqueId);
  }, 500);
};



// userOBject =====================================================
const usersDropdowns = document.querySelector('.users-dropdown');
const fetchOtherUsersInfo = () => {
  fetch('../db_conn/fetchUsers.php')
  .then(response => response.json())
  .then(data => {
    const usernames = data.names;
    

    let usersData = '';
    usernames.forEach(user => {
      const { username, unique_id, email, cellphoneNumber, birthdate } = user;

      usersData += `
      <a href="#" class="users-link" onClick="createUserChatBox('${unique_id}', '${username}', '${email}', '${cellphoneNumber}', '${birthdate}', event)">
      ${username}
      </a>`;
    });

    usersDropdowns.innerHTML = usersData;
  });
}

  
document.addEventListener('DOMContentLoaded', function() {
  fetchOtherUsersInfo();
  fetchUserInfo();
});

  




