// create html element from text
function elementFromHTML(html){
    const temp = document.createElement("template");
    temp.innerHTML = html.trim();
    return temp.content.firstElementChild;
}

// interval: load any new answers : 2min
const answersInterval = setInterval(answersRequest, 1000 * 60 * 2);
function answersRequest(){
    // console.log("INTERVAL");

    let xhttp = new XMLHttpRequest();
    
    // answers div html element, holds all of the answers inside
    let answersElement =  document.getElementById("answers");

    
    
    // most recent answer id
    const qid = document.getElementsByName("question")[0].id;
    let recentaid = answersElement.firstElementChild.id; //format: any
    if(answersElement.firstElementChild.id != "empty"){
        recentaid = recentaid.split("-")[1].trim(); //format: id number only
    }
    
    // console.log("answersElement.firstElementChild.id: " + answersElement.firstElementChild.id);
    // console.log("answersElement.firstElementChild.id.split('-')[1].trim(): " + answersElement.firstElementChild.id.split("-")[1].trim());

    // ajax request file
    const file = "../php/includes/arefresh.inc.php?raid=" + recentaid + "&qid=" + qid;

    xhttp.open("POST", file, true);


    xhttp.addEventListener("readystatechange", (e) => {
        if(xhttp.readyState == 4 && e.target.status == 200){

            const response = JSON.parse(xhttp.responseText);
            // console.log("RESPONSE: " + response);

            // check: response has data
            if (Array.isArray(response) && response){

                // check: page is empty
                if(recentaid == "empty"){
                    answersElement.removeChild(document.getElementById("empty"));
                }

                // for each response: add new answer
                response.forEach(a => {

                    // check if answer already on page
                    if(a['answer_id'] <= recentaid){
                        document.getElementById(`vs-${a['answer_id']}`).innerHTML = a['numVotes'];
                    } else {
                        // create new answer
                        const answer = elementFromHTML(`
                            <sections class="card answer-card" id="aid-${a['answer_id']}">
                                <div class="card-vote-active">

                                    <input type="image" id="vtu-${a['answer_id']}" src="../images/vote/30-arrow-up.png" alt="UP" class="vote-btn vote-btn-up">

                                    <p class="comment-vote-num" id="vs-${a['answer_id']}">0</p>

                                    <input type="image" id="vtd-${a['answer_id']}" src="../images/vote/30-arrow-down.png" alt="DOWN" class="vote-btn vote-btn-down">

                                </div>

                                <div class="qcard-body">
                                
                                <header class="qcard-header">

                                    <h3 class="acard-title">${a['title']}</h3>

                                    <div class="qcard-author">
                                        <p>${a['username']}</p>
                                        <img src="${a['profile_photo']}" alt="avatar" class="qcard-pfp"/>
                                    </div>

                                </header>

                                <p class="acard-question">${a['answer']}</p>

                                <footer>
                                    <p>${a['date_posted']}</p>
                                </footer>

                                </div>
                        </sections>
                        `);
            
                        // add new answer
                        answersElement.prepend(answer);
                        document.getElementById(`vtu-${a['answer_id']}`).addEventListener("click", voteUpHandler);
                        document.getElementById(`vtd-${a['answer_id']}`).addEventListener("click", voteDownHandler);

                        document.getElementById(`aid-${a['answer_id']}`).classList.add("new-post");

                        setTimeout(() => {
                            document.getElementById(`aid-${a['answer_id']}`).classList.remove("new-post");
                        }, 1000 * 5);
                    }
                });

            // check: page is empty but no empty html element
            } else if(!recentaid && !response){
                answersElement.prepend(elementFromHTML("<h2 id='empty'>It's like a ghost town...👻</h2>"));
            }
        }
    });

    xhttp.send();
}