<?php	

namespace App;

class SubCategory extends ObjectModel
{

    protected $table = 'sub_categories';
    protected $fillable = ['title', 'meta_title', 'meta_keywords', 'meta_description', 'category_id', 'order', 'seo_text'];
    protected $rules = ['title' => 'required', 'meta_title' => 'required', 'meta_description' => 'required', 'category_id' => 'required'];

    public function getAll()
    {

	return $this->execute('SELECT *, sub_categories.title AS sub_category_title, sub_categories.id AS sub_category_id  
					FROM sub_categories LEFT JOIN categories ON categories.id = sub_categories.category_id 
					WHERE sub_categories.deleted_at IS NULL ORDER BY sub_categories.order ASC ', []);
	
    }


    public function add()
    {

	if (!$this->validate()) {

		return redirect('account.php?page=sub-category&action=add');

	}

	parent::add();

	return redirect('account.php?page=sub-categories', 'The sub category has been added');

    }


    public function delete($id)
    {

	$this->updateRow($this->table, ['deleted_at' => DT], 'id = :id  ', ['id' => $id]);

	return redirect('account.php?page=sub-categories', 'The sub category has been deleted');

    }


    public function update($id, $whereValues = null)
    {

	if (!parent::update('id = :id', ['id' => $id])) {

		return redirect('account.php?page=sub-category&action=edit&id=' . $id);

	}

	return redirect('account.php?page=sub-categories', 'The sub category has been updated');

    }

}
