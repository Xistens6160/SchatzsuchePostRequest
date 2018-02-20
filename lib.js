function callAction(action) {
    $.post('action.php',{"action":action}, function (response) {
        console.log(response);
        var data = JSON.parse(response);
        if (action == 1 || 2 || 3 || 4) {
            document.getElementById('output').innerHTML = "Ort: "+data.ort.name;
            document.getElementById('beschreibung').innerHTML = "Beschreibung: "+data.ort.Beschreibung;
        }
        if (action == 0){
            document.getElementById('output').innerHTML = data.start.start;
            document.getElementById('beschreibung').innerHTML = "";
        }
        if (action == 6){
            document.getElementById('output').innerHTML = "Tipp: "+data.tipp.tipp;
            document.getElementById('beschreibung').innerHTML = "";
        }
    })}