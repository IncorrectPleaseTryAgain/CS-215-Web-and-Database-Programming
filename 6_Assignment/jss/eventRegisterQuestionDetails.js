const aTitle = document.getElementById("answer-title");
aTitle.addEventListener("input", answerTitleHandler);

const aContent = document.getElementById("answer-content");
aContent.addEventListener("input", answerContentHandler);

const aCreationForm = document.getElementById("answer-form");
aCreationForm.addEventListener("submit", validateAnswerCreation);

const voteUp = document.querySelectorAll(".vote-btn-up");
voteUp.forEach(vtu => {
    vtu.addEventListener("click", voteUpHandler);
});

const voteDown = document.querySelectorAll(".vote-btn-down");
voteDown.forEach(vtd => {
    vtd.addEventListener("click", voteDownHandler);
});