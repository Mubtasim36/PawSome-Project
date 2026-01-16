const passwordInput = document.getElementById("password");
const togglePassword = document.getElementById("togglePassword");
const confirmPasswordInput = document.getElementById("confirmPassword");
const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

/* Toggle password visibility */
togglePassword.addEventListener("click", () => {
  const isHidden = passwordInput.type === "password"; /* Checking if password is hidden */

  /* Toggle input type using if-else */
  if (isHidden) {
    passwordInput.type = "text"; /* Show password */
    togglePassword.textContent = "visibility"; /* Open eye icon */
  } else {
    passwordInput.type = "password"; /* Hide password */
    togglePassword.textContent = "visibility_off"; /* Closed eye icon */
  }
});

/* Toggle confirm password visibility */
toggleConfirmPassword.addEventListener("click", () => {
  const isHidden = confirmPasswordInput.type === "password"; /* Checking if confirm password is hidden */

  /* Toggle input type using if-else */
  if (isHidden) {
    confirmPasswordInput.type = "text"; /* Show password */
    toggleConfirmPassword.textContent = "visibility"; /* Open eye icon */
  } else {
    confirmPasswordInput.type = "password"; /* Hide password */
    toggleConfirmPassword.textContent = "visibility_off"; /* Closed eye icon */
  }
});

function validateSignup() {
  const user_fullname = document.getElementById("fullname").value.trim();
  const user_email = document.getElementById("email").value.trim();
  const user_phone = document.getElementById("phone").value.trim();
  const user_password = passwordInput.value.trim();
  const user_confirmPassword = confirmPasswordInput.value.trim();
  const termsCheckbox = document.getElementById("terms");

  /* Check if full name is empty */
  if (user_fullname.length === 0) {
    alert("Full name cannot be empty");
    return false;
  }

  /* Check if name has at least 2 characters */
  if (user_fullname.length < 2) {
    alert("Full name must be at least 2 characters long");
    return false;
  }

  /* Check if email is empty */
  if (user_email.length === 0) {
    alert("Email cannot be empty");
    return false;
  }

  /* Basic email regex */
  const emailRegex = /^[A-Za-z0-9._+-]+@[A-Za-z0-9.-]+\.com$/;

  if (!emailRegex.test(user_email)) {
    alert("Enter a valid email (example: name@example.com)");
    return false;
  }

  /* Check if phone number is empty */
  if (user_phone.length === 0) {
    alert("Phone number cannot be empty");
    return false;
  }

  /* Check if phone number is valid (10-15 digits) */
  const phoneRegex = /^[0-9]{10,15}$/;

  if (!phoneRegex.test(user_phone)) {
    alert("Enter a valid phone number (10-15 digits)");
    return false;
  }

  /* Check if password is empty */
  if (user_password.length === 0) {
    alert("Password cannot be empty");
    return false;
  }

  /* Check if password is at least 6 chars */
  if (user_password.length < 6) {
    alert("Password must be at least 6 characters long");
    return false;
  }

  /* Check if confirm password is empty */
  if (user_confirmPassword.length === 0) {
    alert("Please confirm your password");
    return false;
  }

  /* Check if passwords match */
  if (user_password !== user_confirmPassword) {
    alert("Passwords do not match");
    return false;
  }

  /* Check if terms and conditions are accepted */
  if (!termsCheckbox.checked) {
    alert("Please agree to the Terms & Conditions");
    return false;
  }

  return true; /* Validation passed */
}

document.getElementById("SignupBtn").addEventListener("click", () => {
  if (validateSignup()) {
    /* Submit the form if validation passes */
    document.getElementById("SignupForm").submit();
  }
});