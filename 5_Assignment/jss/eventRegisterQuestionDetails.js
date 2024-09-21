const aTitle = document.getElementById("answer-title");
aTitle.addEventListener("input", answerTitleHandler);

const aContent = document.getElementById("answer-content");
aContent.addEventListener("input", answerContentHandler);

const aCreationForm = document.getElementById("answer-form");
aCreationForm.addEventListener("submit", validateAnswerCreation);