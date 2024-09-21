function validateName(name) {
	var nameRegEx = /^[a-zA-Z]+$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validateDOB(dob) {
	// yyyy-mm-dd
	var dobRegEx = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobRegEx.test(dob))
		return true;
	else
		return false;
}
function validateAvatar(avatar) {

	var avatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;

}
function validateUsername(uname) {

	var unameRegEx = /^[a-zA-Z0-9_]+$/;
	if (unameRegEx.test(uname))
		return true;
	else
		return false;
}


function validateLogin(event) {

	var uname = document.getElementById("username");
	var pwd = document.getElementById("password");
	var flag = true;

	if (!validateUsername(uname.value)) {
		document.getElementById(uname.id).classList.add("input-error");
		document.getElementById("error-text-" + uname.id).classList.remove("hidden");
		flag = false;
	}
	else {
		document.getElementById(uname.id).classList.remove("input-error");
		document.getElementById("error-text-" + uname.id).classList.add("hidden");
	}
	if (pwd.value.length !== 8) {
		document.getElementById(pwd.id).classList.add("input-error");
		document.getElementById("error-text-" + pwd.id).classList.remove("hidden");
		flag = false;
	}
	else {
		document.getElementById(pwd.id).classList.remove("input-error");
		document.getElementById("error-text-" + pwd.id).classList.add("hidden");
	}

	if (flag === false)
		event.preventDefault();
	else
		console.log("validation successfull, sending data to the server");
}

function fNameHandler(event){
	var fname = event.target;
	if(!validateName(fname.value)){
		console.log("'" + fname.value + "' is not a valid first name");
	}
}
function lNameHandler(event){
	var lname = event.target;
	if (!validateName(lname.value)) {
		console.log("'" + lname.value + "' is not a valid last name");
	}
}

function usernameHandler(event){
	var uname = event.target;
	if (!validateUsername(uname.value)) {
		// console.log("'" + uname.value + "' is not a valid username");
		document.getElementById(uname.id).classList.add("input-error");
		document.getElementById("error-text-" + uname.id).classList.remove("hidden");
	} 
	else {
		document.getElementById(uname.id).classList.remove("input-error");
		document.getElementById("error-text-" + uname.id).classList.add("hidden");
	}
}
function pwdHandler(event){
	var pwd = event.target;
	if (pwd.value.length !== 8) {
		console.log("Password should be exactly 8 characters long");
	}
}
function cpwdHandler(event){
	var pwd = document.getElementById("password");
	var cpwd = event.target;
	if (pwd.value !== cpwd.value) {
		console.log("Your passwords: " + pwd.value + " and " + cpwd.value + " do not match");
	}
}
function dobHandler(event){
	var dob = event.target;
	if (!validateDOB(dob.value)) {
		//console.log("'" + dob.value + "' is not a valid date of birth");
		document.getElementById(dob.id).classList.add("input-error");
		document.getElementById("error-text-" + dob.id).classList.remove("hidden");
	}
	else {
		document.getElementById(dob.id).classList.remove("input-error");
		document.getElementById("error-text-" + dob.id).classList.add("hidden");
	}
}
function avatarHandler(event){
	var avatar = event.target;
	if (!validateAvatar(avatar.value)) {
		console.log("'" + avatar.value + "' is not a valid avatar");
		flag = false;
	}
}