
let enabledSettings = []
const checkboxes = document.getElementsByName("valueX"), 
yField = document.getElementById("y-field"),
rField = document.getElementById("r-field")
var results = document.getElementById("result-table")

document.addEventListener("DOMContentLoaded", (event)=>{
    event.preventDefault();
    $.get(`session.php`, function(data){
        results.innerHTML=data
    })
})
function html_warning(code, toggle){
    var w = document.getElementById(code);
    if(toggle){
        w.style.display = "table-cell"
    }
    else{
        w.style.display = "none"
    }
}
function validate_y(value){
    if(isNaN(value.replace(",", "."))){
        html_warning("warn_y", true)
        return false}
    let number = parseFloat(value.replace(",", "."))
    if(number<5 && number>-5){
        html_warning("warn_y", false)
        return (number)
    }
    else{
        html_warning("warn_y", true)
        return false
    }
}
function validate_r(value){
    if(isNaN(value.replace(",", "."))){
        html_warning("warn_r", true)
        return false}
    let number = parseFloat(value.replace(",", "."))
    if(number<5 && number>2){
        html_warning("warn_r", false)
        return (number)
    }
    html_warning("warn_r", true)
    return false
}
function validate_x(array){
    if(array.length===1){
        html_warning("warn_x", false)
        return parseFloat(array[0].value)}
    html_warning("warn_x", true)
    return false
}
function validate_data(array, y, r){
    let x = validate_x(array)
    y = validate_y(y)
    r = validate_r(r)
    if((x!==false)&&y!==false&&r!==false){
        return({x: x, y: y, r: r})
    }
    return false
}

checkboxes.forEach(button => {
    button.addEventListener("click", () => {
        validate_x(document.querySelectorAll("[name=\"valueX\"]:checked"))
    })
})
yField.addEventListener("input", () => {
        validate_y(yField.value)
    })
rField.addEventListener("input", () => {
        validate_r(rField.value)
    })
    document.forms.form.onsubmit = function(event) {
        event.preventDefault()
        let data = validate_data(document.querySelectorAll("[name=\"valueX\"]:checked"), yField.value, rField.value)
        if(data){
            $.get(`main.php?x=${data.x}&y=${data.y}&r=${data.r}&offset=${new Date().getTimezoneOffset()}`, function(data){
                results.innerHTML+=data
            })
        }
    }