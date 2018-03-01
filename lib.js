function callAction(action) {
    $.post('newAction.php', {"action": action}, function (response) {
        console.log(response);
        var data = JSON.parse(response);
        document.getElementById('output').innerHTML = data.art + data.output;
        // document.getElementById('description').innerHTML= data.art2 + data.beschreibung;
        document.getElementById('step').innerHTML = data.art2 + data.steps;
        document.getElementById('time').innerHTML=  data.art3 + data.time;
        document.getElementById('button').innerHTML = data.body;
    })
}

function callScore() {
    $.post('highscore.php', function (response) {
        console.log(response);
        var data = JSON.parse(response);
        console.log(data.body);
        document.getElementById('tableoutput').innerHTML = data.body;
    })
}

function callGenerator(maxX, maxY) {
    $.post('generatemap.php', {"maxX":maxX, "maxY":maxY}, function ()
     {
        console.log(maxX,  1);
    })
}