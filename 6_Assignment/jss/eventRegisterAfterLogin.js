const questions = document.querySelectorAll(".question-card");

questions.forEach(q => {
    q.addEventListener("click", selectQuestionHandler);
});