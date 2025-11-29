const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", () => {
  const isHidden =
    passwordInput.type === "password"; /* Checking password is hidden */

  /* Toggle input type using if-else  */
  if (isHidden) {
    passwordInput.type = "text"; /* Show password */
    togglePassword.textContent = "visibility"; /* Open eye icon */
  } else {
    passwordInput.type = "password"; /* Hide password */
    togglePassword.textContent = "visibility_off"; /* Closed eye icon  */
  }
});

function validateLogin() {
  const user_email = document.getElementById("email").value.trim();
  const user_password =
    passwordInput.value.trim(); /*document.getElementById("password") not used as it is already defined*/

  /* Check if empty */
  if (user_email.length === 0) {
    alert("Email cannot be empty");
    return false;
  }

  /* Check if password is empty */
  if (user_password.length === 0) {
    alert("Password cannot be empty");
    return false;
  }
  /* Check if password is atleast 6 chars */
  if (user_password.length < 6) {
    alert("Password must be at least 6 characters long");
    return false;
  }
  /* Basic email regex */
  const regex = /^[A-Za-z0-9._+-]+@[A-Za-z0-9.-]+\.com$/;

  if (!regex.test(user_email)) {
    alert("Enter a valid email (example: name@example.com)");
    return false;
  }

  return true; /* Validation passed */
}

document.getElementById("LoginBtn").addEventListener("click", () => {
  if (validateLogin()) {
    /* Submit the form if validation passes */
    document.getElementById("LoginForm").submit();
  }
});
