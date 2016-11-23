<?php

if ($action == 'edit') {

	$row = $subCategoryObj->find($id);

}

if (isset($_POST['title'])) {

	if ($action == 'add') {

		$subCategoryObj->add();

	} else {

		$subCategoryObj->update($id);

	}

}

?>

<h1>SUB CATEGORY</h1>

    <form class="form-horizontal" method="post" action="">

                        <div class="panel panel-default">
                        <div class="panel-heading"><?=strtoupper($action)?> SUB CATEGORY</div>
                        <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Title</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="title" value="<?php if (isset($row)) {print $row->title;}?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Meta Title</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="meta_title" value="<?php if (isset($row)) {print $row->meta_title;}?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Meta Keywords</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="meta_keywords" value="<?php if (isset($row)) {print $row->meta_keywords;}?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Meta Description</label>
                                    <div class="col-md-6">
                                        <textarea style="height:120px" class="form-control" name="meta_description"><?php if (isset($row)) {print $row->meta_description;}?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">SEO Text</label>
                                    <div class="col-md-6">
                                        <textarea style="height:400px" class="form-control" name="seo_text"><?php if (isset($row)) {print $row->seo_text;}?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Order</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="order" value="<?php if (isset($row)) {print $row->order;}?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Category</label>
                                    <div class="col-md-6">

                                        <select class="form-control" name="category_id">

                                        <?php

foreach ($categoryObj->getAll() as $category) {

	$selected = $category->id == $row->category_id ? 'selected' : '';

	print "<option value='" . $category->id . "' $selected>" . $category->title . "</option>";

}

?>

                                        </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary"> <?=strtoupper($action)?> SUB CATEGORY </button>
                                    </div>
                                </div>

                        </div>
                    </div>


    </form>

