const qReply = document.getElementById("input-question-reply");
qReply.addEventListener("input", inputQuestionReplyHandler);

const qReplyForm = document.getElementById("question-reply-form");
qReplyForm.addEventListener("submit", validateQuestionReply)