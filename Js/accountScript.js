const loginModal = document.getElementById("login-modal");
const registerModal = document.getElementById("register-modal");
const loginBtn = document.getElementById("login-btn");
const registerBtn = document.getElementById("register-btn");
const closeBtns = document.getElementsByClassName("close");

// Show Login Modal
loginBtn.addEventListener("click", (e) => {
  e.preventDefault();
  loginModal.style.display = "flex";
});

// Show Register Modal
registerBtn.addEventListener("click", (e) => {
  e.preventDefault();
  registerModal.style.display = "flex";
});

// Hide Modals on Close Button Click
for (let i = 0; i < closeBtns.length; i++) {
  closeBtns[i].addEventListener("click", () => {
    loginModal.style.display = "none";
    registerModal.style.display = "none";
  });
}

// Hide Modals on Outside Click
window.addEventListener("click", (event) => {
  if (event.target == loginModal || event.target == registerModal) {
    loginModal.style.display = "none";
    registerModal.style.display = "none";
  }
});



// SHOW password -------------------------------
const passwordInput = document.querySelector('#password');
const showPasswordCheckbox = document.querySelector('#show-password');
const label = document.querySelector('.show-password-icon');

showPasswordCheckbox.addEventListener('change', function () {
  if (showPasswordCheckbox.checked) {
    passwordInput.type = 'text';
    label.classList.toggle('change')
  } else {
    passwordInput.type = 'password';
    label.classList.remove('change')
  }
});



// fetch ----------------------------------------------------------------

// fetch Registration:
const registerForm = document.querySelector('#register-modal form');
registerForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  
  const formData = new FormData(registerForm);
  
  const response = await fetch('./db_conn/registration.php', {
    method: 'POST',
    body: formData
  });
  const result = await response.json();

  if (result.status === 'success') {
    window.location.href = 'welcome.php';
    registerForm.reset();
    alert(result.message);
  } else {
    alert(result.message);
    }
});


// fetch Logging in:
const loginForm = document.querySelector('#login-modal form');
loginForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  
  const formData = new FormData(loginForm);
  
  const response = await fetch('./db_conn/login.php', {
    method: 'POST',
    body: formData
  });
  const result = await response.json();
  
  if (result.status === 'success') {
    alert("Login successful!");
    window.location.href = result.redirect; // Redirect to the dashboard
    // Clear the input fields
    loginForm.reset();
    loginForm.querySelector('#username').focus();
  } else {
    // Display an error message to the user
    alert(result.message);
  }
});