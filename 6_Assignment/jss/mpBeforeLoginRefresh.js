// create html element from text
function elementFromHTML(html){
    const temp = document.createElement("template");
    temp.innerHTML = html.trim();
    return temp.content.firstElementChild;
}

// interval: load any new questions : 2min
const questionsInterval = setInterval(questionsRequest, 1000 * 60 * 2);
function questionsRequest(){
    let xhttp = new XMLHttpRequest();
    
    // question div html element, holds all of the questions inside
    let questionsElement =  document.getElementById("questions");

    // most recent question id
    const recentqid = questionsElement.firstElementChild.id;

    // number of questions limit
    const limit = "lim=5";

    // ajax request file
    const file = "../php/includes/qrefresh.inc.php?rqid=" + recentqid + "&" + limit;

    xhttp.open("POST", file, true);


    xhttp.addEventListener("readystatechange", (e) => {
        if(xhttp.readyState == 4 && e.target.status == 200){

            const response = JSON.parse(xhttp.responseText);

            // check: response has data
            if (Array.isArray(response) && response){

                // check: page is empty
                if(recentqid == "empty"){
                    questionsElement.removeChild(document.getElementById("empty"));
                }

                // for each response: remove old question AND add new question
                response.forEach(q => {

                    // check: question limit per page
                    if(questionsElement.childElementCount >= 5){
                        for(let i = questionsElement.childElementCount; i >= 5; i--){
                            // remove old question
                            questionsElement.removeChild(questionsElement.lastElementChild);
                        }
                    }

                    // create new question
                    const question = elementFromHTML(`
                        <section class="card question-card card-clickable" id="${q['question_id']}">
        
                        <div class="card-vote"></div>
        
                        <div class="qcard-body">
        
                            <header class="qcard-header">
        
                                <h3 class="qcard-title">${q['title']}</h3>
        
                                <div class="qcard-author">
                                    <p>${q['username']}</p>
                                    <a href="#"><img src="${q['profile_photo']}" alt="avatar" class="qcard-pfp"/></a>
                                </div>
        
                            </header>
        
                            <p class="qcard-question">${q['question']}</p>
        
                            <footer class="question-footer">
        
                                <p>${q['numAnswers']} Responses</p>
                                <p>${q['date_posted']}</p>
        
                            </footer>
        
                        </div>
        
                        </section>
                    `);
        
                    // add new question
                    questionsElement.prepend(question);
                });

            // check: page is empty but no empty html element
            } else if(!recentqid && !response){
                questionsElement.prepend(elementFromHTML("<h2 id='empty'>It's like a ghost town...👻</h2>"));
            }
        }
    });

    xhttp.send();
}