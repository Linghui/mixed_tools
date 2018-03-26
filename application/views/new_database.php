<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="/js/common.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>添加数据库</h1>
        <hr>
        <form action="/index.php/main/add_database" onsubmit="return validate_form()" method="post" enctype="multipart/form-data">
          <div class="form-group">
              <label for="database_name">数据库名称</label>
              <input name="database_name" type="text" class="form-control" id="database_name" placeholder="database_name">
          </div>

          <div class="form-group">
              <label for="database_address">数据库地址</label>
              <input name="database_address" type="text" class="form-control" id="database_address" placeholder="database_address">
          </div>


            <div class="form-group">
                <label for="username">用户名</label>
                <input name="username" type="text" class="form-control" id="username" placeholder="username">
            </div>


            <div class="form-group">
                <label for="password">密码</label>
                <input name="password" type="password" class="form-control" id="password" >
            </div>

          <button type="submit" class="btn btn-primary btn-lg">提交</button>
        </form>
    </div>

    <script type="text/javascript">
    function validate_form() {
        console.log("validate_form");

        var list = ["database_name", "database_address", "username", "password"];
        for(var index = 0; index < list.length; index++){
            var field = $("#" + list[index]).val();
            if(field == null || field == ""){
                alert(list[index] + "不可为空");
                return false;
            }
        }
        return true;

    }
    </script>
</body>
</html>
