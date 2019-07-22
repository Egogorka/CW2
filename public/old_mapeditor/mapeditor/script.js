
//For stoopid phones

Math.trunc = Math.trunc || function(x) {
  return x - x%1;
};

/*

Comments are soo cool, 
but sometimes i forget to put them
Sorry. 

Use google translator to 
translate comments if you cant
understand them.



//////////////////////////////////////////////
// To do

1. Проверить переменные, заменить ненужные, поставить приемлемые имена

2.   Запилить сохранение карты.
2,5. А после и загрузку.

3. Хранить карту в двумерном массиве ( x и y координаты), вместо
тоже двумерного, но с последовательным индексом и координатами самого 
шестиугольника в кубических координатах.

выигрыш налицо : хранение двух координат + тип 
против хранения трёх(! притом третья вычисляема) координат + тип

При этом потребуется замена "отображения" карты при загрузке

*/

//////////////////////////////////////////////
// Global variables
//////////////////////////////////////////////

var player = []; // login/password

var ToolBiggerBody = false;
var ToolbarOpened = true;
var SavebarOpened = true;
var MapcodeOpened = false;

var width_body = Number(document.body.clientWidth);
var height_body = Number(document.body.clientHeight);

var typehex = false; // Изначальный "доступный шестиугольник"
var widthGlobal = Number(document.getElementById('hexagons_board').clientWidth); // ширина  
var heightGlobal = Number(document.getElementById('hexagons_board').clientHeight); // высота
var board = document.getElementById('hexagons_board');

var EVEN = 1; // херь для рабочих/нерабочих (подчеркнуть нужное) функций
var ODD = -1; //

var hex_diagonals = [Hex(2, -1, -1), Hex(1, -2, 1), Hex(-1, -1, 2), Hex(-2, 1, 1), Hex(-1, 2, -1), Hex(1, 1, -2)];
var hex_directions = [Hex(1, 0, -1), Hex(1, -1, 0), Hex(0, -1, 1), Hex(-1, 0, 1), Hex(-1, 1, 0), Hex(0, 1, -1)];

var layout_pointy_squared = Orientation(2.0, 1.0, 0.0, 3.0 / 2.0, 1.0 / 2.0, -1.0 / 3.0, 0.0, 2.0 / 3.0, 0.5);

var hex_layout = Layout(layout_pointy_squared, Point(42.5,42.5), Point(heightGlobal/2, widthGlobal/2) );

/////////////////////////////////////////////
// Map structure
/////////////////////////////////////////////
/*
Карта представляет собой трёхмерный массив, где
1 уровень массива включает в себя Х координату
2 уровень массива включает в себя У координату
3 уровень массива включает в себя лишь два значения,
  1 -> "цвет" земли (ключ по таблице)
  2 -> номер структуры (0 если нет)
*/

var MapBoard = [];

//////////////////////////////////////////////
// Table of image branchs
//////////////////////////////////////////////

// Ключи для "таблицы" ссылок на картинки.
// Можно, конечно, убрать, но порой удобно её использовать
key_table = [

    'neutral_alias',
    
    'purple_alias',
    'red_alias',
    'yellow_alias',
    'green_alias',
    'cyan_alias',
    'blue_alias',

    'base',
    'harvester',
    'radar',
    'shipfactory'

];

structures_table = [
    'base',
    'harvester',
    'radar',
    'shifactory'
];

image_table = {

// Территория
    neutral_alias: 'hexagons/empty.png',

    purple_alias : 'hexagons/hxgonPurple.png',
    red_alias    : 'hexagons/hxgonRed.png',
    yellow_alias : 'hexagons/hxgonYellow.png',
    green_alias  : 'hexagons/hxgonGreen.png',
    cyan_alias   : 'hexagons/hxgonCyan.png',
    blue_alias   : 'hexagons/hxgonBlue.png',

// Структуры
        
    base         : 'upgrades/base_1.png',
    harvester    : 'upgrades/harvester_1.png',
    radar        : 'upgrades/radar_1.png',
    shipfactory  : 'upgrades/shipfactory_1.png'
};

