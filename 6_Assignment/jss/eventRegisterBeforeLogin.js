const loginForm = document.getElementById("login-form");
loginForm.addEventListener("submit", validateLogin);

const togglePwd = document.getElementById("sidebar-card-show-password");
togglePwd.addEventListener("change", togglePwdVisibility);