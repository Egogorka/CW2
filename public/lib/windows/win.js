
complain('win.js loaded');

/*document.addEventListener('load',function(){

    complain('win.js : window.onload happend');
    var windows = document.querySelectorAll('.window');
    for( i=windows.length-1; i>=0; i--){
        var curwin = windows[i];


        curwin.style.display = 'none';
    }

});*/

function win_show(id) {
    var curwin = GetByID(id);

    if (!curwin) {
        complain('No such window : '+id);
        return;
    }

    curwin.style.display = 'flex';
    curwin.style.top = window.innerHeight/2 - curwin.offsetHeight/2 + "px";
    curwin.style.left = window.innerWidth/2 - curwin.offsetWidth/2 + "px";

    complain(id+' is showed now');
}

function win_hide(id) {
    var curwin = GetByID(id);

    if (!curwin) {
        complain('No such window : '+id);
    }

    curwin.style.display = 'none';
    complain(id + ' is hidden now');
}