<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script>
    function suan() {

            var big = $("#big").val();
            var small = $("#small").val();
            $.ajax({
                url: "/index.php/chuitou/api?big="+encodeURIComponent(big) + "&small="+encodeURIComponent(small),
                dataType: "json",
                success: function(response) {
                    console.log("success");
                    if(response.c != 0){
                        alert(response.m);
                        return;
                    }
                    $("#output").html(response.d);
                },
                error: function(response) {
                    console.log("error");
                }
            });
    }
    </script>
    <div class="container">
        <br>
        <h1>算的就是好</h1>

        <hr>
        <p style="width:100%">
        数据用逗号分隔，大10，小18<br/>
        例子:<br/>
        90.6,90.8,95.6,96.2,96.6,97.4,101.6,101.8,102.4,109.8<br/>
        55,55.4,55.6,55.6,55.8,56,56.2,56.4,56.4,56.6,56.8,57,57.2,57.4,57.4,57.6,57.6,58<br/>
        </p>
        <br/>
        <h3>大锤头 10个</h3>
        <input id="big" type="text" class="form-control" placeholder="大锤头">
        <h3>小锤头 18个</h3>
        <input id="small" type="text" class="form-control" placeholder="小锤头">
        <br/>
        <button type="button" class="btn btn-primary btn-lg" onclick="suan()">算</button>
        <div id="output" class="">

        </div>
    </div>

</body>
</html>
