    <div class="col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-12">
		Общее количество страниц: <span><?php echo $countPages->count;?></span>
	    </div>
	    <div class="col-sm-12">
		Из них:
		<ul>
		    <?php
			foreach($countCategory->result() as $row){
			    echo "<li>".$row->name.": ".$row->count."</li>";
			}
		    ?>
		</ul>
	    </div>
	     <div class="col-sm-12">
		Общее количество товаров: <span><?php echo $countProducts->count;?></span>
	    </div>
	    <div class="col-sm-12">
		Из них:
		<ul>
		    <?php
			foreach($countCategoryProducts->result() as $row){
			    echo "<li>".$row->name.": ".$row->count."</li>";
			}
		    ?>
		</ul>
	    </div>
	    <div class="col-sm-12">
		Общее количество файлов: <span><?php echo $countFiles->count;?></span>
	    </div>
	    <div class="col-sm-12">
		Из них:
		<ul>
		    <?php
			foreach($countFilesType->result() as $row){
			    switch ($row->type){
				case "img":
				    echo "<li>Изображений: ".$row->count."</li>";
				    break;
				case "doc":
				    echo "<li>Документов: ".$row->count."</li>";
				    break;
				case "vid":
				    echo "<li>Видео: ".$row->count."</li>";
				    break;
			    }
			}
		    ?>
		</ul>
	    </div>
	</div>
    </div>
</div>

