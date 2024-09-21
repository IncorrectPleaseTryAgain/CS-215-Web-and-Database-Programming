function validateName(name) {
	let nameRegEx = /^[a-zA-Z]+$/;

	if (nameRegEx.test(name))
		return true;
	else
		return false;
}

function validatePWD(pwd) {
	if (pwd.length === 8)
		return true;
	else
		return false;
}
function validateDOB(dob) {
	// yyyy-mm-dd
	let dobRegEx = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobRegEx.test(dob))
		return true;
	else
		return false;
}
function validateAvatar(avatar) {

	let avatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;

}
function validateUsername(uname) {

	let unameRegEx = /^[a-zA-Z0-9_]+$/;
	if (unameRegEx.test(uname))
		return true;
	else
		return false;
}


function validateLogin(event) {

	let uname = document.getElementById("username");
	let pwd = document.getElementById("password");
	let formIsValid = true;

	if (!validateUsername(uname.value)) {
		//	Todo 7a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		uname.classList.add("red-border");

		//	Todo 7c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		let errorMsg = document.getElementById("error-text-username");
		errorMsg.classList.remove("hidden");
		formIsValid = false;
	} 
	//	An else block to remove the error messages and the styles when the input field passes the validation 
	else {
		
		//	Todo 7b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		uname.classList.remove("red-border");

		//	Todo 7d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		let errorMsg = document.getElementById("error-text-username");
		errorMsg.classList.add("hidden");

	}
	if (!validatePWD(pwd.value)) {
		//	Todo 7a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.	
		pwd.classList.add("red-border");

		//	Todo 7c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		let errorMsg = document.getElementById("error-text-password");
		errorMsg.classList.remove("hidden");
		formIsValid = false;
	} 
	//	An else block to remove the error messages and the styles when the input field passes the validation 
	else {
			
		//	Todo 7b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		pwd.classList.remove("red-border");

		//	Todo 7d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		let errorMsg = document.getElementById("error-text-password");
		errorMsg.classList.add("hidden");
	}

	if (!formIsValid) {
		event.preventDefault();
	} else {
		console.log("Validation successful, sending data to the server");
	}
}

function fNameHandler(event){
	let fname = event.target;
	if(!validateName(fname.value)){
		fname.classList.add("red-border");

		let errorMsg = document.getElementById("error-text-fname");
		errorMsg.classList.remove("hidden");

		console.log("'" + fname.value + "' is not a valid first name");
	}
	else{
		fname.classList.remove("red-border");

		let errorMsg = document.getElementById("error-text-fname");
		errorMsg.classList.add("hidden");
	}
}
function lNameHandler(event){
	let lname = event.target;
	if (!validateName(lname.value)) {
		lname.classList.add("red-border");

		let errorMsg = document.getElementById("error-text-lname");
		errorMsg.classList.remove("hidden");

		console.log("'" + lname.value + "' is not a valid last name");
	}
	else{
		lname.classList.remove("red-border");

		let errorMsg = document.getElementById("error-text-lname");
		errorMsg.classList.add("hidden");
	}
}

function usernameHandler(event){
	let uname = event.target;
	if (!validateUsername(uname.value)) {

		// Comment the line below
		console.log("'" + uname.value + "' is not a valid username");
		//	Todo 8a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.
		uname.classList.add("red-border");	

		//	Todo 8c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		let errorMsg = document.getElementById("error-text-username");
		errorMsg.classList.remove("hidden");
	} 
	else {
			
		//	Todo 8b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box.
		uname.classList.remove("red-border");	 

		//	Todo 8d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		let errorMsg = document.getElementById("error-text-username");
		errorMsg.classList.add("hidden");
	}
}
function pwdHandler(event){
	let pwd = event.target;
	if (!validatePWD(pwd.value)) {
		pwd.classList.add("red-border");

		let errorMsg = document.getElementById("error-text-password");
		errorMsg.classList.remove("hidden");

		console.log("Password should be exactly 8 characters long");
	}
	else{
		pwd.classList.remove("red-border");

		let errorMsg = document.getElementById("error-text-password");
		errorMsg.classList.add("hidden");
	}
}
function cpwdHandler(event){
	let pwd = document.getElementById("password");
	let cpwd = event.target;
	if (pwd.value !== cpwd.value) {
		cpwd.classList.add("red-border");

		let errorMsg = document.getElementById("error-text-cpassword");
		errorMsg.classList.remove("hidden");

		console.log("Your passwords: " + pwd.value + " and " + cpwd.value + " do not match");
	}
	else{
		cpwd.classList.remove("red-border");

		let errorMsg = document.getElementById("error-text-cpassword");
		errorMsg.classList.add("hidden");
	}
}
function dobHandler(event){
	let dob = event.target;
	if (!validateDOB(dob.value)) {
		
		// Comment the line below
		console.log("'" + dob.value + "' is not a valid date of birth");
		//	Todo 8a: ADD your code to dynamically add a class name to <input> tag to highlight the input box.
		dob.classList.add("red-border");		

		//	Todo 8c: ADD your code to dynamically remove a class name to <p> tag to show the error message.	
		let errorMsg = document.getElementById("error-text-dob");
		errorMsg.classList.remove("hidden");
	}
	else {
		//	Todo 8b: ADD your code to dynamically remove a class name from the <input> tag to remove the highlights from the input box. 
		dob.classList.remove("red-border");

		//	Todo 8d: ADD your code to dynamically add a class name from the <p> tag to hide the error message.	
		let errorMsg = document.getElementById("error-text-dob");
		errorMsg.classList.add("hidden");
	}
}
function avatarHandler(event){
	let avatar = event.target;
	if (!validateAvatar(avatar.value)) {
		console.log("'" + avatar.value + "' is not a valid avatar");
		flag = false;
	}
}