<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script>
        window.pfinaljs = {};
        window.pfinaljs.base = 'modules/pfinaljs';
    </script>
    <script src="modules/pfinaljs/require.js"></script>
    <script src="modules/pfinaljs/config.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
	<a class="navbar-brand" href="#">Title</a>
	<ul class="nav navbar-nav">
		<li class="active">
			<a href="#"><i class="fa fa fa-video-camera fa-lg"></i> 课程列表</a>
		</li>
		<li>
			<a href="#"> <i class="fa fa-user-circle fa-lg"></i> 关于我们</a>
		</li>
	</ul>
</nav>
<section>
    <div class="container">
    	<div class="panel panel-default">
    		  <div class="panel-heading">
    				<h3 class="panel-title">视频列表</h3>
    		  </div>
    		  <div class="panel-body">
                  <div class="row">
                      <div class="col-xs-6 col-md-3">
                          <a href="#" class="thumbnail">
                              <img src="..." alt="...">
                          </a>
                      </div>
                      ...
                  </div>
    		  </div>
    	</div>
    </div>
</section>
</body>
<script>
    require(['pfinaljs','bootstrap'])
</script>
</html>