const qCreation =  document.getElementById("input-question-creation");
qCreation.addEventListener("input", inputQuestionCreationHandler);

const qCreationForm = document.getElementById("question-creation-form");
qCreationForm.addEventListener("submit", validateQuestionCreation)