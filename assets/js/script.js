const daysEl = document.getElementById('days');
const hoursEl = document.getElementById('hours');
const minsEl = document.getElementById('mins');
const secondsEl = document.getElementById('seconds');
const daysPlayoffs = '15 april 2023';

function countdown() {

    const daysplayoffsdate = new Date(daysPlayoffs);

    const currentdate = new Date();

    const totalseconds = (daysplayoffsdate - currentdate) / 1000;

    const days = Math.floor (totalseconds / 3600 / 24);
    const hours = Math.floor (totalseconds / 3600) % 24;
    const mins = Math.floor(totalseconds / 60) % 60;
    const seconds = Math.floor (totalseconds)  % 60 ;

    daysEl.innerHTML = days;
    hoursEl.innerHTML = hours;
    minsEl.innerHTML = mins;
    secondsEl.innerHTML = seconds;

    // console.log(days, hours, mins, seconds);
}
countdown();

setInterval(countdown, 1000);



