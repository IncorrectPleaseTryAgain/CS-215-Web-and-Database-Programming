// Register a change validator on first name field
let fname = document.getElementById("fname");
fname.addEventListener("blur", fNameHandler);

// Register a change validator on last name field
let lname = document.getElementById("lname");
lname.addEventListener("blur", lNameHandler);

// Register a change validator on password field
let pwd = document.getElementById("password");
pwd.addEventListener("blur", pwdHandler);

// Register a change validator on confirm password field
let cpwd = document.getElementById("cpassword");
cpwd.addEventListener("blur", cpwdHandler);

// Register a change validator on avatar image field
let avatar = document.getElementById("profilephoto");
avatar.addEventListener("blur", avatarHandler);

// Todo 7: Add code to register "blur" event validators on these input fields. 
//          - username
//          - date of birth
//         Hint: use addEventListener() to register events.
//         Hint: for Todo 9, you will write the validator functions in eventHandlers.js
let uname = document.getElementById("uname");
uname.addEventListener("blur", uNameHandler);

let dob = document.getElementById("dob");
dob.addEventListener("blur", dobHandler);

let signupForm = document.getElementById("signup-form");

signupForm.addEventListener("submit", validateSignup);
