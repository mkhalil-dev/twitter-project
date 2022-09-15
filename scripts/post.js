async function post(user, content, media){
    const body = new FormData();
    if(content){
        body.set('content', content)
    }
    if(media){
        body.set('media_url', media)
    }
    body.set('user', user)
    const response = await fetch('http://localhost/fsw/twitter-project-apis/post.php', {
        method: 'POST',
        body: body
    })
    const data = await response.json()
    return data;
}