<?php

namespace App\Tables;

use App\User;
use ErrorException;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class UsersTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return Table
     * @throws ErrorException
     */
    protected function table(): Table
    {
        return (new Table())->model(User::class)
            ->disableRows(
                function (User $user) {
                    return $user->id === auth()->id() || $user->isAdmin();
                },
                ['text-primary']
            )
            ->routes([
                'index'   => ['name' => 'users.index'],
                'create'  => ['name' => 'users.create'],
                'edit'    => ['name' => 'users.edit'],
                'destroy' => ['name' => 'users.destroy'],
            ])
            ->destroyConfirmationHtmlAttributes(function (User $user) {
                return [
                    'data-confirm' => __('Are you sure you want to delete the entry :entry?', [
                        'entry' => $user->name,
                    ]),
                ];
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
        $table->column('name')->sortable()->searchable()->title('name');
        $table->column('email')->sortable()->searchable()->title('email');
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
        //
    }
}
