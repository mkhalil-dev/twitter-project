async function signup(user, pass, email, pnumber = null) {
    try {
        //Creating the FormData to Post
        const body = new FormData()
        body.set('user', user)
        body.set('pass', pass)
        body.set('email', email)
        body.set('pnumber', pnumber)
        
        //Posting
        await fetch('http://localhost/fsw/twitter-project-apis/signup.php', {
            method: 'POST',
            body: body
        });
    } catch (error) {
        console.log(error)
    }
}