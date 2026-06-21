<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class Categories extends Component
{
    public string $name = '';

    public string $icon = 'dots';

    public ?int $editingId = null;

    public bool $showForm = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'icon' => 'required|string|max:50',
        ];
    }

    public function startAdd(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function startEdit(int $id): void
    {
        $cat = Category::findOrFail($id);
        $this->editingId = $id;
        $this->name = $cat->name;
        $this->icon = $cat->icon ?? 'dots';
        $this->showForm = true;
    }

    public function save(): void
    {
        if (! auth()->user()->isPro()) {
            session()->flash('error', 'Buat kategori kustom hanya untuk akun Pro.');

            return;
        }

        $this->validate();

        if ($this->editingId) {
            Category::where('id', $this->editingId)
                ->where('user_id', auth()->id())
                ->update(['name' => $this->name, 'icon' => $this->icon]);
            session()->flash('success', 'Kategori berhasil diupdate.');
        } else {
            Category::create([
                'user_id' => auth()->id(),
                'name' => $this->name,
                'icon' => $this->icon,
                'is_system' => false,
            ]);
            session()->flash('success', 'Kategori baru ditambahkan.');
        }

        $this->resetForm();
        $this->dispatch('refresh');
    }

    public function delete(int $id): void
    {
        $cat = Category::where('id', $id)->where('user_id', auth()->id())->first();
        if ($cat && ! $cat->is_system) {
            $cat->delete();
            session()->flash('success', 'Kategori dihapus.');
            $this->dispatch('refresh');
        }
    }

    public function resetForm(): void
    {
        $this->name = '';
        $this->icon = 'dots';
        $this->editingId = null;
        $this->showForm = false;
    }

    public function render()
    {
        $categories = Category::where('user_id', auth()->id())->orderBy('is_system', 'desc')->orderBy('id')->get();

        return view('livewire.categories', [
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
