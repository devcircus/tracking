<?php

use App\Http\Actions;

// Home
Route::redirect('/', '/dashboard');
Route::get('/dashboard', Actions\Dashboard\Index::class)->middleware(['auth'])->name('dashboard');

// Login
Route::group(['middleware' => ['guest'], 'as' => 'login.', 'prefix' => 'login'], function ($router) {
    $router->get('/', Actions\Auth\Login\ShowForm::class)->name('form');
    $router->post('/', Actions\Auth\Login\ProcessLogin::class)->name('attempt');
});

// Logout
Route::post('/logout', Actions\Auth\Logout\ProcessLogout::class)->middleware('auth')->name('logout');

// Password Reset
Route::group(['middleware' => ['guest'], 'as' => 'password.', 'prefix' => 'password'], function ($router) {
    $router->get('/reset', Actions\Auth\PasswordResetRequest\ShowForm::class)->name('request.form');
    $router->post('/email', Actions\Auth\PasswordResetRequest\SendEmail::class)->name('request.email');
    $router->get('/reset/{token}', Actions\Auth\PasswordReset\ShowForm::class)->name('reset');
    $router->post('/reset', Actions\Auth\PasswordReset\UpdatePassword::class)->name('update');
});

// Users
Route::group(['middleware' => ['auth'], 'as' => 'users.', 'prefix' => 'users'], function ($router) {
    $router->get('/', Actions\User\ListUsers::class)->middleware(['auth', 'is_admin'])->name('list');
    $router->get('/create', Actions\User\CreateUser::class)->middleware(['auth', 'is_admin'])->name('create');
    $router->post('/', Actions\User\StoreUser::class)->middleware(['auth', 'is_admin'])->name('store');
    $router->delete('/{user}', Actions\User\DeleteUser::class)->middleware(['auth', 'is_admin'], 'selfdelete.prevent')->name('destroy');
    $router->get('/{user}/edit', Actions\User\EditUser::class)->middleware(['auth', 'is_target'])->name('edit');
    $router->put('/{user}', Actions\User\UpdateUser::class)->middleware(['auth', 'is_target'])->name('update');
    $router->put('/{user}/restore', Actions\User\RestoreUser::class)->middleware(['auth', 'is_admin'])->name('restore');
});

// Activities
Route::get('/activities', Actions\Activity\ListActivities::class)->middleware(['auth', 'is_super_admin'])->name('activities.list');

/***************************************************************
 *# # # # # # # # # # # INVENTORY ROUTES # # # # # # # # # # # #*
 ***************************************************************/

 // Main
Route::get('/inventory', Actions\Inventory\Index::class)->middleware(['auth'])->name('inventory');

