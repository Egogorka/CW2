<html lang="ru">
<head>
    <title>MapEditor</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/mapeditor.css">
</head>
<body>

<div id="tool_box" class="shadow">
    <div id="img_select_box" class="shadow">
        <img id="img_select" alt="Something happend" src="/images/mapStuff/hexagons/neutral.png">
        <span style="text-align: center; padding: 5px;"><button id="img_left"> &lt; </button> <button id="img_right"> &gt; </button></span>
    </div>
    <div id="buttons_box" class="shadow">
        <button>LOAD</button>
        <button>SAVE</button>
    </div>
    <div id="placement_tools_box" class="shadow">
        <img class="tools" alt="1s" src="/images/mapStuff/mapsymmetry1.png" data-symmetry="1">
        <img class="tools" alt="2s" src="/images/mapStuff/mapsymmetry2.png" data-symmetry="2">
        <img class="tools" alt="3s" src="/images/mapStuff/mapsymmetry3.png" data-symmetry="3">
    </div>
</div>

<div id="MapBoard"></div>

<script src="/dist/mapEditor.bundle.js"></script>

</body>
</html>