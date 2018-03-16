<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <title>Document</title>

    <script>
        var $load = 'Ola Mundo!';

        function processAjaxData(response, urlPath){
            document.getElementById("content").innerHTML = response.html;
            document.title = response.pageTitle;
            window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
        }
    </script>
</head>
<body>
<div id="content"></div>
<div class="test" style="display:block;background: #000;width: 500px;height: 400px;"></div>
<script>

    function XMLHR() {
        var $xmlhttp = new XMLHttpRequest();
        $xmlhttp.open('GET','http://my.mvc/user',true);
        $xmlhttp.addEventListener('load',transferComplete,true);

        $xmlhttp.send();
    }


    function transferComplete(evt) {
        alert("A transferência foi concluída.");
        return evt.srcElement.response;
    }
</script>
<?php $sv_js?>
</body>
</html>
