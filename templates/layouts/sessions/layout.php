<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Session</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/session.css">

    <!--<script src="/dist/require.js"></script>-->
    <script src="/javascript/external/jsFrame.js"></script>
    <script src="https://kit.fontawesome.com/2483e0511a.js"></script>

</head>

<body>

<script>
    /**
     * @external JSFrame
     * @see {@link https://riversun.github.io/jsframe/jsframe.js JSFrame }
     * @type {JSFrame}
     */
    const mainJsFrame = new JSFrame({
        fixed : true,
        parentElement : document.getElementById("window-holder"),
    });

</script>

<div style="z-index: 0">
    <header style="z-index: 200">
        <?=$this->insert("layouts/sessions/header")?>
    </header>

    <div style="z-index: 1">
    <?=$this->section("content")?>
    </div>

    <footer style="z-index: 200;"> Egogorka's Mastership </footer>
    </div>


</body>

</html>
