homepage()
// EVENT LISTNERS FOR SIGN IN / SIGN UP BUTTONS
function loginpage() {
    const sign_up = document.querySelector("#sign-up")
    const bagrcol = document.querySelector(".main-page")
    const sign_in = document.querySelector("#sign-in")
    const up_pop = document.querySelector("#up-pop")
    const popup_esc = document.querySelector("#essc")
    const in_pop = document.querySelector("#in-pop")
    const popin_esc = document.querySelector("#escc")
    sign_in.addEventListener("click", signinbtn)
    sign_up.addEventListener("click", signupbtn)

    function signinbtn(event) {
        bagrcol.classList.add("back")
        in_pop.classList.add("pop")
        sign_up.removeEventListener("click", signupbtn)
        sign_in.removeEventListener("click", signinbtn)
        event.stopPropagation();
        let resetbtn = (e) => {
            console.log(e)
            if (e.type == "click" || e.key == "Escape") {
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
        document.getElementById("login").addEventListener('click', function() {
            let username = document.getElementById("user").value;
            let password = document.getElementById("pass").value;
            (async () => {
                await signin(username, password)
                    .then(results => {
                        if (results["success"]) {
                            localStorage.setItem("username", username);
                        } else {
                            console.log("what")
                        }
                    })
            })();
        })
    }

    function signupbtn(event) {
        bagrcol.classList.add("back")
        up_pop.classList.add("pop")
        sign_up.removeEventListener("click", signupbtn)
        sign_in.removeEventListener("click", signinbtn)
        event.stopPropagation();
        let resetbtn = (e) => {
            if (e.type == "click" || e.key == "Escape") {
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
        document.getElementById("signup").addEventListener('click', function() {
            let username = document.getElementById("signup-username").value;
            let email = document.getElementById("signup-email").value;
            let password = document.getElementById("signup-password").value;
            (async () => {
                await signup(username, password, email)
                    .then(results => {
                        if (results["success"]) {
                            console.log("created your username")
                            localStorage.setItem("username", username); // Sign up success
                        } else {
                            console.log("what") //Sign up failed
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
            if (user && pass && email) {
                body.set('user', user)
                body.set('pass', pass)
                body.set('email', email)
            }
            if (pnumber) {
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
            if (user && pass) {
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
function homepage() {
    const column = document.querySelector(".colum2");
    console.log(column)
    let user = localStorage.getItem("username");
    getfeed()
    let media;
    document.getElementById("file-input").addEventListener("change", function() {
        const reader = new FileReader();
        reader.addEventListener("load", (evt) => {
            media = evt.target.result
        });
        reader.readAsDataURL(this.files[0]);
    });
    document.getElementById("tweet-btn").addEventListener('click', post)
    async function post() {
        let content = document.getElementById("tweetbox").value;
        const body = new FormData();
        if (content) {
            body.set('content', content)
        }
        if (media) {
            body.set('media_url', media)
        }
        body.set('user', user)
        const response = await fetch('http://localhost/fsw/twitter-project-apis/create_post.php', {
            method: 'POST',
            body: body
        })
        const data = await response.json()
            .then(function() {
                console.log(data);
            })
        return data;
    }
    async function getfeed() {
        try {
            //Creating the FormData to Post
            const body = new FormData()
            if (user) {
                body.set('user', user)
            } else {
                return "user is undefined";
            }
            //Posting
            const response = await fetch('http://localhost/fsw/twitter-project-apis/get_feed.php', {
                method: 'POST',
                body: body
            });
            const data = await response.json()
            data.forEach(item => {
                console.log(item)
                if(!item.fname){
                    item.fname = item.user
                }
                if(!item.lname){
                    item.lname = ""
                }
                if(!item.likes){
                    item.likes = 0;
                }
                time = item.created_at
                let odp = time.split(" ");
                console.log(odp[1])
                column.insertAdjacentHTML('beforeend', '<div class="Tweet"><div class="tweetpr"><P>'+item.fname+' '+item.lname+'  <SPan>@'+item.user+'  17h</SPan></P></div><P>'+item.content+'</P><img src="./images/twitter.png" alt="" class="twtmed"><i class="fa fa-heart" ></i><p class="nblik">'+item.likes+'</p></div>')
            });
            //return the response
            return data; //returns an array of data
        } catch (error) {
            console.log(error)
        }
    }

}