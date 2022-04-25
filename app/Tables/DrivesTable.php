<?php

namespace App\Tables;

use App\DriveModel;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class DrivesTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return Table
     * @throws ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(DriveModel::class)
            ->routes([
                'index'   => ['name' => 'drives.index'],
                'create'  => ['name' => 'drives.create'],
                'edit'    => ['name' => 'drives.edit'],
                'destroy' => ['name' => 'drives.destroy'],
            ])->query(function (Builder $query) {
                // Some examples of what you can do
                $query->select('drives.*');
                $query->addSelect('users.name as user_name');
                $query->leftJoin('users', 'users.id', '=', 'drives.user_id');
            });
    }

    /**
     * Configure the table columns.
     *
     * @param Table $table
     *
     * @throws ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('id')->sortable()->title('id');
        $table->column('kilometers')->sortable()->title('kilometers');
        $table->column('user_id')
            ->sortable()
            ->searchable('users', ['name'])
            ->title('User Name')
            ->value(function (DriveModel $drive) {
                return $drive->user_name;
            });
        $table->column('created_at')->dateTimeFormat('d/m/Y H:i')->sortable()->title('created at');
        $table->column('updated_at')->dateTimeFormat('d/m/Y H:i')->sortable(true, 'desc')->title('updated at');

    }

    /**
     * Configure the table result lines.
     *
     * @param Table $table
     */
    protected function resultLines(Table $table): void
    {
        $table->result()
            ->title('Total of kilometers')
            ->html(function (Collection $paginatedRows) {
                return '<b>' . $paginatedRows->sum('kilometers') . '</b>';
            });
    }
}
