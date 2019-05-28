function GetByID(id) {
    return document.getElementById(id);
}

function Center(obj, parentNode, vertical='center', horizontal='center', vert_offset=0, horz_offset=0, vertMultp=1, horzMultp=1) {
    if (parentNode === 'normal') parentNode = obj.parentNode;

    switch (vertical) {
        case 'top':
            obj.style.top = "0px";
            break;
        case 'center':
            obj.style.top = (parentNode.clientHeight - vertMultp*obj.clientHeight - vert_offset)/2+"px";
            break;
        case 'bottom':
            obj.style.top = (parentNode.clientHeight - vertMultp*obj.clientHeight - vert_offset)  +"px";
            break;
        case 'none':
            break;
    }
    switch (horizontal) {
        case 'left':
            obj.style.left = "0px";
            break;
        case 'center':
            obj.style.left = (parentNode.clientWidth - horzMultp*obj.clientWidth - horz_offset)/2+"px";
            break;
        case 'right':
            obj.style.left = (parentNode.clientWidth - horzMultp*obj.clientWidth - horz_offset)  +"px";
            break;
        case 'none':
            break;
    }
}

function  complain(text) {
    console.log(text);
}

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