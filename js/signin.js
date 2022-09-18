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