ROOT = ''; //"/istrolid_clanwars/useful/"

//////////////////////////////////////////////

gallery = document.getElementById("images_gallery");

if(gallery){
key_table.forEach( function (value , i , arr) {

    new_image = document.createElement('img');
    new_image.id = "galimg"+i;
    new_image.className = "gal_images";
    new_image.setAttribute('onclick', "TypeOfHex_click('"+i+"')");
    new_image.src = ROOT+image_table[value];


    gallery.appendChild(new_image);

});
}
///// prompt window
{
    backlocker = document.createElement("div");
    backlocker.id = "backlocker";
    document.body.appendChild(backlocker);

    ResizeWindow(); /// Moving everything, what should move when resize comes
}
///// scroll at start
{
    x = widthGlobal/2 - width_body/2;
    y = heightGlobal/2 - height_body/2; 
    window.scrollTo(x,y);
}

//////////////////////////////////////////////
// Event Handlers
//////////////////////////////////////////////

function WindowWidthHeight() {
    test = document.createElement("div");
    test.id = "backlocker";
    document.body.appendChild(test);
    widthheight = [test.clientWidth, test.clientHeight];
    document.body.removeChild(test);
    return widthheight;
}

/*______________________________.
                                |
    Map save                    |
  ______________________________|
*/

document.querySelector("#mapcode > form").onsubmit = function() 
{
    form = document.querySelector("#mapcode > form");
    mapname = form.elements.mapname.value;

    if( mapname.replace(/[A-Za-z0-9-_]/g,'').length > 0){
        document.getElementById("loginlog").innerHTML = "Map name must contain symbols only from english alphabet or numbers";
        return false;               
    }
    if( mapname.replace(/[^A-Za-z]/g,'').length < 4){
        alert("Map name must contain at least 4 non-number or non-special symbols");
        return false;               
    }
    if( mapname.replace(/[^A-Za-z0-9-_]/g,'').length >= 30){
        document.getElementById("loginlog").innerHTML = "Map name is too long";
        return false;               
    }

    alert(player[0]+"\n"+player[1]);

    var json = JSON.stringify({
      map: MapToString(),
      name: mapname
    });

    AjaxFun('POST','/mapeditor/map_save.php', json, function(responseRaw)
    {
        console.log(responseRaw);
        res = JSON.parse(responseRaw);

        if( res.errCode === 200 ) {
            console.log('Saved map successfully')
        }  else {
            alert('Error');
            console.log('Error '+res.errCode + " : "+res.errText);
        }

    }, function() {
        // ontimeout
        alert("timeou112t");
    });

    MapcodeOpened = true;
    CloseMapcode();
    return false;
}

function CloseMapcode() {
    mapcode = document.getElementById("mapcode");

    if(MapcodeOpened){
        //close if  open
        mapcode.style.left = width_body + "px";
    } else {
        //open  if close
        mapcode.style.left = width_body - mapcode.offsetWidth + "px";
    }
    MapcodeOpened = !MapcodeOpened;
}

/*______________________________.
                                |
    Gallery                     |
  ______________________________|
*/

/// Init

    var margin_gallery = 0;
    var gallery = document.getElementById("images_gallery");
        
    getGalWidth();

/// Handlers
function increace(){
    getGalWidth();
    if( margin_gallery < -(gallery_Swidth - gallery_width - 300)){
        margin_gallery = -(gallery_Swidth - gallery_width + 80);
    } else {
        margin_gallery = margin_gallery - 300;
    }
    gallery.style.marginLeft = margin_gallery + "px";
}

function decreace(){
    getGalWidth();
    if( margin_gallery > -300){
        margin_gallery = 0;
    } else {
        margin_gallery = margin_gallery + 300;
    }
    gallery.style.marginLeft = margin_gallery + "px";
}
document.getElementById("increace").onclick = increace;
document.getElementById("decreace").onclick = decreace;

