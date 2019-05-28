
function AjaxRequest( connectionType , actionScript , json , readyState , timeout, time=20000) {
    //alert(json);

    var xhr = new XMLHttpRequest();
    xhr.open( connectionType , actionScript );
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    //xhr.timeout = time;

    //xhr.ontimeout = timeout();

    xhr.onreadystatechange = function() {
        if(xhr.readyState !== 4) return false;

        if(xhr.status === 200) {
            readyState( xhr.responseText );
            //xhr.ontimeout = function () {return 0;};
        }
        else
            complain("Error |:" + xhr.status + ': ' + xhr.statusText);
    };

    xhr.send('param='+json);
}

function complain(text) {
    console.log(text);
}

function GetByID(id) {
    return document.getElementById(id);
}