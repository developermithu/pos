<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Livewire\Component;
use Mary\Traits\Toast;

class EditCategory extends Component
{
    use Toast;
    public CategoryForm $form;

    public function mount(Category $category)
    {
        $this->authorize('update', $category);
        $this->form->setCategory($category);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListCategory::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.categories.edit-category')
            ->title(__('update category'));
    }
}