function getGalWidth() {
    folder_gallery = document.getElementById("folder_gallery");
    gallery_imgs = document.querySelectorAll("#images_gallery > img");
    gallery_Swidth = 0;
    for (var i = 0; i < gallery_imgs.length; i++) {
        gallery_Swidth += gallery_imgs[i].offsetWidth;
    }
    gallery_width  = folder_gallery.clientWidth;
}

/*______________________________.
                                |
    Closers                     |
  ______________________________|
*/

function CloseToolbar() {
    tool_box = document.getElementById("tool_box");
    toolboxcloser = document.getElementById("closertool_box");

    tool_box.style.top = "0px"; // Костыль
    if(ToolbarOpened){
        tool_box.style.top = -tool_box.offsetHeight + "px";
        if(ToolBiggerBody) toolboxcloser.style.top = "-5px";
        else toolboxcloser.style.top = -toolboxcloser.offsetHeight/2 + 10 + "px";
    } else {
        if(ToolBiggerBody) toolboxcloser.style.top = tool_box.offsetHeight - 5 + "px";
        else toolboxcloser.style.top = "0px";
    }
    ToolbarOpened = !ToolbarOpened;
}
document.getElementById("closertool_box").onclick = CloseToolbar;

function CloseSavebar() {
    saveblock = document.getElementById("saver");
    savercloser = document.getElementById("closersaver");

    if(SavebarOpened){
        saveblock.style.left = width_body + "px";
        savercloser.style.left = width_body - savercloser.offsetWidth + 6 + "px";
    } else {
        saveblock.style.left = width_body - saveblock.offsetWidth + "px";
        savercloser.style.left = width_body - saveblock.offsetWidth - savercloser.offsetWidth + 6 + "px";
    }
    SavebarOpened = !SavebarOpened;

    MapcodeOpened = true;
    CloseMapcode();
}
document.getElementById("closersaver").onclick = CloseSavebar;

/*______________________________.
                                |
    Resize                      |
  ______________________________|
*/

    window.onresize = ResizeWindow;
function ResizeWindow() {
    widthheight = WindowWidthHeight();

    width_body = widthheight[0];
    height_body = widthheight[1];

    tool_box = document.getElementById("tool_box");

    previousWidth = tool_box.clientWidth;
    tool_box.style.width = "1200px";
    margin_left_tb = (width_body)/2 - tool_box.offsetWidth/2;
    tool_box.style.width = previousWidth;

    ToolBiggerBody = margin_left_tb <= 0;

    toolboxcloser = document.getElementById("closertool_box");

    if (ToolBiggerBody) {
        if(ToolbarOpened){
            tool_box.style.width = (width_body - 2*(tool_box.offsetWidth - tool_box.clientWidth)) + "px";
            tool_box.style.left = "0px";
            document.getElementById("folder_gallery").style.width = (width_body - 100) + "px";

            toolboxcloser.style.top  = tool_box.offsetHeight - 5 + "px";
        }   toolboxcloser.style.left = width_body - toolboxcloser.offsetWidth + "px";

    } else{
        tool_box.style.width = "1200px";
        tool_box.style.left = margin_left_tb + "px";
        document.getElementById("folder_gallery").style.width = "900px";
    
        toolboxcloser.style.left = margin_left_tb + tool_box.offsetWidth - 5 + "px";
        if(ToolbarOpened) toolboxcloser.style.top  = "0px";
                    else  toolboxcloser.style.top  = -toolboxcloser.offsetHeight/2 + 10 + "px";
    }

    prompt = document.getElementById("prompt-container");
    prompt.style.top = height_body/2 - prompt.offsetHeight/2 + "px";
    prompt.style.left = width_body/2 - prompt.offsetWidth/2 + "px";

    copyright = document.getElementById("copyright");
    copyright.style.top  = height_body - copyright.offsetHeight + "px";
    
    savercloser = document.getElementById("closersaver");
    savercloser.style.top = height_body - savercloser.offsetHeight + "px";

    saveblock = document.getElementById("saver");
    saveblock.style.top = height_body - saveblock.offsetHeight + "px";

    mapcode = document.getElementById("mapcode");
    mapcode.style.top  = height_body - saveblock.offsetHeight - mapcode.offsetHeight - 3 + "px";

    SavebarOpened = !SavebarOpened;
    CloseSavebar();

    MapcodeOpened = !MapcodeOpened;
    CloseMapcode();

    getGalWidth();
        gallery_SwidthPrev = gallery_Swidth;
        gallery_imgs = document.querySelectorAll("#images_gallery > img");
        gallery_Swidth = 0;
        for (var i = 0; i < gallery_imgs.length; i++) {
            gallery_Swidth += gallery_imgs[i].offsetWidth;
        }
            gallery_width  = folder_gallery.clientWidth;
            if( margin_gallery < -(gallery_Swidth - gallery_width - 300)){
                margin_gallery = -(gallery_Swidth - gallery_width + 80);
                gallery.style.marginLeft = margin_gallery + "px";
            }
}


