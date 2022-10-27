const form = document.querySelector('form');
const passwordInput = document.querySelector('input#current-password');
const signinButton = document.querySelector('button#signin');
const togglePasswordButton = document.querySelector('button#toggle-password');

togglePasswordButton.addEventListener('click', togglePassword);

function togglePassword() {
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    togglePasswordButton.textContent = 'Hide password';
    togglePasswordButton.setAttribute('aria-label',
      'Hide password.');
  } else {
    passwordInput.type = 'password';
    togglePasswordButton.textContent = 'Show password';
    togglePasswordButton.setAttribute('aria-label',
      'Show password as plain text. ' +
      'Warning: this will display your password on the screen.');
  }
}

form.addEventListener('submit', handleFormSubmit);                       

function handleFormSubmit(event) {
  console.log('submit');
  if (form.checkValidity() === false) {
    console.log('not valid');
    event.preventDefault();
  } else {
    // On a production site do form submission.
    alert('Signing in!')
    const username = form.username.value;
    const password = document.querySelector("input#current-password").value;
    event.preventDefault();
    console.log(username + " | " + password);
    if (username === "user" && password === "web_dev"){
      alert("Signed in!");
    }

  }
}