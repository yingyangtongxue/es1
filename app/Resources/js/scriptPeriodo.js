let DateNow = new Date
let inputDateNow = document.querySelector("#DateNow")
let inputDateFinal = document.querySelector("#DateFinal")

window.onload = () =>{
    let monthDate = DateNow.getMonth()+1
    let month = monthDate < 10 ? "0" + monthDate : monthDate
    let day =  DateNow.getDate() < 10 ? "0" + DateNow.getDate() : DateNow.getDate()
    inputDateNow.value = DateNow.getFullYear() +"-"+month+"-"+day
    day++
    inputDateFinal.setAttribute("min",  DateNow.getFullYear() +"-"+month+"-"+day)
}