// Tags
Route::group(['middleware' => ['auth'], 'as' => 'tags.', 'prefix' => 'tags'], function ($router) {
    $router->post('/multiple', Actions\Tag\StoreMultipleTags::class)->name('store.multiple');
    $router->delete('/{tag}/delete', Actions\Tag\DeleteTag::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{tag}/restore', Actions\Tag\RestoreTag::class)->middleware(['is_admin'])->name('restore');
    $router->put('/{tag}/finish', Actions\Tag\FinishTag::class)->name('finish');
    $router->put('/finish/multiple', Actions\Tag\FinishMultipleTags::class)->name('finish.multiple');
    $router->put('/{tag}/reactivate', Actions\Tag\ReactivateTag::class)->name('reactivate');
    $router->post('/', Actions\Tag\StoreTag::class)->name('store');
});

// Items
Route::group(['middleware' => ['auth', 'is_admin'], 'as' => 'items.', 'prefix' => 'items'], function ($router) {
    $router->get('/create', Actions\InventoryItem\CreateInventoryItem::class)->name('create');
    $router->delete('/{item}/delete', Actions\InventoryItem\DeleteInventoryItem::class)->name('destroy');
    $router->put('/{item}/restore', Actions\InventoryItem\RestoreInventoryItem::class)->name('restore');
    $router->put('/{item}', Actions\InventoryItem\UpdateInventoryItem::class)->name('update');
    $router->post('/', Actions\InventoryItem\StoreInventoryItem::class)->name('store');
    $router->get('/{item}', Actions\InventoryItem\ShowInventoryItem::class)->name('show');
});

/***************************************************************
 *# # # # # # # # # # # # ORDER ROUTES # # # # # # # # # # # # #*
 ***************************************************************/

// Reports
Route::group(['middleware' => ['auth'], 'as' => 'reports.', 'prefix' => 'reports'], function ($router) {
    $router->get('/', Actions\Report\Index::class)->middleware(['auth'])->name('list');
    $router->get('/{type}/{date}', Actions\Report\ShowIndividualReport::class)->middleware(['date'])->name('individual.show');
    $router->get('/{date}', Actions\Report\ShowComprehensiveReport::class)->middleware(['date'])->name('comprehensive.show');
});

// Uploads
Route::post('/uploads', Actions\Upload\StoreUpload::class)->middleware(['auth', 'is_admin'])->name('uploads.store');
Route::get('/uploads/check', Actions\Upload\CheckUpload::class)->middleware(['auth', 'is_admin'])->name('uploads.check');

// PDF
Route::get('pdf/{type}/{date}', Actions\Pdf\ShowPdf::class)->middleware(['auth', 'date'])->name('pdf.show');

// Orders
Route::group(['middleware' => ['auth', 'is_admin'], 'as' => 'orders.', 'prefix' => 'orders'], function ($router) {
    $router->post('/', Actions\Order\AddOrder::class)->name('add');
    $router->delete('/{order}', Actions\Order\DeleteOrder::class)->name('delete');
    $router->post('/{order}/complete', Actions\Order\CompleteOrder::class)->name('complete');
    $router->patch('/{order}', Actions\Order\UpdateOrder::class)->name('update');
    $router->post('/batch/info', Actions\Order\BatchUpdateInfo::class)->middleware(['date'])->name('info.batch.update');
});

// Summary
Route::group(['middleware' => ['auth', 'date'], 'as' => 'summary.', 'prefix' => 'summary'], function ($router) {
    $router->get('/{date}', Actions\Summary\ShowSummary::class)->name('show');
    $router->get('/pdf/{date}', Actions\Summary\Pdf\ShowSummaryPdf::class)->name('pdf.show');
});

// Voucher tracking for artists
Route::group(['middleware' => ['auth', 'is_artist'], 'as' => 'vouchers.', 'prefix' => 'vouchers'], function ($router) {
    $router->post('/batch/art', Actions\Artwork\BatchArtComplete::class)->name('art.batch');
    $router->put('/{order}/art', Actions\Artwork\ArtComplete::class)->name('art');
});

// Artwork
Route::group(['middleware' => ['auth'], 'as' => 'artwork.', 'prefix' => 'artwork'], function ($router) {
    $router->get('/', Actions\Artwork\ListVouchersForArtists::class)->name('list');
});

// Materials
Route::group(['middleware' => ['auth'], 'as' => 'materials.', 'prefix' => 'materials'], function ($router) {
    $router->get('/', Actions\Materials\ListMaterials::class)->name('list');
});

// Colors
Route::group(['middleware' => ['auth'], 'as' => 'colors.', 'prefix' => 'colors'], function ($router) {
    $router->get('/create', Actions\Color\CreateColor::class)->middleware(['is_admin'])->name('create');
    $router->post('/', Actions\Color\StoreColor::class)->middleware(['is_admin'])->name('store');
    $router->put('/{color}', Actions\Color\UpdateColor::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{color}', Actions\Color\DeleteColor::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{color}/restore', Actions\Color\RestoreColor::class)->middleware(['is_admin'])->name('restore');
    $router->get('/{color}', Actions\Color\ShowColor::class)->name('show');
    $router->put('/{color}/printer/{printer}', Actions\Color\SetColor::class)->middleware(['is_admin'])->name('set');
    $router->get('/printer/{printer}/colors', Actions\Color\ShowPrinterColors::class)->name('printer');
    $router->get('/printer/{printer}/colors/pdf', Actions\Color\Pdf\ShowPrinterColorsPdf::class)->name('printer.pdf');
});

// Fabrics
Route::group(['middleware' => ['auth'], 'as' => 'fabrics.', 'prefix' => 'fabrics'], function ($router) {
    $router->get('/', Actions\Fabric\ListFabricsPdf::class)->name('pdf');
    $router->get('/create', Actions\Fabric\CreateFabric::class)->middleware(['is_admin'])->name('create');
    $router->get('/{fabric}', Actions\Fabric\ShowFabric::class)->name('show');
    $router->post('/', Actions\Fabric\StoreFabric::class)->middleware(['is_admin'])->name('store');
    $router->put('/{fabric}', Actions\Fabric\UpdateFabric::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{fabric}', Actions\Fabric\DeleteFabric::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{fabric}/restore', Actions\Fabric\RestoreFabric::class)->middleware(['is_admin'])->name('restore');
});

// Printers
Route::group(['middleware' => ['auth'], 'as' => 'printers.', 'prefix' => 'printers'], function ($router) {
    $router->post('/', Actions\Printer\StorePrinter::class)->middleware(['is_admin'])->name('store');
    $router->get('/create', Actions\Printer\CreatePrinter::class)->middleware(['is_admin'])->name('create');
    $router->get('/{printer}', Actions\Printer\ShowPrinter::class)->name('show');
    $router->put('/{printer}', Actions\Printer\UpdatePrinter::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{printer}', Actions\Printer\DeletePrinter::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{printer}/restore', Actions\Printer\RestorePrinter::class)->middleware(['is_admin'])->name('restore');
});

// Inks
Route::group(['middleware' => ['auth'], 'as' => 'inks.', 'prefix' => 'inks'], function ($router) {
    $router->get('/create', Actions\Ink\CreateInk::class)->middleware(['is_admin'])->name('create');
    $router->get('/{ink}', Actions\Ink\ShowInk::class)->name('show');
    $router->post('/', Actions\Ink\StoreInk::class)->middleware(['is_admin'])->name('store');
    $router->put('/{ink}', Actions\Ink\UpdateInk::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{ink}', Actions\Ink\DeleteInk::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{ink}/restore', Actions\Ink\RestoreInk::class)->middleware(['is_admin'])->name('restore');
});
