signUP()
async function signUP(){
    try {
        const response = await fetch('http://127.0.0.1/fsw/connectionDB.php', {
            method: 'POST',
        })
        const data = await response.json()
        console.log(data)
    }
    catch (error){
        console.log(error)
    }
}

function verification(fn, pn, ea, msg){
    let eaVerf = ea.split("@")
    //Check Phone Number
    if(pn.substring(0,4) != "+961"){ 
        contactLine.innerHTML = "Phone Number should start with +961";
    }
    else if(pn.substring(4,5) == "3"){
        if(pn.length != 11){
            contactLine.innerHTML = "Phone Number should be 7 Numbers";
        }
    }
    else if(pn.length != 12){
        contactLine.innerHTML = "Phone Number should be 8 Numbers";
    }
    //Check Name
    else if(fn.length < 5){
        contactLine.innerHTML = "First Name should have at least 5 Chars";
    }
    //Check Email
    else if(msg.length < 100){
        contactLine.innerHTML = "Message should be at least 100 Chars";
    }
    //Check Email
    else if(eaVerf[0].length < 3 || eaVerf[1].length < 5){
        contactLine.innerHTML = "Your Email Address has an incorrect format";
    }
    else{
        //Make the button work
    }
}