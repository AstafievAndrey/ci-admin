    <div class="col-md-10 col-sm-9">
	<div class="row">
	    <div class="col-sm-12">
		<h4>Вы действительно хотите удалить запись:<br>"<?=$product->name?>"?</h4>
	    </div>
	    <div class="col-sm-12">
		<?php
		    if(isset($_SERVER["HTTP_REFERER"])&&(strpos($_SERVER["HTTP_REFERER"], base_url()."admin/products"))
			&&!(strpos($_SERVER["HTTP_REFERER"], base_url()."admin/products/delete"))){
		?>
			<a href="<?php echo $_SERVER["HTTP_REFERER"];?>">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> 
			    Вернуться обратно
			</a>
		<?php
		    }
		?>
	    </div>
	    <div class="col-sm-12">
		<form class="form-inline" method="post">
		    <?php
			if(isset($_SERVER["HTTP_REFERER"])&&(strpos($_SERVER["HTTP_REFERER"], base_url()."admin/products"))
			    &&!(strpos($_SERVER["HTTP_REFERER"], base_url()."admin/products/delete"))){
			    echo "<input name='redirect' type='hidden' value='".$_SERVER["HTTP_REFERER"]."' />";
			}else{
			    echo "<input name='redirect' type='hidden' value='/admin/products' />";
			}
		    ?>
		    <input name="id" type="hidden" value="<?=$id?>" />
		    <div class="form-group">
			<input type="radio" name="delete" id="optionsRadios1" value="1" checked>
			да
		    </div>
		    <div class="form-group">
			<input type="radio" name="delete" id="optionsRadios1" value="0">
			нет
		    </div>
		    <br />
		    <button type="submit" class="btn btn-default">Отправить</button>
		</form>
	    </div>
	</div>
    </div>
</div>