function hex_click(e) {
    if(e.which == 2) return false;

    thex = Pixel_to_rOddOffset( e.pageX , e.pageY , 42.5 );

    alert(thex.x +" "+ thex.y+"|"+typehex);

	output = roffset_to_cube(ODD, OffsetCoord(thex.x, thex.y));
    
    if(typehex) Hex_Spawn_mapeditor(output, thex, typehex);
}
	board.addEventListener("click", hex_click);

document.getElementById("getmapcode").classList.add("btnwork");
document.getElementById("getmapcode").onclick = function () 
{
    var newWin = window.open("about:blank", '_blank');
        newWin.document.write(MapToString());
}

    function Map_Upload() {
        map = document.getElementById("text_mapload").value;

        // Clearing map from previous hexagons
        cells = document.querySelectorAll(".cells") //~~using JQuery ;-;~~ NO JQERY ANYMORE, YAS

        for (var i = cells.length - 1; i >= 0; i--) {
            board.removeChild(cells[i]);
        }

        cells = document.querySelectorAll(".buildings");

        for (var i = cells.length - 1; i >= 0; i--) {
            board.removeChild(cells[i]);
        }

        delete MapBoard //delete old massive
        MapBoard = [];  // create new

        Map_Filling_Array( map );
        Hexgrid_Show();

    }

    document.getElementById("btn_mapload").addEventListener("click", Map_Upload);

////////////////////////////////////////////////
// Hex Grid Functions ( Mine )
////////////////////////////////////////////////

function Hexgrid_Show (){

    MapBoard.forEach( function(hextable_x, i) {
        hextable_x.forEach( function(hextable_y, j){
            xy = roffset_to_cube(ODD, OffsetCoord(i-36, j-30));
            id = xy.q + ":" + xy.r + ":" + xy.s + "/"; 
            var offset_cord = {};
            offset_cord.x = i-36;
            offset_cord.y = j-30;
            Hex_Append(
                id,
                offset_cord,
                hextable_y[0]
                );
            if (hextable_y[1] != 0){
                id = xy.q + ":" + xy.r + ":" + xy.s;
                Hex_Append( 
                    id,
                    offset_cord,
                    hextable_y[1]
                    );
            }
        });
    });
alert("all done");

}

