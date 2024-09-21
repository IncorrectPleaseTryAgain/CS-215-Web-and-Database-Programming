var fname = document.getElementById("fname");
var lname = document.getElementById("lname");
var uname = document.getElementById("username");
var pwd = document.getElementById("password");
var cpwd = document.getElementById("cpassword");
var dob = document.getElementById("dob");
var avatar = document.getElementById("profilephoto");

fname.addEventListener("blur", fNameHandler);
lname.addEventListener("blur", lNameHandler);
uname.addEventListener("blur", usernameHandler);
pwd.addEventListener("blur", pwdHandler);
cpwd.addEventListener("blur", cpwdHandler);
dob.addEventListener("blur", dobHandler);
avatar.addEventListener("blur", avatarHandler);