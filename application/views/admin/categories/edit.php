    <div class="col-md-10 col-sm-9 cont">
	<div class="row">
	    <div class="col-sm-12">
		<h4>Редактируем категорию</h4>
	    </div>
	</div>
	<div class="row">
	    <div class="col-sm-12">
		<form class="form-horizontal" action="/admin/categories/form_valid_edit" method="post">
		    <input name="id" type="hidden" value="<?=$category->id?>"/>
		    <input name="old_translit" type="hidden" value="<?=$category->translit?>"/>
		    <div class="row">
			<div class="col-sm-6">
			    <div class="form-group">
				<label for="seo_title" class="col-sm-4 control-label">сео заголовок</label>
				<div class="col-sm-8">
				    <input name="seo_title" id="seo_title" value="<?=$category->seo_title?>" class="form-control"  required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="seo_desc" class="col-sm-4 control-label">сео описание</label>
				<div class="col-sm-8">
				    <input name="seo_desc" id="seo_desc" value="<?=$category->seo_desc?>" class="form-control" type="text" placeholder="*необязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="seo_desc" class="col-sm-4 control-label">транслит</label>
				<div class="col-sm-8">
				    <input name="translit" id="translit" value="<?=$category->translit?>" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			    <div class="form-group">
				<label for="name" class="col-sm-4 control-label">название категории</label>
				<div class="col-sm-8">
				    <input name="name" id="name" value="<?=$category->name?>" class="form-control" required type="text" placeholder="*обязательно для заполнения">
				</div>
			    </div>
			</div>
		    </div>
		    <div class="form-group">
			<label for="description" class="col-sm-offset-1 col-sm-10 control-label" style="text-align: left;">краткое</label>
			<div class="col-sm-offset-1 col-sm-10">
			    <textarea rows="10" name="description" id="description" class="form-control" required type="text" placeholder="*обязательно для заполнения"><?=$category->description?></textarea>
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