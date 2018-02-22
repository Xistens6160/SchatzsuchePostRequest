function callAction(action) {
    $.post('action.php',{"action":action} , function (response) {
        console.log(response);
        var data = JSON.parse(response);
        document.getElementById('output').innerHTML= data.art + data.output;
        document.getElementById('description').innerHTML= data.art2 + data.beschreibung;
        document.getElementById('step').innerHTML= data.art3 + data.steps;
        document.getElementById('time').innerHTML= data.art4 + data.time;
        document.getElementById('button').innerHTML= data.body;
    })}

function callScore() {
    $.post('highscore.php' , function (response) {
        console.log(response);
        var data = JSON.parse(response);
        document.getElementById('steps').innerHTML= data.steps;
        document.getElementById('time').innerHTML= data.times;
    })}
