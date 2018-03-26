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
        <h1>添加数据库迁移</h1>
        <hr>
        <!-- <form  method="post" enctype="multipart/form-data"> -->
          <div class="form-group">
              <label for="from">迁出数据库: </label>
              <input name="from" type="text" class="form-control"  value="<?php echo $from_database['database_name'] ?>" disabled="disabled" >
              <input id="from" type="hidden" class="form-control"  value="<?php echo $from_database['id'] ?>" >
          </div>

          <div class="form-group">
              <label for="to">迁入数据库:</label>
              <input name="to" type="text" class="form-control"  value="<?php echo $to_database['database_name'] ?>" disabled="disabled" >
              <input id="to" type="hidden" class="form-control"  value="<?php echo $to_database['id'] ?>" >
          </div>

          <div id="tables" class="btn-group-toggle" data-toggle="buttons">

              <?php
              $index = 0;
               foreach ($tables as $one): ?>

                  <label class="btn btn-primary ">
                    <input id="table" name="table" type="checkbox" value="<?php echo $index ?>"  autocomplete="off"> <?php echo $one ?>
                  </label>

              <?php ++$index; endforeach; ?>

          </div>
          <br>
          <button type="button" onclick="submit()" class="btn btn-primary btn-lg">提交</button>
        <!-- </form> -->
    </div>

    <script type="text/javascript">
    function submit() {

        var chk_value =[];//定义一个数组
        $('input[name="table"]:checked').each(function(){//遍历每一个名字为interest的复选框，其中选中的执行函数
        chk_value.push($(this).val());//将选中的值添加到数组chk_value中
        });
        console.log("validate_form " + chk_value);
        if(chk_value == "" || chk_value == null){
            alert('请选择需要迁出的表解构');
            return false;
        }
        var from = $("#from").val();
        var to = $("#to").val();

        window.location.href="/index.php/main/add_mig?from="+from+"&to="+to+"&tables="+chk_value;

    }
    function validate_form() {

        var chk_value =[];//定义一个数组
        $('input[name="table"]:checked').each(function(){//遍历每一个名字为interest的复选框，其中选中的执行函数
        chk_value.push($(this).val());//将选中的值添加到数组chk_value中
        });
        console.log("validate_form " + chk_value);
        if(chk_value == "" || chk_value == null){
            alert('请选择需要迁出的表解构');
            return false;
        }





        return true;

        // var list = ["database_name", "database_address", "username", "password"];
        // for(var index = 0; index < list.length; index++){
        //     var field = $("#" + list[index]).val();
        //     if(field == null || field == ""){
        //         alert(list[index] + "不可为空");
        //         return false;
        //     }
        // }
        // return true;

    }
    </script>
</body>
</html>
