async function getfeed(user) {
    try {
        //Creating the FormData to Post
        const body = new FormData()
        if(user){
        body.set('user', user)
        }
        else{
            return "user is undefined";
        }
        //Posting
        const response = await fetch('http://localhost/fsw/twitter-project-apis/get_feed.php', {
            method: 'POST',
            body: body
        });
        const data = await response.json()
        //return the response
        return data; //returns an array of data
    } catch (error) {
        console.log(error)
    }
}