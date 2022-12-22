import axios from "axios";

const options = {
    method: 'GET',
    url: 'https://api-nba-v1.p.rapidapi.com/seasons',
    headers: {
        'X-RapidAPI-Key': '43b3246837mshe5fe593bf3ed931p17bceajsn46e21a81c8f5',
        'X-RapidAPI-Host': 'api-nba-v1.p.rapidapi.com'
    }
};

axios.request(options).then(function (response) {
    console.log(response.data);
}).catch(function (error) {
    console.error(error);
});