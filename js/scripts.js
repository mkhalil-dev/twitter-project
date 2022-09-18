const sign_up=document.querySelector("#sign-up")
const bagrcol=document.querySelector(".main-page")
const sign_in=document.querySelector("#sign-in")
const up_pop=document.querySelector("#up-pop")
const popup_esc=document.querySelector("#essc")
const in_pop=document.querySelector("#in-pop")
const popin_esc=document.querySelector("#escc")

// EVENT LISTNERS FOR SIGN IN / SIGN UP BUTTONS

loginpage()
function loginpage(){
    sign_in.addEventListener("click", signinbtn)
    sign_up.addEventListener("click", signupbtn)

    function signinbtn(event){
        bagrcol.classList.add("back")
        in_pop.classList.add("pop")
        sign_up.removeEventListener("click", signupbtn)
        sign_in.removeEventListener("click", signinbtn)
        event.stopPropagation();
        let resetbtn = (e) => {
            console.log(e)
            if(e.type == "click" || e.key == "Escape"){
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
            if(e.type == "click"  || e.key == "Escape"){
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

    //Sign up API call
    async function signup(user, pass, email, pnumber = "") {
        try {
            //Creating the FormData to Post
            const body = new FormData()
            if(user && pass && email){
            body.set('user', user)
            body.set('pass', pass)
            body.set('email', email)
            }
            if(pnumber) {
            body.set('pnumber', pnumber)
            }
            //Posting
            const response = await fetch('http://localhost/fsw/twitter-project-apis/signup.php', {
                method: 'POST',
                body: body
            });
            const data = await response.json()
            //return the response
            return data;
        } catch (error) {
            console.log(error)
        }
    }

    //Sign In API Calls
    async function signin(user, pass) {
        try {
            //Creating the FormData to Post
            const body = new FormData()
            if(user && pass){
                body.set('user', user)
                body.set('pass', pass)
            }
            
            //Posting
            const response = await fetch('http://localhost/fsw/twitter-project-apis/signin.php', {
                method: 'POST',
                body: body
            });
            const data = await response.json();
            return data;
        } catch (error) {
            return error;
        }
    }
}


function hompage() {
    image_input.addEventListener("change", function() {
        const reader = new FileReader();
        reader.addEventListener("load", (evt) => {
          console.log(evt.target.result);
        });
        reader.readAsDataURL(this.files[0]);
      });
}