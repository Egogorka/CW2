<?php

session_start();

?>

<html lang="en">
    <head>
        <title>Testing ground</title>
    </head>
    <body>

    <button id="buttonWS">Click me</button>

    <script>
        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

        let ws = new WebSocket("ws://erem.sesc2018.dev.sesc-nsu.ru:8000");
        ws.onmessage = function (evt) {
            alert(evt.data);
        };
        ws.onopen=function(evt){
            ws.send(JSON.stringify({
                type : 0,
                data : {
                    cookie : getCookie("PHPSESSID"),
                    userId : <?=$_SESSION["user-id"] ?? "null"?>
                }
            }));
            //setTimeout(function(){ws.close();}, 1000);
        };
        document.getElementById("buttonWS").addEventListener("click", function (evt) {
            ws.send(JSON.stringify({
                type : 1,
                data: "TestMessage"
            }));
        });

    </script>
    </body>
</html>