function Pixel_to_rOddOffset ( mouse_x , mouse_y , size ) {

    ms_x = mouse_x - widthGlobal/2;
    ms_y = mouse_y - heightGlobal/2 - size;

    thex_x = Math.floor(ms_x / (size*2  ));
    thex_y = Math.floor(ms_y / (size/2*3));

    hex_x = Math.round(size*2*(ms_x / (size*2) - thex_x));

    if( (Math.floor(ms_y / (size/2*3)) & 1) == 1){

        hex_y = (size/2*3) - Math.round((size/2*3)*(ms_y / (size/2*3) - thex_y)); 

            if ( ( (2*(hex_y) - (hex_x)) < size) && ( ( 2*(hex_y) + (hex_x) ) < size*3 ) ){
                thex_y++;
            } else 
            if ( hex_x < size){
                thex_x--;
            } else {

            }

        } else {

        hex_y = Math.round((size/2*3)*(ms_y / (size/2*3) - thex_y));

            if ( ( (2*(hex_y) - (hex_x)) < size) && ( ( 2*(hex_y) + (hex_x) ) < size*3 ) ){

            } else 
            if ( hex_x < size){
                thex_x--; thex_y++;
            } else {
                thex_y++;
            }

        }

    return {x: thex_x, y: thex_y};

}

function Hex_DeleteFromGrid( hex_in , type ) {
    xy = roffset_from_cube(ODD, hex_in);
    xy.col += 36;
    xy.row += 30;

    ThisHex = MapBoard[xy.col][xy.row];
    if ( type <= 6 ){
        delete MapBoard[xy.col][xy.row];
    } else {
        ThisHex[1] = 0;
        MapBoard[xy.col][xy.row] = ThisHex;
    }
}

function Hex_AddInGrid( hex_in , type ) {
    //alert(hex_in.q + " | " + hex_in.r);
    xy = roffset_from_cube(ODD, hex_in);
    xy.col += 36;
    xy.row += 30;
    //alert(xy.col + "|" + xy.row);

    Hxgons_board_col = MapBoard[xy.col];//[hex_in.r];
    if( Hxgons_board_col === undefined){
        MapBoard[xy.col] = [];
        Hxgons_board_col = [];
    }
    ThisHex = Hxgons_board_col[xy.row];
    if( ThisHex === undefined){
        ThisHex = [];
    }
    if ( type <= 6){
        ThisHex[0] = type;
    } else {
        //alert(type);
        ThisHex[1] = type;
    }
    MapBoard[xy.col][xy.row] = ThisHex;
}

function Hex_Spawn_mapeditor( hex_in , offset_coords , type ) {
    //alert('hi');

    idhxgon = hex_in.q + ":" + hex_in.r + ":" + hex_in.s;
    equalland = equalstrt = false; // Заполняем переменные false (определяя их),
                                   // чтобы не было вопросов у инпретатора.

    hxgon_strt = document.getElementById(idhxgon);
    hxgon_land = document.getElementById(idhxgon + "/"); 
    
    
    if(hxgon_land) equalland = (type == hxgon_land.dataset.type);
    if(hxgon_strt) equalstrt = (type == hxgon_strt.dataset.type);
    //alert( equalstrt + " | " + equalland);

// Если 
    if( type <= 6  ){
        if(hxgon_land) board.removeChild(hxgon_land);
        idhxgon = idhxgon + "/";
    }

// Удаляем прошлую структуру (для порядка размещения)
    if( hxgon_strt ) hxgon_strt = board.removeChild(hxgon_strt);

// Появляем наш шестиугольник когда он не соответствует предыдущему,
// И при этом немного магии ( лень объяснять )
    if( !(equalstrt || equalland) && ( hxgon_land || type <= 6 ) ){
        Hex_Append(
            idhxgon,
            offset_coords,
            type
        );
        Hex_AddInGrid( hex_in , type );
    } else {
        Hex_DeleteFromGrid( hex_in , type );
    }
// Возвращаем структуру на место, если мы не поставили другую структуру 
    if( !equalland && ( hxgon_strt && type <= 6 ) ) board.appendChild(hxgon_strt);
    

}

