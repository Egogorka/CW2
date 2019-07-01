<!-- Header + footer -->

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        <?="Hello";?>
    </title>

    <link rel="stylesheet" href="/css/index.css">

</head>

<body>

    <header>

        <?=$this->insert("layouts/main/header")?>

    </header>

    <div id="container">

        <?=$this->section("content")?>

    </div>

    <footer>
        Foot
    </footer>

</body>

</html>