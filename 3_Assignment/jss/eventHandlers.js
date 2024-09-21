const errMsgEmptField = "Field Cannot Be Empty";
const maxCharacterCount = 1500;

/* VALIDATORS */
function validateUsername(uname){
    const unameRegExp = /^[a-zA-Z0-9@#_-]{1,25}$/;
    const unameRules = "1-25 Characters [a-z A-Z 0-9 @ # _ -]";

    if(uname.length === 0){
        return errMsgEmptField;
    }

    if(unameRegExp.test(uname)){
        return true;
    }
    else{
        return unameRules;
    }

}

function validateEmail(email){
    const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    const emailRules = "name@domain";

    if(email.length === 0){
        return errMsgEmptField;
    }

    if(emailRegExp.test(email)){
        return true;
    }
    else{
        return "Invalid Email: " + emailRules;
    }
}

function validatePassword(pwd){
    const pwdRegExp = /^[a-zA-Z0-9@#_!]{8,13}$/;
    const pwdRules = "8-13 Characters [a-z A-Z 0-9 @ # _ !]";

    if(pwd.length === 0){
        return errMsgEmptField;
    }

    if(pwdRegExp.test(pwd)){
        return true;
    }
    else{
        return pwdRules;
    }
}

function validateConfirmPassword(cpwd){
    const pwd = document.getElementById("input-password").value;

    if(cpwd.length === 0){
        return errMsgEmptField;
    }

    if(cpwd === pwd){
        return true;
    }
    else{
        return "Passwords Do Not Match";
    }
}

function validateDateOfBirth(dob){
    if(dob){
        return true;
    }
    else{
        return errMsgEmptField;
    }
}

function validateAvatar(avatar){
    if(avatar){
        return true;
    }
    else{
        return errMsgEmptField;
    }
}

function validateCharacterCount(count){
    if(count > maxCharacterCount || count === 0){
        return false;
    } else{
        return true;
    }
}

/* HANDLERS */
function usernameHandler(event){
    let uname = event.target;
    let errMsgUname= document.getElementById("err-msg-username");
    
    const validResult = validateUsername(uname.value);
    
    if(validResult === true){
        uname.classList.remove("red-border");
        errMsgUname.classList.add("hidden");
    }
    else{
        errMsgUname.innerHTML = validResult;

        uname.classList.add("red-border");
        errMsgUname.classList.remove("hidden");
    }
}

function emailHandler(event){
    let email = event.target;
    let errMsgEmail= document.getElementById("err-msg-email");
    
    const validResult = validateEmail(email.value);
    
    if(validResult === true){
        email.classList.remove("red-border");
        errMsgEmail.classList.add("hidden");
    }
    else{
        errMsgEmail.innerHTML = validResult;

        email.classList.add("red-border");
        errMsgEmail.classList.remove("hidden");
    }
}

function passwordHandler(event){
    let pwd = event.target;
    let errMsgPwd= document.getElementById("err-msg-password");
    
    const validResult = validatePassword(pwd.value);
    
    if(validResult === true){
        pwd.classList.remove("red-border");
        errMsgPwd.classList.add("hidden");
    }
    else{
        errMsgPwd.innerHTML = validResult;

        pwd.classList.add("red-border");
        errMsgPwd.classList.remove("hidden");
    }
}

function confirmPasswordHandler(event){
    let cpwd = event.target;
    let errMsgCpwd= document.getElementById("err-msg-confirm-password");
    
    const validResult = validateConfirmPassword(cpwd.value);
    
    if(validResult === true){
        cpwd.classList.remove("red-border");
        errMsgCpwd.classList.add("hidden");
    }
    else{
        errMsgCpwd.innerHTML = validResult;

        cpwd.classList.add("red-border");
        errMsgCpwd.classList.remove("hidden");
    }
}

function dateOfBirthHandler(event){
    let dob = event.target;
    let errMsgDOB= document.getElementById("err-msg-dob");

    const validResult = validateDateOfBirth(dob.value);

	if (validResult === true) {	
		dob.classList.remove("red-border");
		errMsgDOB.classList.add("hidden");
	} 
	else {
        errMsgDOB.innerHTML = validResult;

		dob.classList.add("red-border");
		errMsgDOB.classList.remove("hidden");
	}
}

function avatarhHandler(event){
    let avatar = event.target;
    let errMsgAvatar= document.getElementById("err-msg-avatar");

    const validResult = validateAvatar(avatar.value);

	if (validResult === true) {	
		avatar.classList.remove("red-border");
		errMsgAvatar.classList.add("hidden");
	} 
	else {
        errMsgAvatar.innerHTML = validResult;
        
		avatar.classList.add("red-border");
		errMsgAvatar.classList.remove("hidden");
	}
}

function inputQuestionReplyHandler(event){
    let countElement = document.getElementById("question-reply-character-count");
    let count = event.target.value.length; 

    countElement.innerText = count + " / " + maxCharacterCount + " characters";

    if(validateCharacterCount(count)){
        countElement.classList.remove("color-red");
        countElement.classList.remove("red-underline");
    } else{
        countElement.classList.add("color-red");
    }
}

function inputQuestionCreationHandler(event){
    let countElement = document.getElementById("question-creation-character-count");
    let count = event.target.value.length; 

    countElement.innerText = count + " / " + maxCharacterCount + " characters";

    if(validateCharacterCount(count)){
        countElement.classList.remove("color-red");
        countElement.classList.remove("red-underline");
    } else{
        countElement.classList.add("color-red");
    }
}

// Main Page | Before Login
function validateLogin(event){
    console.log("*****VALIDATING LOGIN*****");

    let loginValid = true;

    let input = document.getElementById("input-email");
    let errMsg = document.getElementById("err-msg-email");
    let validResult = validateEmail(input.value);

    if(validResult === true){
        input.classList.remove("red-border");
        errMsg.classList.add("hidden");
    }
    else{
        errMsg.innerHTML = validResult;
        
        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        loginValid = false;
    }

    input = document.getElementById("input-password");
    errMsg = document.getElementById("err-msg-password");
    validResult = validatePassword(input.value);

    if(validResult === true){
        input.classList.remove("red-border");
        errMsg.classList.add("hidden");
    }
    else{
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        loginValid = false;
    }


    if(!loginValid){
        event.preventDefault();
    }
}

// Signup Page
function validateSignup(event){
    console.log("*****VALIDATING SIGNUP*****");

    let signupValid = true;

    let input = document.getElementById("input-username");
    let errMsg = document.getElementById("err-msg-username");
    let validResult = validateUsername(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        uname.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }

    input = document.getElementById("input-email");
    errMsg = document.getElementById("err-msg-email");
    validResult = validateEmail(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }

    input = document.getElementById("input-password");
    errMsg = document.getElementById("err-msg-password");
    validResult = validatePassword(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }

    input = document.getElementById("input-confirm-password");
    errMsg = document.getElementById("err-msg-confirm-password");
    validResult = validateConfirmPassword(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }

    input = document.getElementById("input-dob");
    errMsg = document.getElementById("err-msg-dob");
    validResult = validateDateOfBirth(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }

    input = document.getElementById("input-avatar");
    errMsg = document.getElementById("err-msg-avatar");
    validResult = validateAvatar(input.value);

    if(validResult !== true){
        errMsg.innerHTML = validResult;

        input.classList.add("red-border");
        errMsg.classList.remove("hidden");
        signupValid = false;
    }


    if(!signupValid){
        event.preventDefault();
    }
}

// Question Reply
function validateQuestionReply(event){
    console.log("*****VALIDATING QUESTION REPLY*****");

    let questionReplyValid = true;

    let qReply = document.getElementById("input-question-reply");
    let countElement = document.getElementById("question-reply-character-count");
    let count = qReply.value.length; 

    if(!validateCharacterCount(count)){
        countElement.classList.add("red-underline");
        questionReplyValid = false;
    }

    if(!questionReplyValid){
        event.preventDefault();
    }
}

// Question CREATION
function validateQuestionCreation(event){
    console.log("*****VALIDATING QUESTION CREATION*****");

    let questionCreationValid = true;

    let qCreation = document.getElementById("input-question-creation");
    let countElement = document.getElementById("question-creation-character-count");
    let count = qCreation.value.length; 

    if(!validateCharacterCount(count)){
        countElement.classList.add("red-underline");
        questionCreationValid = false;
    }

    if(!questionCreationValid){
        event.preventDefault();
    }
}