function Hex_Append ( id , offset_coords , typee ) {
        new_hxgon = document.createElement('img');

        new_hxgon.id = id;
        new_hxgon.src = ROOT+image_table[key_table[typee]];
        new_hxgon.setAttribute('data-type', typee);

        left_margin =  widthGlobal/2 + offset_coords.x * (85) + (offset_coords.y & 1)*42;
        top_margin  = heightGlobal/2 + offset_coords.y * (85/4*3);
        if( typee > 6){
        new_hxgon.className = 'buildings';
        left_margin = left_margin + 7.5;
        top_margin  = top_margin  + 7.5;
        } else
        new_hxgon.className = 'cells';

        //alert(left_margin + " | " + top_margin);

        new_hxgon.style.marginLeft = left_margin + "px";
        new_hxgon.style.marginTop  = top_margin + "px";

        board.appendChild(new_hxgon);

}

function TypeOfHex_click( type ) {
that = document.getElementById("galimg"+type)
typehex = type;
if(selected = document.querySelector(".selected")) selected.classList.remove("selected");
that.classList.add("selected");
}

function MapToString() {
    var savemap = "";
    var savemap_y = ""; 
    MapBoard.forEach( function (hextable_x , i) {
        savemap_y = "";
        hextable_x.forEach( function (hextable_y , j) { 
            if( hextable_y[1] == 0 || key_table[hextable_y[1]] === undefined){
                hextable_y[1] = 0;
                savemap_typeofhex = hextable_y.join(':');
            }
            savemap_y = savemap_y + "|" + j + ";" + hextable_y[0] + ";" + hextable_y[1];
        });
        if (savemap_y != "")        
        savemap = savemap + i + savemap_y + "\"";
    });
    return savemap;
}

function Map_Filling_Array( strok ) {

    mappy = strok.split("\""); // mappy будет представлять из себя массив
                                    // ("x|y;type;type|y;type;type|...","x|y;type;type")
    mappy.forEach( function( strok_x , i ) {
        hextable_x = strok_x.split("|"); // hextable_x же будет представлять из себя:
                                         // ("x", "y;type;type", "y;type;type", ...)
        xy_x = Number(hextable_x[0]);
        MapBoard[xy_x] = []; // Добавляем на "карту" столбец Х.
        for (var j = 1; j < hextable_x.length; j++) {
            hextable_y = hextable_x[j].split(";");  //hextable_y будет содержать:
                                                    // ("y", "type", "type")
            MapBoard[xy_x][Number(hextable_y[0])] = [hextable_y[1], hextable_y[2]];
            //alert( MapBoard[xy_x][Number(hextable_y[0])] );
        }
    });
    // Функция ничего не выводит, так как работала с переменной MapBoard, которая, какбы, "глобальная" :D
}

////////////////////////////////////////////////
// Управление страницей
////////////////////////////////////////////////

////////////////////////////////////////////////
// Sign Up
////////////////////////////////////////////////

document.getElementById("noacc").onclick = function() {
    document.getElementById("backlocker").style.display = "none";
    document.getElementById("prompt-container").style.display = "none";
    document.getElementById("serversave").style.backgroundColor = "grey";
    document.querySelector("#saver > div").style.color = "#696969";
}

///////////////////
// Sign Up Itself
///////////////////

function LoginSignUp() {

    formlog = document.getElementById("loginform");

    var json = JSON.stringify({
      login: formlog.elements.login.value,
      pass: formlog.elements.pswrd1.value,
      type : 'login'
    });

    AjaxFun('POST','/lib/users/userlog/userbar.php' ,json, function(responseRaw) {

        complain(responseRaw);
        let response = JSON.parse(responseRaw);
        document.getElementById("loginlog").innerHTML = response;
        if(response.errCode === 200 ) SuccessCall();
        
    }, function() {console.log('timeout')});

}
document.getElementById("loginform").onsubmit = function() {LoginSignUp(); return false;};

