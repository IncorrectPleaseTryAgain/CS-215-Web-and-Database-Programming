//	Write the common validator functions first. 
//	Make sure you use regular expressions.
//	Use the RegEx test() method to validate a string with a RegEx.
//	Below is example of a validator function to valid the fist and last name fields.

function validateName(name) {
	let nameRegEx = /^[a-zA-Z]{1,50}$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

// Todo 5: Write validator functions to validate password, date of birth, avatar, and username
function validateUsername(uname){
	const unameRegEx = /^[a-zA-Z0-9_]{1,25}$/;

	if(unameRegEx.test(uname))
		return true;
	else
		return false;
}

function validatePassowrd(password){
	const passwordRegEx = /^[a-zA-Z0-9_#!]{8}$/

	if(passwordRegEx.test(password))
		return true;
	else
		return false;
}

function validateDOB(dob){
	const dobRegEx =  /^\d{4}[-]\d{2}[-]\d{2}$/;

	if(dobRegEx.test(dob))
		return true;
	else	
		return false;
}

function validateAvatar(avatar){
	if(avatar == false)
		return false;
	else
		return true;
}

// Todo 6a: Add an event object to this validateLogin function.
function validateLogin(event) {
	console.log("------------------VALIDATING LOGIN----------------------");

	// Use getElementById() to access the login form's input elements
	// and store them in easy to remember variables.
	// The first one is done for you as an example.
	let uname = document.getElementById("uname");

	// Todo 6b: Add your code to access and store the password input field.
	let password = document.getElementById("password");


	let formIsValid = true;

	if (!validateUsername(uname.value)) {

		console.log("'" + uname.value + "' is not a valid username");
		console.log("Username Requirements:");
		console.log("                     - Must be 1-25 characters long");
		console.log("                     - Characters include a-z, A-Z, 0-9, _");
		formIsValid = false;
	}

	// Todo 6c: You have to perform the validation for the password field.

	if(!validatePassowrd(password.value)){
		console.log("'" + password.value + "' is not a valid password");
		console.log("Password Requirements:");
		console.log("                     - Must be 8 characters long");
		console.log("                     - Characters include a-z, A-Z, 0-9, _, #, !");
		formIsValid = false;
	}

	if (formIsValid === false) {
		// Todo 6d: If any of the validations fail, we need to stop the form submission.
		// Use event.preventDefault() to stop the form submission.
		event.preventDefault();
	
	}
	else {
		console.log("validation successful, sending data to the server");
	}
}

function validateSignup(event){
	console.log("------------------VALIDATING SIGNUP----------------------");

	let fname = document.getElementById("fname");
	let lname = document.getElementById("lname");
	let pwd = document.getElementById("password");
	let cpwd = document.getElementById("cpassword");
	let avatar = document.getElementById("profilephoto");
	let uname = document.getElementById("uname");
	let dob = document.getElementById("dob");

	let signupSuccess = true;

	// can refacter to make use for handlers so no need for double checking

	if(!validateName(fname.value))
		signupSuccess = false;
	if(!validateName(lname.value))
		signupSuccess = false;
	if(!validatePassowrd(pwd.value))
		signupSuccess = false;
	if(pwd.value !== cpwd.value)
		signupSuccess = false;
	if(!validateAvatar(avatar.value))
		signupSuccess  = false;
	if(!validateUsername(uname.value))
		signupSuccess = false;
	if(!validateDOB(dob.value))
		signupSuccess = false;

	if(!signupSuccess){
		console.log("Invalid Data Provided - Please Double Check Inputs")
		event.preventDefault();
	}
}

function fNameHandler(event) {
	let fname = event.target;

	// Todo 8a Add code to validate first name field. 
	//         Use console.log() to write error messages on the console.
	//         Hint: Call the name validator function.

	if(!validateName(fname.value))
		console.log("'" + fname.value + "' is not a valid first name");
}

function lNameHandler(event) {
	let lname = event.target;
	
	// Todo 8b: Add code to validate last name field. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the name validator function.
	if(!validateName(lname.value))
		console.log("'" + lname.value + "' is not a valid last name");
}

function pwdHandler(event) {
	let pwd = event.target;
	 
	// Todo 8c: Add code to validate the password fields. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the password validator function
	if(!validatePassowrd(pwd.value))
		console.log("'" + pwd.value + "' is not a valid password");
}

function cpwdHandler(event) {
	let pwd = document.getElementById("password");
	let cpwd = event.target;
	// Todo 8d: Add code to check if the password and confirm password fields match.
	//          Use console.log() to write error messages on the console.

	if(pwd.value !== cpwd.value)
		console.log("Passwords do not match");
}

function avatarHandler(event) {
	let avatar = event.target;

	// Todo 8e: Add code to validate the avatar field. 
	//          Use console.log() to write error messages on the console.
	//          Hint: Call the avatar validator function.

	if(!validateAvatar(avatar.value))
		console.log("Please provide an avatar");
}

// Todo 9a: Create an event handler to validate the username field.
function uNameHandler(event){
	let uname = event.target;

	if(!validateUsername(uname.value))
		console.log("'" + uname.value + "' is not a valid username");
}

// Todo 9b: Create an event handler to validate the date of birth field.
function dobHandler(event){
	const dob = event.target;

	if(!validateDOB(dob.value))
		console.log("'" + dob.value + "' is not a valid date of birth");
}
