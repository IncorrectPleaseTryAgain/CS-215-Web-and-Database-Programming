const errMsgEmptField = "Field Cannot Be Empty";
const maxCharacterCount = 1500;

/* VALIDATORS */
function validateUsername(uname){
    const unameRegExp = /^[a-zA-Z0-9@#_-]{1,15}$/;
    const unameRules = "1-15 Characters [a-z A-Z 0-9 @ # _ -]";

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

function questionTitleHandler(event) {
    let qTitle = event.target;
    let input = qTitle.value.length;
    if(input >= 100){
        qTitle.classList.add("red-border");
    }
    else if(input !== 0){
        qTitle.classList.remove("red-border");
    }
}

function questionContentHandler(event){
    let qContent = event.target;
    let countElement = document.getElementById("question-character-count");
    let count = qContent.value.length; 

    countElement.innerText = count + " / " + maxCharacterCount + " characters";

    if(validateCharacterCount(count)){
        countElement.classList.remove("color-red");
        countElement.classList.remove("red-underline");
    } else{
        countElement.classList.add("color-red");
    }

    if(count !== 0){
        qContent.classList.remove("red-border");
    }
}

function answerTitleHandler(event) {
    let aTitle = event.target;
    let input = aTitle.value.length;
    if(input >= 100){
        aTitle.classList.add("red-border");
    }
    else if(input !== 0){
        aTitle.classList.remove("red-border");
    }
}

function answerContentHandler(event){
    let aContent = event.target;
    let countElement = document.getElementById("answer-character-count");
    let count = aContent.value.length; 

    countElement.innerText = count + " / " + maxCharacterCount + " characters";

    if(validateCharacterCount(count)){
        countElement.classList.remove("color-red");
        countElement.classList.remove("red-underline");
    } else{
        countElement.classList.add("color-red");
    }

    if(count !== 0){
        aContent.classList.remove("red-border");
    }
}

function selectQuestionHandler(event){
    let url = "../php/question-detail.php?qid=" + event.target.id;
    document.location.href = url;
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

// Answer Creation
function validateAnswerCreation(event){
    console.log("*****VALIDATING ANSWER CREATION*****");

    let answerCreationValid = true;

    let aTitle = document.getElementById("answer-title");
    let aContent = document.getElementById("answer-content");
    let countElement = document.getElementById("answer-character-count");
    let count = aContent.value.length; 

    if(!validateCharacterCount(count)){
        countElement.classList.add("red-underline");
        countElement.classList.add("color-red");
        answerCreationValid = false;
    }

    if(aTitle.value.length === 0 || aTitle.value.length >= 100){
        aTitle.classList.add("red-border");
        answerCreationValid = false;
    }

    if(aContent.value.length === 0){
        aContent.classList.add("red-border");
        answerCreationValid = false;
    }

    if(!answerCreationValid){
        event.preventDefault();
    }
}

// Question Creation
function validateQuestionCreation(event){
    console.log("*****VALIDATING QUESTION CREATION*****");

    let questionCreationValid = true;

    let qTitle = document.getElementById("question-title");
    let qContent = document.getElementById("question-content");
    let countElement = document.getElementById("question-character-count");
    let count = qContent.value.length; 

    if(!validateCharacterCount(count)){
        countElement.classList.add("red-underline");
        countElement.classList.add("color-red");
        questionCreationValid = false;
    }

    if(qTitle.value.length === 0 || qTitle.value.length >= 100){
        qTitle.classList.add("red-border");
        questionCreationValid = false;
    }

    if(qContent.value.length === 0 || qContent.value.length > maxCharacterCount){
        qContent.classList.add("red-border");
        questionCreationValid = false;
    }

    if(!questionCreationValid){
        event.preventDefault();
    }
}

// Toggle Password Visibility
function togglePwdVisibility(event){
    const pwdField = document.getElementById("input-password");

    if(pwdField.type == "password"){
        pwdField.type = "text";
    } else {
        pwdField.type = "password";
    }
}

// Vote Handlers
function voteUpHandler(event) {
    let xhttp = new XMLHttpRequest();
    
    // vote status for up vote '1', used for URL embedding
    const vs = "1";
    // get database answer id from current html answer id
    // used for URL embedding
    const aid = event.target.id.split("-")[1].trim();

    // file path for ajax request, with appropriate URL embeddings (vote status & answer id)
    const file = "includes/avote.inc.php?vs=" + vs + "&aid=" +  aid;

    xhttp.open("POST", file, true);
    
    xhttp.addEventListener("readystatechange", (e) => {

        // check ready state complete AND status successfull
        if(e.target.readyState == 4 && e.target.status == 200){
            
            const response = JSON.parse(xhttp.responseText);
            
            // check: user voting is allowed
            //      false: user trying to vote on own answer
            if(response){
                // id for vote status html element
                const vsid = "vs-" + this.id.split("-")[1].trim();
                // id for vote down html element
                const vtdid = "vtd-" + this.id.split("-")[1].trim();

                // set vote sum html element
                document.getElementById(vsid).innerHTML = response['vote-sum'];

                // remove red backgroud from down vote
                document.getElementById(vtdid).classList.remove("vote-active-red");

                // add or remove green background from up vote
                (response['vote-status'] == 0) ? this.classList.remove("vote-active-green") : this.classList.add("vote-active-green");
            }
        }
    });

    xhttp.send();
}

function voteDownHandler(event) {
    let xhttp = new XMLHttpRequest();
    
    // vote status for down vote '-1', used for URL embedding
    const vs = "-1";
    // get database answer id from current html answer id
    // used for URL embedding
    const aid = event.target.id.split("-")[1].trim();

    // file path for ajax request, with appropriate URL embeddings (vote status & answer id)
    const file = "includes/avote.inc.php?vs=" + vs + "&aid=" +  aid;

    xhttp.open("POST", file, true);
    
    xhttp.addEventListener("readystatechange", (e) => {

        // check ready state complete AND status successfull
        if(e.target.readyState == 4 && e.target.status == 200){
            
            const response = JSON.parse(xhttp.responseText);

            // check: user voting is allowed
            //      false: user trying to vote on own answer
            if(response){
                // id for vote status html element
                const vsid = "vs-" + this.id.split("-")[1].trim();
                // id for vote up html element
                const vtuid = "vtu-" + this.id.split("-")[1].trim();

                // set vote sum html element
                document.getElementById(vsid).innerHTML = response['vote-sum'];

                // remove green backgroud from up vote
                document.getElementById(vtuid).classList.remove("vote-active-green");

                // add or remove green background from up vote
                (response['vote-status'] == 0) ? this.classList.remove("vote-active-red") : this.classList.add("vote-active-red");
            }
        }
    });

    xhttp.send();
}