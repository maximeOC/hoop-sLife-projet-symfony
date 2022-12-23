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
//     console.log(response.data);
// }).catch(function(error){
//     console.log(error)
// })

axios.request(options).then(function (response) {
    let games = response.data.response;
    let output = '';
    for (let i = 0; i < 5; i++) {
        output +=
            `<table class="table">
                    <thead>
                        <tr>
                            <th>league</th>
                            <th>Année</th>
                            <th>les arbitres</th>
                            <th>Equipe à domicile</th>
                            <th>Equipe jouant à l'exterieur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>NBA</td>
                            <td>${games[i].season} </td>
                            <td>${games[i].officials} <br> </td>
                            <td>${games[i].teams.home.name} <br>
                            ${games[i].scores.home.points} points</td>
                            <td>${games[i].teams.visitors.name} <br>
                            ${games[i].scores.visitors.points} points </td>
                            </tr>
                    </tbody>
            </table>`
    }
    document.getElementById('games').innerHTML = output;
    console.log(response.data.response)
}).catch(function (error){
    console.error(error);
});