function SuccessCall() {
    document.getElementById("backlocker").style.display = "none";
    document.getElementById("prompt-container").style.display = "none";
    document.getElementById("serversave").classList.add("btnwork");
    document.getElementById("serversave").onclick = CloseMapcode;
    alert("Logged successful");
}

function AjaxFun( connectionType , actionScript , json , readyState , timeout) {
    var xhr = new XMLHttpRequest();
    xhr.open( connectionType , actionScript );
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.timeout = 20000;

    xhr.ontimeout = timeout();
    xhr.onreadystatechange = function() {
        if(xhr.readyState != 4) return false;   

        if(xhr.status == 200) readyState( xhr.responseText );
           else
        alert("Error |:" + xhr.status + ': ' + xhr.statusText);
    };

    xhr.send('param='+json); 
}

////////////////////////////////////////////////
// Saving mappironi
////////////////////////////////////////////////



////////////////////////////////////////////////
// Hex Grid Functions
////////////////////////////////////////////////


function Point(x, y) {
    return {x: x, y: y};
}

function Hex(q, r, s) {
    return {q: q, r: r, s: s};
}

function hex_add(a, b) // Входные данные - два "шестиугольника"
{
    return Hex(a.q + b.q, a.r + b.r, a.s + b.s);
}

function hex_subtract(a, b) // Входные данные - два "шестиугольника"
{
    return Hex(a.q - b.q, a.r - b.r, a.s - b.s);
}

function hex_scale(a, k) // Входные данные - два "шестиугольника"
{
    return Hex(a.q * k, a.r * k, a.s * k);
}

function hex_direction(direction)
{
    return hex_directions[direction];
}

function hex_neighbor(hex, direction)
{
    return hex_add(hex, hex_direction(direction));
}

function hex_diagonal_neighbor(hex, direction)
{
    return hex_add(hex, hex_diagonals[direction]);
}

function hex_length(hex)
{
    return Math.trunc((Math.abs(hex.q) + Math.abs(hex.r) + Math.abs(hex.s)) / 2);
}

function hex_distance(a, b)
{
    return hex_length(hex_subtract(a, b));
}

function hex_round(h)
{
    var q = Math.trunc(Math.round(h.q));
    var r = Math.trunc(Math.round(h.r));
    var s = Math.trunc(Math.round(h.s));
    var q_diff = Math.abs(q - h.q);
    var r_diff = Math.abs(r - h.r);
    var s_diff = Math.abs(s - h.s);
    if (q_diff > r_diff && q_diff > s_diff)
    {
        q = -r - s;
    }
    else
        if (r_diff > s_diff)
        {
            r = -q - s;
        }
        else
        {
            s = -q - r;
        }
    return Hex(q, r, s);
}

function hex_lerp(a, b, t)
{
    return Hex(a.q * (1 - t) + b.q * t, a.r * (1 - t) + b.r * t, a.s * (1 - t) + b.s * t);
}

function hex_linedraw(a, b)
{
    var N = hex_distance(a, b);
    var a_nudge = Hex(a.q + 0.000001, a.r + 0.000001, a.s - 0.000002);
    var b_nudge = Hex(b.q + 0.000001, b.r + 0.000001, b.s - 0.000002);
    var results = [];
    var step = 1.0 / Math.max(N, 1);
    for (var i = 0; i <= N; i++)
    {
        results.push(hex_round(hex_lerp(a_nudge, b_nudge, step * i)));
    }
    return results;
}




function OffsetCoord(col, row) {
    return {col: col, row: row};
}

function qoffset_from_cube(offset, h)
{
    var col = h.q;
    var row = h.r + Math.trunc((h.q + offset * (h.q & 1)) / 2);
    return OffsetCoord(col, row);
}

function qoffset_to_cube(offset, h)
{
    var q = h.col;
    var r = h.row - Math.trunc((h.col + offset * (h.col & 1)) / 2);
    var s = -q - r;
    return Hex(q, r, s);
}

