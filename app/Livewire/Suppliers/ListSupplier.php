<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;


class ListSupplier extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn (Supplier $record): string => route('admin.suppliers.edit', ['supplier' => $record]),
            )
            ->query(Supplier::query())
            ->columns([
                TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),
                TextColumn::make('address')
                    ->label(__('address')),
                TextColumn::make('phone_number')
                    ->label(__('phone number')),
                TextColumn::make('bank_name')
                    ->label(__('bank name')),
                TextColumn::make('bank_branch')
                    ->label(__('bank branch')),
            ])

            ->filters([
                Filter::make('bank_name')
                    ->query(fn (Builder $query): Builder => $query->where('bank_name', '!=', ''))
                    ->label(__('bank name')),

            ])

            ->actions([
                Action::make('edit')
                    ->label(__('edit'))
                    ->url(fn (Supplier $record): string => route('admin.suppliers.edit', $record))
                    ->icon('heroicon-m-pencil-square'),

                Action::make('delete')
                    ->label(__('delete'))
                    ->requiresConfirmation()
                    ->action(fn (Supplier $record) => $record->delete())
                    ->color('danger')
                    ->icon('heroicon-m-trash')
                    ->iconSize('w-4 h-4')
            ])

            ->bulkActions([
                BulkAction::make('delete')
                    ->label(__('delete'))
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
            ]);
    }

    public function render()
    {
        return view('livewire.suppliers.list-supplier')
            ->title(__('supplier list'));
    }
}
