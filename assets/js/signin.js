//forumulaire de connexion

let form = document.getElementById('signup');

form.email.addEventListener('change', function(){
    validEmail(form.email);
});

form.password.addEventListener('input', () => validatePassword(form.password))
// form.confirm-password.addEventListener('paste', (e) => e.preventDefault())

function validEmail(inputemail) {
    let emailRegex = new RegExp(
        '^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$'
    )

    let testEmail = emailRegex.test(inputemail.value);
    let small = inputemail.nextElementSibling;

    if(testEmail){
        small.innerText ='adresse valide';
        small.style.color = 'green';

    }else{
        small.innerText = "adresse non valide";
        small.style.color = 'red';
    }

    if(inputemail.value === ''){
        small.innerText = 'veuiller renseigner un email'
    }

}

function validatePassword(inputPassword) {
    // let text ;
    const value = inputPassword.value;

    let smallps = inputPassword.nextElementSibling;

    if(value.length < 3 ){
        smallps.innerText = "le mot de passe doit faire plus de 3 caractères";
    }else if (!/[A-Z]/.test(value)){
        smallps.innerText ="le mot de passe doit contenir minimum 1 majuscule"
    }else if(!/[0-9]/.test(value)){
        smallps.innerText = "le mot de passe doit contenir au moins 1 chiffre";
    }else if (!/[&\.\\-_]/.test(value)){
        smallps.innerText ="le mot de passe doit contenir au moins un de ces 4 caractères spéciales, & , - , _ , . ";
    } else {
        text = "c'est bon !!";
        smallps.innerText = text
        smallps.style.color = "green"
    }

    if(value === ''){
        smallps.style.display = 'none'
    }else{
        smallps.style.display = 'block'
    }
}


let visible = true;

let svg = document.querySelector('.svg1')
let svg2 = document.querySelector('.svg2')
svg2.addEventListener('click', function change(){
    if(visible){
        document.getElementById('confirm-password').setAttribute("type", "text");
        visible = false
    }else{
        document.getElementById('confirm-password').setAttribute("type", "password");
        visible = true
    }
})
svg.addEventListener('click', function change(){
    if(visible){
        document.getElementById('password').setAttribute("type", "text");
        visible = false
    }else{
        document.getElementById('password').setAttribute("type", "password");
        visible = true
    }
})


let confirmPs = document.getElementById('confirm-password');

function checkPassword(){
    if(password.value === confirmPs.value){
        console.log("oui");
    }
}
checkPassword()