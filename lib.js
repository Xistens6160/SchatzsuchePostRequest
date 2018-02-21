function callAction(action, player) {
    $.post('action.php',{"action":action , "player":player} , function (response) {
        console.log(response);
        var data = JSON.parse(response);
        document.getElementById('output').innerHTML= data.art + data.output;
        document.getElementById('description').innerHTML= data.art2 + data.beschreibung;
        document.getElementById('button').innerHTML= data.body;
    })}
