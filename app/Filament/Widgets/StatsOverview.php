<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalIncome = Transaction::whereHas('category', function ($query) {
            $query->where('type', 'income');
        })->sum('amount');

        $totalExpense = Transaction::whereHas('category', function ($query) {
            $query->where('type', 'expense');
        })->sum('amount');

        $difference = $totalIncome - $totalExpense;

        return [
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIncome, 0, ',', '.')),
            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpense, 0, ',', '.')),
            Stat::make('Selisih', 'Rp ' . number_format($difference, 0, ',', '.')),
        ];
    }
}
