function addRowHandlers() {
    var table = document.getElementById("schuelerTableBody");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler =
            function(row){
                return function() {
                    var cell = row.getElementsByTagName("td")[0];
                    var id = cell.innerHTML;
                    //alert("id:" + id);
                    showSchueler(id);
                };
            };
        currentRow.onclick = createClickHandler(currentRow);
    }
}
window.onload = addRowHandlers();

function showSchueler(schuelerID){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("schuelerEdit").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","schuelerEdit.php?id="+schuelerID,true);
    xmlhttp.send();
}

$(document).on('click','#butSub',function(e) {
    var data = $("#schuelerForm").serialize();
    $.ajax({
           data: data,
           type: "POST",
           url: "saveSchueler.php",
           success: function(data){
                alert("Schüler gespeichert: ");
           }
  });
});

$(document).on('click','#neuerSchueler',function(e) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("schuelerEdit").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","schuelerEdit.php?id="+ -1,true);
    xmlhttp.send();
});