function roffset_from_cube(offset, h)
{
    var col = h.q + Math.trunc((h.r + offset * (h.r & 1)) / 2);
    var row = h.r;
    return OffsetCoord(col, row);
}

function roffset_to_cube(offset, h)
{
    var q = h.col - Math.trunc((h.row + offset * (h.row & 1)) / 2);
    var r = h.row;
    var s = -q - r;
    return Hex(q, r, s);
}




function Orientation(f0, f1, f2, f3, b0, b1, b2, b3, start_angle) {
	//"use strict"
    return {f0: f0, f1: f1, f2: f2, f3: f3, b0: b0, b1: b1, b2: b2, b3: b3, start_angle: start_angle};
}




function Layout(orientation, size, origin) {
    return {orientation: orientation, size: size, origin: origin};
}

var layout_pointy = Orientation(Math.sqrt(3.0), Math.sqrt(3.0) / 2.0, 0.0, 3.0 / 2.0, Math.sqrt(3.0) / 3.0, -1.0 / 3.0, 0.0, 2.0 / 3.0, 0.5);
var layout_flat = Orientation(3.0 / 2.0, 0.0, Math.sqrt(3.0) / 2.0, Math.sqrt(3.0), 2.0 / 3.0, 0.0, -1.0 / 3.0, Math.sqrt(3.0) / 3.0, 0.0);
function hex_to_pixel(layout, h)
{
	//"use strict"
    var Mas;
    //alert(layout.orientation.f0);
    Mas = layout.orientation;
    var size = layout.size;
    var origin = layout.origin;
    var x = ( Mas.f0 * h.q + Mas.f1 * h.r) * size.x;
    var y = ( Mas.f2 * h.q + Mas.f3 * h.r) * size.y;
    return Point(x + origin.x, y + origin.y);
}

function pixel_to_hex(layout, pointyi)
{
	//"use strict"
    var M = layout.orientation;
    var size = layout.size;
    var origin = layout.origin;
   // alert( pointyi.x +" | "+ origin.x +" | "+ size.x +" | "+ pointyi.y +" | "+ origin.y +" | "+ size.y );
    var pt = Point((pointyi.x - origin.x) / size.x, (pointyi.y - origin.y) / size.y);
   // alert(pt.x +" | "+pt.y);

   // alert( M.b0 +" | "+ pt.x +" | "+ M.b1 +" | "+ pt.y );
    var q = M.b0 * pt.x + M.b1 * pt.y;
   // alert( M.b2 +" | "+ pt.x +" | "+ M.b3 +" | "+ pt.y );
    var r = M.b2 * pt.x + M.b3 * pt.y;
    return Hex(q, r, -q - r);
}

function hex_corner_offset(layout, corner)
{
    var M = layout.orientation;
    var size = layout.size;
    var angle = 2.0 * Math.PI * (M.start_angle - corner) / 6;
    return Point(size.x * Math.cos(angle), size.y * Math.sin(angle));
}

function polygon_corners(layout, h)
{
    var corners = [];
    var center = hex_to_pixel(layout, h);
    for (var i = 0; i < 6; i++)
    {
        var offset = hex_corner_offset(layout, i);
        corners.push(Point(center.x + offset.x, center.y + offset.y));
    }
    return corners;
}




// Tests

function complain(name) {
    console.log("FAIL", name);
}

function equal_hex(name, a, b)
{
    if (!(a.q == b.q && a.s == b.s && a.r == b.r))
    {
        complain(name);
    }
}

function equal_offsetcoord(name, a, b)
{
    if (!(a.col == b.col && a.row == b.row))
    {
        complain(name);
    }
}

function equal_int(name, a, b)
{
    if (!(a == b))
    {
        complain(name);
    }
}

function equal_hex_array(name, a, b)
{
    equal_int(name, a.length, b.length);
    for (var i = 0; i < a.length; i++)
    {
        equal_hex(name, a[i], b[i]);
    }
}