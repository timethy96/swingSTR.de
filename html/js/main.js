function open_overlay () {
    var id = this.id;
    var content = document.getElementById('overlay_content');
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            content.innerHTML = this.responseText;
            document.getElementById('overlay').style.display = "block";
        }
    };
    xhttp.open("GET", id + ".php", true);
    xhttp.send();
};

function close_overlay() {
    document.getElementById('overlay').style.display = "none";
}

document.getElementById('add_event').onclick = open_overlay;
document.getElementById('more_info').onclick = open_overlay;
document.getElementById('imprint').onclick = open_overlay;