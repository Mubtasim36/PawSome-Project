const passwordInput = document.getElementById("npass");
const cpasswordInput = document.getElementById("cpass");
const togglePassword = document.getElementById("togglePassword");
const toggleCPassword = document.getElementById("toggleCPassword");

/*for new password toggle*/
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

/*for confirm password toggle*/

toggleCPassword.addEventListener("click", () => {
  const isHidden =
    cpasswordInput.type === "password"; /* Checking password is hidden */
  /* Toggle input type using if-else  */
  if (isHidden) {
    cpasswordInput.type = "text"; /* Show password */
    toggleCPassword.textContent = "visibility"; /* Open eye icon */
  } else {
    cpasswordInput.type = "password"; /* Hide password */
    toggleCPassword.textContent = "visibility_off"; /* Closed eye icon  */
  }
});

function validateLogin() {
  const user_password =
    passwordInput.value.trim(); /*document.getElementById("npass") not used as it is already defined*/
  const user_cpassword =
    cpasswordInput.value.trim(); /*document.getElementById("cpass") not used as it is already defined*/

  /* Check if empty */
  if (user_password.length === 0) {
    alert("New Password cannot be empty");
    return false;
  }

  /* Check if password is empty */
  if (user_cpassword.length === 0) {
    alert("Confirm Password cannot be empty");
    return false;
  }
  /* Check if password is atleast 6 chars */
  if (user_password.length < 6) {
    alert("Password must be at least 6 characters long");
    return false;
  }

  /* Check if passwords match */
  if (user_password !== user_cpassword) {
    alert("Passwords do not match");
    return false;
  }
  return true; /* Validation passed */
}

document.getElementById("ChangeBtn").addEventListener("click", () => {
  if (validateLogin()) {
    alert("Password changed successfully!");

    // redirect to login page after alert
    window.location.href = "login.html";
  }
});
