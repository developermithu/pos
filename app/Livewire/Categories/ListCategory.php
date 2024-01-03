<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use App\Traits\SearchAndFilter;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListCategory extends Component
{
    use WithPagination, Toast, SearchAndFilter;

    public CategoryForm $form;

    public function create()
    {
        $this->authorize('create', Category::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $category);

        try {
            $category->forceDelete();
            $this->success(__('Record has been deleted permanently'));
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->warning(__('Failed to delete category. There are existing product records linked to it.'), timeout: 5000);
            }
        }

        return back();
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $category);
        $category->restore();

        $this->success(__('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Category::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name'];

        $categories = Category::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.categories.list-category', compact('categories'))
            ->title(__('category list'));
    }
}
