<?php

use App\Http\Controllers\Account;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\BudgetAccount;
use App\Http\Controllers\BudgetItem;
use App\Http\Controllers\Index;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [Index::class, 'landing']
)->name('landing');


Route::get(
    '/sign-in',
    [Authentication::class, 'signIn']
)->name('sign-in.view');

Route::post(
    '/sign-in',
    [Authentication::class, 'signInProcess']
)->name('sign-in.process');


Route::get(
    '/register',
    [Authentication::class, 'register']
)->name('register.view');

Route::post(
    '/register',
    [Authentication::class, 'registerProcess']
)->name('register.process');


Route::get(
    '/create-password',
    [Authentication::class, 'createPassword']
)->name('create-password.view');

Route::post(
    '/create-password',
    [Authentication::class, 'createPasswordProcess']
)->name('create-password.process');

Route::get(
    '/registration-complete',
    [Authentication::class, 'registrationComplete']
)->name('registration-complete');


Route::get(
    '/sign-out',
    [Authentication::class, 'signOut']
)->name('sign-out');


Route::group(
    [
        'middleware' => [
            'auth'
        ]
    ],
    static function() {

        Route::get(
            '/home',
            [Index::class, 'home']
        )->name('home');

        Route::get(
            '/demo',
            [Index::class, 'demo']
        )->name('demo');

        Route::post(
            '/demo',
            [Index::class, 'demoProcess']
        )->name('demo.process');

        Route::get(
            '/is-demo-loaded',
            [Index::class, 'isDemoLoaded']
        )->name('demo.is-loaded');

        Route::get(
            '/start',
            [Index::class, 'start']
        )->name('start');

        Route::post(
            '/start',
            [Index::class, 'startProcess']
        )->name('start.process');


        // Budget account management
        Route::get(
            '/budget/account',
            [BudgetAccount::class, 'create']
        )->name('budget.account.create');

        Route::post(
            '/budget/account',
            [BudgetAccount::class, 'createProcess']
        )->name('budget.account.create.process');

        Route::get(
            '/budget/account/{account_id}/edit',
            [BudgetAccount::class, 'update']
        )->name('budget.account.update');

        Route::post(
            '/budget/account/{account_id}/edit',
            [BudgetAccount::class, 'updateProcess']
        )->name('budget.account.update.process');


        // Budget item management
        Route::get(
            '/budget/item/{item_id}/confirm-delete',
            [BudgetItem::class, 'confirmDelete']
        )->name('budget.item.confirm-delete');

        Route::post(
            '/budget/item/{item_id}/confirm-delete',
            [BudgetItem::class, 'confirmDeleteProcess']
        )->name('budget.item.confirm-delete.process');

        Route::get(
            '/budget/item/{item_id}/confirm-disable',
            [BudgetItem::class, 'confirmDisable']
        )->name('budget.item.confirm-disable');

        Route::post(
            '/budget/item/{item_id}/confirm-disable',
            [BudgetItem::class, 'confirmDisableProcess']
        )->name('budget.item.confirm-disable.process');

        Route::get(
            '/budget/item/{item_id}/confirm-enable',
            [BudgetItem::class, 'confirmEnable']
        )->name('budget.item.confirm-enable');

        Route::post(
            '/budget/item/{item_id}/confirm-enable',
            [BudgetItem::class, 'confirmEnableProcess']
        )->name('budget.item.confirm-enable.process');

        Route::get(
            '/budget/item',
            [BudgetItem::class, 'create']
        )->name('budget.item.create');

        Route::post(
            '/budget/item',
            [BudgetItem::class, 'createProcess']
        )->name('budget.item.create.process');

        Route::get(
            '/budget/item/{item_id}',
            [BudgetItem::class, 'index']
        )->name('budget.item.view');

        Route::get(
            '/budget/item/{item_id}/edit',
            [BudgetItem::class, 'update']
        )->name('budget.item.update');

        Route::post(
            '/budget/item/{item_id}/edit',
            [BudgetItem::class, 'updateProcess']
        )->name('budget.item.update.process');


        // Account management
        Route::get(
            '/account',
            [Account::class, 'index']
        )->name('account.index');
    }
);
