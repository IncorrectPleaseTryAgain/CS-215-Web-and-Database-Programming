// Todo 4: Add code to register a "submit" event on the login form, 
//         and assign an event handler.
//         Hint: use addEventListener() to register events.

let loginForm = document.getElementById("login-form");
loginForm.addEventListener("submit", validateLogin);