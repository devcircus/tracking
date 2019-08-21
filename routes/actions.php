<?php

// Home
Route::redirect('/', '/dashboard');
Route::get('/dashboard', Dashboard\Index::class)->middleware(['auth'])->name('dashboard');

// Login
Route::group(['middleware' => ['guest'], 'as' => 'login.', 'prefix' => 'login'], function ($router) {
    $router->get('/', Auth\Login\ShowForm::class)->name('form');
    $router->post('/', Auth\Login\ProcessLogin::class)->name('attempt');
});

// Logout
Route::post('/logout', Auth\Logout\ProcessLogout::class)->middleware('auth')->name('logout');

// Password Reset
Route::group(['middleware' => ['guest'], 'as' => 'password.', 'prefix' => 'password'], function ($router) {
    $router->get('/reset', Auth\PasswordResetRequest\ShowForm::class)->name('request.form');
    $router->post('/email', Auth\PasswordResetRequest\SendEmail::class)->name('request.email');
    $router->get('/reset/{token}', Auth\PasswordReset\ShowForm::class)->name('reset');
    $router->post('/reset', Auth\PasswordReset\UpdatePassword::class)->name('update');
});

// Users
Route::group(['middleware' => ['auth'], 'as' => 'users.', 'prefix' => 'users'], function ($router) {
    $router->get('/', User\ListUsers::class)->middleware(['auth'])->name('list');
    $router->get('/create', User\CreateUser::class)->middleware(['auth', 'is_admin'])->name('create');
    $router->post('/', User\StoreUser::class)->middleware(['auth', 'is_admin'])->name('store');
    $router->delete('/{user}', User\DeleteUser::class)->middleware(['auth', 'is_admin'], 'selfdelete.prevent')->name('destroy');
    $router->get('/{user}/edit', User\EditUser::class)->middleware(['auth'])->name('edit');
    $router->put('/{user}', User\UpdateUser::class)->middleware(['auth'])->name('update');
    $router->put('/{user}/restore', User\RestoreUser::class)->middleware(['auth'])->name('restore');
});

/***************************************************************
 *# # # # # # # # # # # INVENTORY ROUTES # # # # # # # # # # # #*
 ***************************************************************/

 // Main
Route::get('/inventory', Inventory\Index::class)->middleware(['auth'])->name('inventory');

// Tags
Route::group(['middleware' => ['auth'], 'as' => 'tags.', 'prefix' => 'tags'], function ($router) {
    $router->post('/multiple', Tag\StoreMultipleTags::class)->name('store.multiple');
    $router->delete('/{tag}/delete', Tag\DeleteTag::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{tag}/restore', Tag\RestoreTag::class)->middleware(['is_admin'])->name('restore');
    $router->put('/{tag}/finish', Tag\FinishTag::class)->name('finish');
    $router->put('/finish/multiple', Tag\FinishMultipleTags::class)->name('finish.multiple');
    $router->put('/{tag}/reactivate', Tag\ReactivateTag::class)->name('reactivate');
    $router->post('/', Tag\StoreTag::class)->name('store');
});

// Items
Route::group(['middleware' => ['auth', 'is_admin'], 'as' => 'items.', 'prefix' => 'items'], function ($router) {
    $router->get('/create', Item\CreateItem::class)->name('create');
    $router->delete('/{item}/delete', Item\DeleteItem::class)->name('destroy');
    $router->put('/{item}/restore', Item\RestoreItem::class)->name('restore');
    $router->put('/{item}', Item\UpdateItem::class)->name('update');
    $router->post('/', Item\StoreItem::class)->name('store');
    $router->get('/{item}', Item\ShowItem::class)->name('show');
});

/***************************************************************
 *# # # # # # # # # # # # ORDER ROUTES # # # # # # # # # # # # #*
 ***************************************************************/

// Reports
Route::group(['middleware' => ['auth'], 'as' => 'reports.', 'prefix' => 'reports'], function ($router) {
    $router->get('/', Report\Index::class)->middleware(['auth'])->name('list');
    $router->get('/{type}/{date}', Report\ShowIndividualReport::class)->middleware(['date'])->name('individual.show');
    $router->get('/{date}', Report\ShowComprehensiveReport::class)->middleware(['date'])->name('comprehensive.show');
    $router->get('/create', Report\CreateReport::class)->name('create');
});

// Uploads
Route::post('/uploads', Upload\StoreUpload::class)->middleware(['auth', 'is_admin'])->name('uploads.store');
Route::get('/uploads/check', Upload\CheckUpload::class)->middleware(['auth', 'is_admin'])->name('uploads.check');

// PDF
Route::get('pdf/{type}/{date}', Pdf\ShowPdf::class)->middleware(['auth', 'date'])->name('pdf.show');

// Orders
Route::group(['middleware' => ['auth', 'is_admin'], 'as' => 'orders.', 'prefix' => 'orders'], function ($router) {
    $router->post('/', Order\AddOrder::class)->name('add');
    $router->delete('/{order}', Order\DeleteOrder::class)->name('delete');
    $router->post('/{order}/complete', Order\CompleteOrder::class)->name('complete');
    $router->patch('/{order}', Order\UpdateOrder::class)->name('update');
});

// Summary
Route::group(['middleware' => ['auth', 'date'], 'as' => 'summary.', 'prefix' => 'summary'], function ($router) {
    $router->get('/{date}', Summary\ShowSummary::class)->name('show');
    $router->get('/pdf/{date}', Summary\Pdf\ShowSummaryPdf::class)->name('pdf.show');
});

// Info
Route::post('orders/batch/info', Info\UpdateInfo::class)->middleware(['auth'])->name('info.batch.update');


// Art Complete
Route::put('vouchers/{order}/art', Voucher\ArtComplete::class)->middleware(['auth', 'is_artist'])->name('vouchers.art');

// Voucher tracking for artists
Route::group(['middleware' => ['auth', 'is_artist'], 'as' => 'vouchers.', 'prefix' => 'vouchers'], function ($router) {
    $router->get('/', Voucher\ListVouchersForArtists::class)->name('list');
});
