    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-12">
		<a href="/admin/files/download">Залить файлы</a>
	    </div>
	</div>
	    <?php
		foreach($files->result() as $row){
		    if((int)$row->id!=0){
			echo '<div class="row" style="background: whitesmoke;margin:15px;padding:15px;">';
			    switch ($row->type){
				case "img":
				    echo "<div class='col-md-1 col-sm-2'>";
					echo "<img class='img-responsive' src='/uploads/images/".$row->name."'>";
				    echo "</div>";
				    echo "<div class='col-md-2 col-sm-3 pad-top'>Изображение</div>";
				    echo "<div class='col-md-3 col-sm-4 pad-top'>".$row->name."</div>";
				    echo	"<div class='col-sm-2 pad-top'>"
						. "<a href='/admin/files/delete/".$row->id."' style='color:red;padding-right:10px;'>Удалить</a>"
						//. "<a href='/uploads/images/".$row->name."'>Скачать</a>"
					    . "</div>";
				    break;
				case "doc":
				    echo "<div class='col-md-1 col-sm-2'>";
					echo "<img class='img-responsive' src='/uploads/images/document.png'>";
				    echo "</div>";
				    echo "<div class='col-md-2 col-sm-3 pad-top'>Документ</div>";
				    echo "<div class='col-md-3 col-sm-4 pad-top'>".$row->name."</div>";
				    echo	"<div class='col-sm-2 pad-top'>"
						. "<a href='/admin/files/delete/".$row->id."' style='color:red;padding-right:10px;'>Удалить</a>"
						. "<a href='/uploads/docs/".$row->name."'>Скачать</a>"
					    . "</div>";
				    break;
			    }
			echo "</div>";
		    }
		}
	    ?>
	<style type="text/css">
	    .pad-top{
		padding-top:15px;
	    }
	</style>
	<div class="row" style="text-align: center;">
	    <?php echo $pag;?>
	</div>
    </div>
</div>



