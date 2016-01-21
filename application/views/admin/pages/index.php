    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-3">
		<a href="/admin/pages/add">Добавить страницу</a>
	    </div>
	</div>
	<div class="row" style="margin: 4px 5px;">
	    <div class="col-sm-5"><strong>Название статьи</strong></div>
	    <div class="col-sm-2"><strong>Категория</strong></div>
	</div>
	<?php
	    foreach ($pages->result() as $row){
	?>
	<div class="row" style="background: whitesmoke;margin: 4px 5px;padding: 15px;">
	    <div class="col-sm-5">
		<?php echo $row->title;?>
	    </div>
	    <div class="col-sm-2">
		<?php echo $row->category_name;?>
	    </div>
	    <div class="col-sm-3">
		<a href="/admin/pages/edit/<?=$row->id?>">Редактировать</a>
		<a href="/admin/pages/delete/<?=$row->id?>" style="color:red;">Удалить</a>
	    </div>
	</div>
	<?php
	    }
	?>
	<div class="row" style="text-align: center;">
	    <?php echo $pag;?>
	</div>
    </div>
</div>


