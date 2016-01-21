    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-12">
		<h4>Добавляем товар</h4>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12">
		<form class="form-horizontal" action="/admin/products/form_valid_add" method="post">
		    <div class="form-group">
			<div class="col-sm-6">
			    <div class="row">
				<label for="seo_title" class="col-sm-4 control-label">сео заголовок</label>
				<div class="col-sm-8">
				    <input name="seo_title" id="seo_title" class="form-control"  required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="row m-top">
				<label for="seo_desc" class="col-sm-4 control-label">сео описание</label>
				<div class="col-sm-8">
				    <input name="seo_desc" id="seo_desc" class="form-control" type="text" placeholder="*необязательно для заполнения">
				</div>
			    </div>
			    <div class="row m-top">
				<label for="seo_desc" class="col-sm-4 control-label">транслит</label>
				<div class="col-sm-8">
				    <input name="translit" id="translit" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="row m-top">
				<label for="name" class="col-sm-4 control-label">название товара</label>
				<div class="col-sm-8">
				    <input name="name" id="translit" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="row m-top">
				<label for="category_id" class="col-sm-4 control-label">категория</label>
				<div class="col-sm-8">
				    <select class="form-control" name="category_id" id="category_id">
					<?php
					    foreach($categ->result() as $row){
						echo "<option value='$row->id'>$row->name</option>";
					    }
					?>
				    </select>
				</div>
			    </div>
			    <div class="row m-top">
				<label for="price" class="col-sm-4 control-label">цена товара</label>
				<div class="col-sm-3">
				    <input name="price" value="0" id="price" class="form-control" required type="text">
				</div>
			    </div>
			    <div class="row m-top">
				<div class='col-sm-2'>
				    Габариты:
				</div>
				<div class="col-sm-10">
				    <div class="row">
					<label for="width" class="col-sm-4 control-label">ширина</label>
					<div class="col-sm-4">
					    <input name="width" id="width" value='0' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
				    </div>
				    <div class="row">
					<label for="height" class="col-sm-4 control-label">высота</label>
					<div class="col-sm-4">
					    <input name="height" id="height" value='0' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
				    </div>
				    <div class="row">
					<label for="weight" class="col-sm-4 control-label">вес</label>
					<div class="col-sm-4">
					    <input name="weight" id="weight" value='0' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
				    </div>
				</div>
			    </div>
			    <div class="row m-top">
				<div class="col-sm-7">
				    <strong>
					Прикрепить загруженные изображения
				    </strong>
				</div>
				<div class="col-sm-2">
				    <div class="btn btn-primary" data-toggle="modal" data-target="#attach_img">
					Открыть
				    </div>
				</div>
			    </div>
			</div>
			<div class="col-sm-6">
			    <div class="row">
				<label for="photo" class="col-sm-4 control-label">изображение</label>
				<div class="col-sm-7">
				    <select class="form-control" name="photo" id="photo">
					<option value="0">Нет изображения</option>
					<?php
					    foreach($img->result() as $row){
						echo "<option data-name='$row->name' value='$row->id'>$row->name</option>";
					    }
					?>
				    </select>
				</div>
			    </div>
			    <div class="row">
				<div class="col-sm-offset-4 col-sm-7">
				    <img id="img" src="" alt="" class="img-responsive" />
				</div>
			    </div>
			</div>
		    </div>
		    <div class="form-group">
			<label for="description" class="col-sm-offset-1 col-sm-10 control-label" style="text-align: left;">содержимое страницы</label>
			<div class="col-sm-offset-1 col-sm-10">
			    <textarea rows="10" name="description" id="description" class="form-control" required type="text" placeholder="*обязательно для заполнения"></textarea>
			</div>
		    </div>
		    <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			    <button type="submit" class="btn btn-default">Добавить</button>
			</div>
		    </div>
		    <div class="modal fade" id="attach_img" tabindex="-1" role="dialog" >
			<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				    <h4 class="modal-title" id="myModalLabel">Изображения</h4>
				</div>
				<div class="modal-body">
				    <div class="row">
					<div class="col-sm-7">
					    <select class="form-control" style="height: 400px;" multiple name="imgs[]" id="imgs">
						<?php
						    foreach($img->result() as $row){
							if($row->id!=0){
							    echo "<option data-name='$row->name' value='$row->id'>$row->name</option>";
							}
						    }
						?>
					    </select>
					</div>
					<div class="col-sm-5">
					    <center>
						<img style="max-width: 100%;" src="" id="prev_img" alt="" />
					    </center>
					</div>
				    </div>
				</div>
				<div class="modal-footer">
				    <button type="button" onclick="$('#imgs option:selected').removeAttr('selected');" class="btn btn-default" data-dismiss="modal">Отмена</button>
				    <button type="button" onclick="$('#attach_img').modal('hide');" class="btn btn-primary">Прикрепить</button>
				</div>
			    </div>
			</div>
		    </div>
		</form>
	    </div>
	</div>
    </div>
</div>
<style type="text/css">
    .m-top{
	margin-top: 20px;
    }
</style>
<script type="text/javascript">
$("#imgs").on("change",function(){
    var selectedValues = [];
    $("#imgs :selected").each(function(){
        selectedValues.push($(this).val()); 
    });
    if(selectedValues.length===1){
	$("#prev_img").attr("src","/uploads/images/"+$("#imgs :selected").text());
    }else{
	$("#prev_img").attr("src","");
    }
});
$("#photo").on("change",function(){
    if(parseInt($("#photo :selected").val())===0){
	$("#img").attr("src","");
    }else{
	$("#img").attr("src","<?php echo base_url();?>uploads/images/"+$("#photo :selected").text());
    }
});
</script>