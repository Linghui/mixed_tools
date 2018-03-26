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
                    <select id="from" class="form-control">
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

        <table class="table" id="job_list">

        </table>


        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">详细</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div id="content" class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

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

        function showDetail(content) {
            console.log("content " + content);
            if(content == null){
                content="操作详细内容";
            }
            $("#content").html(content);
            $("#detailModal").modal('show');

        }

        function search() {
            var from = $("#from").val();
            console.log("from " + from);
            var to = $("#to").val();
            console.log("to " + to);


            $.ajax({
                url: "/index.php/api/search?from="+from+"&to="+to,
                dataType: "json",
                success: function(response) {
                    console.log("success");

                    if(response.c == 0){
                        var html = '';
                        for(var index = 0; index< response.d.length; index++){
                            console.log(" ok " + response.d[index].table_name);
                            html += "<tr onclick='showDetail(\""+response.d[index].content+"\")'>";
                            html += "<td>";
                            html += response.d[index].table_name;
                            html += "</td>";

                            var newDate = new Date();
                            newDate.setTime(response.d[index].create_date * 1000);

                            html += "<td> 创建时间:";
                            html += newDate.toLocaleDateString() + " " + newDate.toLocaleTimeString();
                            html += "</td>";


                            html += "<td> 状态:";
                            if(response.d[index].status <= 10){
                                html+="未启动";
                            } else if (response.d[index].status <= 60){
                                html+="进行中";
                            } else if (response.d[index].status <= 90){
                                html+="校验中";
                            }else{
                                html+="已完成";
                            }
                            html += "</td>";

                            html += "</tr>";
                        }
                        $("#job_list").html(html);


                    } else {
                        alert('未查找到数据');
                    }
                },
                error: function(response) {
                    console.log("error");
                }
            });
        }
    </script>

</body>
</html>
