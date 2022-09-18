const sign_up=document.querySelector("#sign-up")
const bagrcol=document.querySelector(".main-page")
const sign_in=document.querySelector("#sign-in")
const up_pop=document.querySelector("#up-pop")
const popup_esc=document.querySelector("#essc")
const in_pop=document.querySelector("#in-pop")
const popin_esc=document.querySelector("#escc")

// EVENT LISTNERS FOR SIGN IN / SIGN UP BUTTONS
sign_in.addEventListener("click", signinbtn)
sign_up.addEventListener("click", signupbtn)

function signinbtn(event){
    bagrcol.classList.add("back")
    in_pop.classList.add("pop")
    sign_up.removeEventListener("click", signupbtn)
    sign_in.removeEventListener("click", signinbtn)
    event.stopPropagation();
    let resetbtn = (e) => {
        if(e.isTrusted || e.key == "Escape"){
            bagrcol.classList.remove("back")
            in_pop.classList.remove("pop")
            sign_in.addEventListener("click", signinbtn)
            sign_up.addEventListener("click", signupbtn)
            popin_esc.removeEventListener("click", resetbtn)
            window.removeEventListener('keydown', resetbtn)
        }
    }
    popin_esc.addEventListener("click", resetbtn)
    window.addEventListener('keydown', resetbtn)
    document.getElementById("main").addEventListener('click', resetbtn)
    //Checking if user/pass are correct for sign in and getting input value
    document.getElementById("login").addEventListener('click', function(){
        let username = document.getElementById("user").value;
        let password = document.getElementById("pass").value;
        (async() => {
            await signin(username, password)
            .then(results => {
                if(results["success"]){
                    console.log("hi")
                    localStorage.setItem("username", "houssam619");
                }
                else{
                    console.log("what")
                }
            })
        })();
    })
}

function signupbtn(event){
    bagrcol.classList.add("back")
    up_pop.classList.add("pop")
    sign_up.removeEventListener("click", signupbtn)
    sign_in.removeEventListener("click", signinbtn)
    event.stopPropagation();
    let resetbtn = (e) => {
        if(e.isTrusted || e.key == "Escape"){
            bagrcol.classList.remove("back")
            up_pop.classList.remove("pop")
            sign_in.addEventListener("click", signinbtn)
            sign_up.addEventListener("click", signupbtn)
            popup_esc.removeEventListener("click", resetbtn)
            window.removeEventListener('keydown', resetbtn)
            document.getElementById("main").removeEventListener('click', resetbtn)
        }
    }
    popup_esc.addEventListener("click", resetbtn)
    window.addEventListener('keydown', resetbtn)
    document.getElementById("main").addEventListener('click', resetbtn)
      
      $('#menucontainer').click(function(event){
        event.stopPropagation();
      });
    //Signing up
    document.getElementById("signup").addEventListener('click', function(){
        let username = document.getElementById("signup-username").value;
        let email = document.getElementById("signup-email").value;
        let password = document.getElementById("signup-password").value;
        (async() => {
            await signup(username, password, email)
            .then(results => {
                if(results["success"]){
                    console.log("created your username")
                    localStorage.setItem("username", "houssam619");
                }
                else{
                    console.log("what")
                }
            })
        })();
    })
}