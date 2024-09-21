let randomNumber = Math.floor(Math.random() * 1000) + 1;
let curTurn = 1;
const maxTurns = 10;

const guessField = document.querySelector(".guess-field");
const guessSubmit =  document.querySelector(".guess-submit");

const numGuessRemaining = document.querySelector(".num-guess-remaining");

const guesses = document.querySelector(".guesses");
const result = document.querySelector(".result");
const lowHigh = document.querySelector(".low-high");

guessSubmit.addEventListener("click", checkGuess);

function setGameOver() {
    resetButton = document.createElement("button");
    resetButton.textContent = "Start new game";

    guessField.disabled = true;
    guessSubmit.disabled = true;
    
    document.body.append(resetButton);
    resetButton.addEventListener("click", resetGame);
}

function resetGame() {
    curTurn = 1;
  
    const feedbackWrapper = document.querySelectorAll(".feedback-wrapper p");
    for (const feedback of feedbackWrapper) {
        feedback.textContent = "";
    }
  
    resetButton.parentNode.removeChild(resetButton);
  
    guessField.disabled = false;
    guessSubmit.disabled = false;
    guessField.value = "";
    guessField.focus();
  
    result.style.backgroundColor = "white";
  
    randomNumber = Math.floor(Math.random() * 1000) + 1;

    numGuessRemaining.textContent = `*${maxTurns} remaining*`;
}  

function checkGuess(){
  
    const userGuess = Number(guessField.value);
    guesses.textContent += (userGuess + " ");

    if(curTurn === maxTurns){
        lowHigh.textContent = "";
        result.style.backgroundColor = "red";
        result.textContent = "You Lose!!!";
        setGameOver();
    }
    else if(userGuess < randomNumber){
        lowHigh.textContent = "Too Low";
    }
    else if(userGuess > randomNumber){
        lowHigh.textContent = "Too High";
    }
    else{
        lowHigh.textContent = "";
        result.style.backgroundColor = "green";
        result.textContent = "Correct!!!";
        setGameOver();
    }

    numGuessRemaining.textContent = `*${maxTurns - curTurn} remaining*`;
    guessField.value = "";
    guessField.focus();
    
    curTurn++;
}