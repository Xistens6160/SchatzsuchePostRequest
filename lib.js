function callAction(action) {
    $.post('newAction.php',{"action":action} , function (response) {
        console.log(response);
        var data = JSON.parse(response);
        document.getElementById('output').innerHTML= data.art;
        // document.getElementById('description').innerHTML= data.art2 + data.beschreibung;
        document.getElementById('step').innerHTML= data.steps;
        // document.getElementById('time').innerHTML= data.art4 + data.time;
        document.getElementById('button').innerHTML= data.body;
    })}

function callScore() {
    $.post('highscore.php' , function (response) {
        console.log(response);
        var data = JSON.parse(response);
        console.log(data.body);
        document.getElementById('tableoutput').innerHTML= data.body;
    })}
