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