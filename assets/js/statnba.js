import axios from "axios";

const options = {
    method: 'GET',
    url: 'https://api-nba-v1.p.rapidapi.com/games',
    params: {h2h: '1-2'},
    headers: {
        'X-RapidAPI-Key': '43b3246837mshe5fe593bf3ed931p17bceajsn46e21a81c8f5',
        'X-RapidAPI-Host': 'api-nba-v1.p.rapidapi.com'
    }
};

// axios.request(options).then(function (response){
//     console.log(response.data.response[].league);
// }).catch(function(error){
//     console.log(error)
// })

axios.request(options).then(function (response) {
    let games = response.data.response;
    let output = '';
    for (let i = 0; i < 10; i++) {
        output +=
            `<div class="col-12 statistique">
                    <p> ${games[i].league} </p>
                    <p> ${games[i].season} </p>
                    <p> ${games[i].arena.city} </p>
                    <p> ${games[i].officials} </p>
                    <div class="score">
                        <div class="home">
                            <p> ${games[i].teams.home.name} </p>
                            <p> ${games[i].scores.home.points} </p>
                        </div>
                        <div class="visitors">
                            <p> ${games[i].teams.visitors.name} </p>
                            <p> ${games[i].scores.visitors.points} </p>
                        </div>
                    </div>    
            </div>`
    }
    document.getElementById('games').innerHTML = output;
    console.log(response.data.response)
}).catch(function (error) {
    console.error(error);
});