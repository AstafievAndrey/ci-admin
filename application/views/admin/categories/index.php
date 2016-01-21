    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-3">
		<a href="/admin/categories/add">Добавить категорию</a>
	    </div>
	</div>
	<div class="row" style="margin: 4px 5px;">
	    <div class="col-sm-5"><strong>Название Категории</strong></div>
	</div>
	<?php
	    foreach ($categories->result() as $row){
	?>
	<div class="row" style="background: whitesmoke;margin: 4px 5px;padding: 15px;">
	    <div class="col-sm-7">
		<?php echo $row->name;?>
	    </div>
	    <div class="col-sm-3">
		<a href="/admin/categories/edit/<?=$row->id?>">Редактировать</a>
		<a href="/admin/categories/delete/<?=$row->id?>" style="color:red;">Удалить</a>
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


