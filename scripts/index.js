async function callsign(){
    const resp = await post(3, 'what is this content', 'mediaurl');
    console.log(resp)
}
callsign()