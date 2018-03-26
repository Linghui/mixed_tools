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
        <h1>数据库迁移系统</h1>
        <hr>
        <a role="button" class="btn btn-secondary btn-lg" href="/index.php/main/new_database">添加数据库</a>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <form class="navbar-form" role="search">
                    <label >牵出数据库 : </label>
                    <select id="from" class="form-control" onchange="on_search()">
                        <?php
                        $index = 0;
                        foreach ($databases as $one): ?>
                            <option value="<?php echo $index ?>"><?php echo $one['database_name'] ?></option>
                        <?php ++$index; endforeach; ?>

                      </select>
                </form>
            </div>

                <div class="col-md-3">
                    <form class="navbar-form" role="search">
                        <label >迁入数据库 : </label>
                        <select id="to" class="form-control" >
                            <?php
                            $index = 0;
                            foreach ($databases as $one): ?>
                                <option value="<?php echo $index ?>"><?php echo $one['database_name'] ?></option>
                            <?php ++$index; endforeach; ?>
                          </select>
                    </form>
                </div>
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-lg" onclick="search()">查询</button>
        <button type="button" class="btn btn-info btn-lg" onclick="add_database()">添加迁移</button>
        <hr>

    </div>

    <script type="text/javascript">
        function add_database() {
            console.log("add_database");
            var from = $("#from").val();
            console.log("from " + from);
            var to = $("#to").val();
            console.log("to " + to);
            if(from == to){
                alert("不能向同数据库进行迁移");
                return;
            }
            window.location.href="/index.php/main/new_mig?from="+from+"&to="+to;
        }

        function search() {
            var from = $("#from").val();
            console.log("from " + from);
            var to = $("#to").val();
            console.log("to " + to);


            $.ajax({
                url: "/index.php/api/search",
                dataType: "json",
                success: function(response) {
                    console.log("success");
                },
                error: function(response) {
                    console.log("error");
                }
            });
        }
    </script>

</body>
</html>
