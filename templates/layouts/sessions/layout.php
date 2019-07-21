<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Session</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/session.css">

    <!--<script src="/dist/require.js"></script>-->

</head>

<body>

    <header style="z-index: 200">
        <?=$this->insert("layouts/sessions/header")?>
    </header>

    <div style="z-index: 1">
    <?=$this->section("content")?>
    </div>

    <footer style="z-index: 200;"> Egogorka's Mastership </footer>

</body>

</html>
