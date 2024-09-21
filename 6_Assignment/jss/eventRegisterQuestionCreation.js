const qTitle=  document.getElementById("question-title");
qTitle.addEventListener("input", questionTitleHandler);

const qContent=  document.getElementById("question-content");
qContent.addEventListener("input", questionContentHandler);

const qCreationForm = document.getElementById("question-creation-form");
qCreationForm.addEventListener("submit", validateQuestionCreation)