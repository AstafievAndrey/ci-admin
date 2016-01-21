    <div class="col-md-10 col-sm-9">
	<div class="row">
	    <div class="col-sm-12">
		<h4>Загрузка файлов</h4>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12">
		<form class="form-horizontal"action="/admin/files/download_upl" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		    <div class="form-group">
			<label for="type" class="col-sm-2 control-label">тип файла</label>
			<div class="col-sm-4">
			    <select name="type" id="type" class="form-control">
				<option selected value="img">Изображение</option>
				<option value="doc">Документ</option>
			    </select>
			</div>
		    </div>
		    <div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
			    <input required id="files" multiple type="file" name="files[]" accept=".png,.jpg,.jpeg"/>
			</div>
		    </div>
		    <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			    <button type="submit" class="btn btn-default">Загрузить</button>
			</div>
		    </div>
		</form>
		<script type="text/javascript">
		    $("#type").on("change",function(){
			switch($(this).val()){
			    case "doc": 
				$("#files").attr("accept",".pdf,.doc,.docx,.xls");
				break;
			    case "img": 
				$("#files").attr("accept",".png,.jpg,.jpeg");
				break;
			}
		    });
		</script>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12" style='color:red;'>
		<h4>Максимальный размер изображения 250кб расширение максимум 1024х768</h4>
		<h4>Максимальный размер документа 2048кб</h4>
	    </div>
	</div>
    </div>
</div>