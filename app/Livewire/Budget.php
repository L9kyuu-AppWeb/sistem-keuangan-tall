<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Budget as BudgetModel;
use App\Models\Category;

class Budget extends Component
{
    public float $generalAmount = 0;
    public array $categoryAmounts = [];
    public bool $editing = false;

    public function mount(): void
    {
        $this->loadBudgets();
    }

    private function loadBudgets(): void
    {
        $month = now()->format('Y-m');
        $user = auth()->user();

        // Load general budget (category_id = null)
        $general = $user->budgets()->where('month', $month)->whereNull('category_id')->first();
        $this->generalAmount = $general ? (float) $general->amount : 0;

        // Load per-category budgets
        $cats = Category::all();
        foreach ($cats as $cat) {
            $budget = $user->budgets()->where('month', $month)->where('category_id', $cat->id)->first();
            $this->categoryAmounts[$cat->id] = $budget ? (float) $budget->amount : 0;
        }
    }

    public function save(): void
    {
        $this->validate([
            'generalAmount' => 'required|numeric|min:0',
            'categoryAmounts' => 'array',
            'categoryAmounts.*' => 'numeric|min:0',
        ]);

        $month = now()->format('Y-m');
        $user = auth()->user();

        // Save general budget — everyone can
        BudgetModel::updateOrCreate(
            ['user_id' => $user->id, 'month' => $month, 'category_id' => null],
            ['amount' => $this->generalAmount]
        );

        // Save per-category budgets — Pro only
        if ($user->isPro()) {
            foreach ($this->categoryAmounts as $catId => $amount) {
                if ($amount > 0) {
                    BudgetModel::updateOrCreate(
                        ['user_id' => $user->id, 'month' => $month, 'category_id' => $catId],
                        ['amount' => $amount]
                    );
                } else {
                    BudgetModel::where('user_id', $user->id)
                        ->where('month', $month)
                        ->where('category_id', $catId)
                        ->delete();
                }
            }
            session()->flash('success', 'Anggaran berhasil disimpan!');
        } else {
            session()->flash('success', 'Anggaran umum disimpan. Budget per kategori untuk Pro.');
        }

        $this->editing = false;
        $this->loadBudgets();
    }

    public function render()
    {
        $month = now()->locale('id')->isoFormat('MMMM Y');
        $user = auth()->user();

        // Calculate spending per category
        $categorySpending = [];
        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('amount');

        foreach (Category::all() as $cat) {
            $spent = $user->transactions()
                ->where('type', 'expense')
                ->where('category_id', $cat->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount');
            $budget = $this->categoryAmounts[$cat->id] ?? 0;
            $categorySpending[$cat->id] = [
                'category' => $cat,
                'spent' => (float) $spent,
                'budget' => $budget,
                'percent' => $budget > 0 ? min(100, round(($spent / $budget) * 100)) : 0,
            ];
        }

        return view('livewire.budget', [
            'month' => $month,
            'totalExpense' => (float) $totalExpense,
            'categorySpending' => $categorySpending,
        ])->layout('layouts.app');
    }
}
