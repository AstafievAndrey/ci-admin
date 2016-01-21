    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-12">
		<h4>Редактируем страницу</h4>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12">
		<form class="form-horizontal" action="/admin/products/form_valid_edit" method="post">
		    <input name="id" type="hidden" value="<?=$product->id?>"/>
		    <input name="old_translit" type="hidden" value="<?=$product->translit?>"/>
		    <div class="row">
			<div class="col-sm-6">
			    <div class="form-group">
				<label for="seo_title" class="col-sm-4 control-label">сео заголовок</label>
				<div class="col-sm-8">
				    <input name="seo_title" id="seo_title" value="<?=$product->seo_title?>" class="form-control"  required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="seo_desc" class="col-sm-4 control-label">сео описание</label>
				<div class="col-sm-8">
				    <input name="seo_desc" id="seo_desc" value="<?=$product->seo_desc?>" class="form-control" type="text" placeholder="*необязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="seo_desc" class="col-sm-4 control-label">транслит</label>
				<div class="col-sm-8">
				    <input name="translit" id="translit" value="<?=$product->translit?>" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="name" class="col-sm-4 control-label">заголовок страницы</label>
				<div class="col-sm-8">
				    <input name="name" id="name" value="<?=$product->name?>" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="category_id" class="col-sm-4 control-label">категория</label>
				<div class="col-sm-8">
				    <select class="form-control" name="category_id" id="category_id">
					<?php
					    foreach($categ->result() as $row){
						echo ($row->id==$product->category_id) 
						? "<option selected value='$row->id'>$row->name</option>"
						: "<option value='$row->id'>$row->name</option>";
					    }
					?>
				    </select>
				</div>
			    </div>
			    <div class="row m-top">
				<label for="price" class="col-sm-4 control-label">цена товара</label>
				<div class="col-sm-3">
				    <input name="price" value="<?=$product->price?>" id="price" class="form-control" required type="text">
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
					    <input name="width" id="width" value='<?=$product->width?>' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
				    </div>
				    <div class="row">
					<label for="height" class="col-sm-4 control-label">высота</label>
					<div class="col-sm-4">
					    <input name="height" id="height" value='<?=$product->height?>' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
				    </div>
				    <div class="row">
					<label for="weight" class="col-sm-4 control-label">вес</label>
					<div class="col-sm-4">
					    <input name="weight" id="weight" value='<?=$product->weight?>' class="form-control" required type="text" placeholder="*обязательно для заполнения">
					</div>
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
						if($row->id==$product->photo){
						    echo "<option selected data-name='$row->name' value='$row->id'>$row->name</option>";
						    $photo=$row->name;
						}else{
						    echo "<option data-name='$row->name' value='$row->id'>$row->name</option>";
						}
					    }
					?>
				    </select>
				</div>
			    </div>
			    <div class="row">
				<div class="col-sm-offset-4 col-sm-7">
				    <?php
					if(isset($photo)){
					    echo '<img id="img" src="'.  base_url().'uploads/images/'.$photo.'" alt="" class="img-responsive" />';
					}else{
					    echo '<img id="img" src="" alt="" class="img-responsive" />';
					}
				    ?>
				</div>
			    </div>
			</div>
			<div class="col-sm-12">
			    <div class="modal fade" id="attach_img" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
					<div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					    <h4 class="modal-title" id="myModalLabel">Добавить изображения</h4>
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
			    <div class="modal fade" id="view_img" tabindex="-1" role="dialog" >
				<div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
					<div id="load-1">
					    <div class="spinner">
						<div class="double-bounce1"></div>
						<div class="double-bounce2"></div>
					    </div>
					</div>
					<div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					    <h4 class="modal-title" id="myModalLabel">Прикрепленные изображения</h4>
					</div>
					<div class="modal-body">
					    <div class="row">
						<div class="col-sm-7" style="max-height: 400px; overflow: auto;">
						    <?php
							foreach($attach_img->result() as $row){
						    ?>
						    <div class="row" style="margin-top: 5px;">
							<div class="col-sm-10 click_name_img" data-name='<?php echo $row->name;?>'>
							    <?php echo $row->name;?>
							</div>
							<div class="col-sm-2">
							    <div class="btn btn-primary remove-img" data-id="<?php echo $row->file_id;?>">
								убрать
							    </div>
							</div>
						    </div>
						    <?php
							}
						    ?>
						</div>
						<div class="col-sm-5">
						    <center>
							<img style="max-width: 100%;" src="" id="prev_img_view" alt="" />
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
			    Количество прикрепленных фото: <span id="count"><?php echo count($attach_img->result());?></span>
			    <div class="btn btn-primary" data-toggle="modal" data-target="#view_img">просмотреть</div>
			    <div class="btn btn-primary" data-toggle="modal" data-target="#attach_img">добавить</div>
			</div>
		    </div>
		    <div class="form-group">
			<label for="description" class="col-sm-offset-1 col-sm-10 control-label" style="text-align: left;">содержимое страницы</label>
			<div class="col-sm-offset-1 col-sm-10">
			    <textarea rows="10" name="description" id="description" class="form-control" required type="text" placeholder="*обязательно для заполнения"><?=$product->description?></textarea>
			</div>
		    </div>
		    <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			    <button type="submit" class="btn btn-default">Отредактировать</button>
			</div>
		    </div>
		</form>
	    </div>
	</div>
    </div>
</div>
<style type="text/css">
    #load-1{
	position: absolute; 
	width: 100%;
	height: 100%;
	z-index: 99;
	background: rgba(255,255,255,0.6);
	border-radius: 6px;
	display: none;
    }
    .spinner {
	width: 40px;
	height: 40px;

	position: relative;
	margin: 20% auto;
    }

    .double-bounce1, .double-bounce2 {
	width: 100%;
	height: 100%;
	border-radius: 50%;
	background-color: #333;
	opacity: 0.6;
	position: absolute;
	top: 0;
	left: 0;
	-webkit-animation: sk-bounce 2.0s infinite ease-in-out;
	animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
	-webkit-animation-delay: -1.0s;
	animation-delay: -1.0s;
    }

    @-webkit-keyframes sk-bounce {
	0%, 100% { -webkit-transform: scale(0.0) }
	50% { -webkit-transform: scale(1.0) }
    }

    @keyframes sk-bounce {
	0%, 100% { 
	  transform: scale(0.0);
	  -webkit-transform: scale(0.0);
	} 50% { 
	  transform: scale(1.0);
	  -webkit-transform: scale(1.0);
	}
    }
    .click_name_img{
	cursor: pointer;
	background: whitesmoke;
	padding: 5px 15px;
    }
</style>
<script type="text/javascript">
$(".remove-img").on("click",function(){
    var rm=$(this);
    $("#load").show();
    $.ajax({
	url:"/admin/products/delete_product_file",
	method: "post",
	data: "id="+$(this).data("id"),
	success:function(html){
	    console.log(html);
	    if(parseInt(html)===1){
		rm.parent().parent().remove();
		$("#count").text(parseInt($("#count").text())-1);
		$("#load").hide();
	    }else{
		$("#load").hide();
	    }
	}
    });
});
$(".click_name_img").on("click",function(){
    $("#prev_img_view").attr("src","/uploads/images/"+$(this).data("name"));
});
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
	$("#img").attr("src","/uploads/images/"+$("#photo :selected").text());
    }
});
</script>