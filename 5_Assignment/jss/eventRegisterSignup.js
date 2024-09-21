
const uname = document.getElementById("input-username");
uname.addEventListener("blur", usernameHandler);

const email = document.getElementById("input-email");
email.addEventListener("blur", emailHandler);

const pwd = document.getElementById("input-password");
pwd.addEventListener("blur", passwordHandler);

const cpwd = document.getElementById("input-confirm-password");
cpwd.addEventListener("blur", confirmPasswordHandler);

const dob = document.getElementById("input-dob");
dob.addEventListener("blur", dateOfBirthHandler);

const avatar = document.getElementById("input-avatar");
avatar.addEventListener("blur", avatarhHandler);

const signupForm = document.getElementById("signup-form");
signupForm.addEventListener("submit", validateSignup);