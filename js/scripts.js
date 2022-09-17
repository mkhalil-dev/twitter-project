const sign_up=document.querySelector("#sign-up")
const bagrcol=document.querySelector(".main-page")
const sign_in=document.querySelector("#sign-in")
const up_pop=document.querySelector("#up-pop")
const popup_esc=document.querySelector("#essc")
const in_pop=document.querySelector("#in-pop")
const popin_esc=document.querySelector("#escc")






console.log(up_pop)


sign_in.addEventListener("click",()=>{
    bagrcol.classList.toggle("back")
   
    in_pop.classList.add("pop")



})


sign_up.addEventListener("click",()=>{
    bagrcol.classList.toggle("back")

    up_pop.classList.add("pop")

})
popup_esc.addEventListener("click",()=>{
    bagrcol.classList.toggle("back")
    up_pop.classList.remove("pop")



})
popin_esc.addEventListener("click",()=>{
    bagrcol.classList.toggle("back")
    in_pop.classList.remove("pop")



})