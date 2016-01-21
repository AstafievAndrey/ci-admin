<div class="container-fluid">
    <div class="row">
	<div class="col-md-2 col-sm-3 sidebar">
	    <div class="row">
		    <a href="/admin">Главная</a>
	    </div>
	    <div class="row">
		    <a href="/admin/pages">Страницы</a>
	    </div>
	    <div class="row">
		    <a href="/admin/products">Товары</a>
	    </div>
	    <div class="row">
		    <a href="/admin/files">Файлы</a>
	    </div>
	</div>
	
    <script type="text/javascript">
	$(document).ready(function(){
	    $(".sidebar").css("height",window.innerHeight+"px");
	    $(".cont").css("height",window.innerHeight+"px");
	    $(".cont").css("overflow","auto");
	});
    </script>
    <style type="text/css">
	.sidebar{
	    background: #2D2D2D;
	}
	.sidebar a:hover{
	    text-decoration: none;
	    background: #252525;
	}
	.sidebar a{
	    padding: 10px 15px;
	    display: block;
	    width: 100%;
	    color:white;
	    text-transform: uppercase;
	    font-size: 14px;
	    margin: 0 0 1px;
	    box-shadow: 0 0 0 1px white;
	}
    </style>
