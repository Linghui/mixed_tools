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
        <div class="row">
          <div class="col-sm">
              <div class="alert alert-primary" role="alert">
                  This is a primary alert—check it out!
                </div>
                <h1>Example heading <span class="badge badge-secondary">New</span></h1>
          </div>
          <div class="col-sm">
              <button type="button" class="btn btn-primary btn-lg" onclick="jsonp()">Ajax</button>
          </div>
          <div class="col-sm">
              <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown button
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </div>
          </div>
        </div>

        <div class="row">
           <div class="col-sm">
               <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">

                   <ul class="list-group">
                      <li class="list-group-item">Cras justo odio</li>
                      <li class="list-group-item">Dapibus ac facilisis in</li>
                      <li class="list-group-item">Morbi leo risus</li>
                      <li class="list-group-item">Porta ac consectetur ac</li>
                      <li class="list-group-item">Vestibulum at eros</li>
                    </ul>
           </div>
           <div class="col-sm">
               <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
           </div>
           <div class="col-sm">
             One of three columns
           </div>
         </div>
    </div>

</body>
</html>
