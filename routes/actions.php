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
    $router->get('/', Actions\User\ListUsers::class)->middleware(['auth', 'can:administerUsers'])->name('list');
    $router->get('/create', Actions\User\CreateUser::class)->middleware(['auth', 'can:administerUsers'])->name('create');
    $router->post('/', Actions\User\StoreUser::class)->middleware(['auth', 'can:administerUsers'])->name('store');
    $router->delete('/{user}', Actions\User\DeleteUser::class)->middleware(['auth', 'can:administerUsers'], 'selfdelete.prevent')->name('destroy');
    $router->get('/{user}/edit', Actions\User\EditUser::class)->middleware(['auth', 'is_target'])->name('edit');
    $router->put('/{user}', Actions\User\UpdateUser::class)->middleware(['auth', 'is_target'])->name('update');
    $router->put('/{user}/restore', Actions\User\RestoreUser::class)->middleware(['auth', 'can:administerUsers'])->name('restore');
});

// Activities
Route::get('/activities', Actions\Activity\ListActivities::class)->middleware(['auth', 'can:administerActivities'])->name('activities.list');

/***************************************************************
 *# # # # # # # # # # # INVENTORY ROUTES # # # # # # # # # # # #*
 ***************************************************************/

 // Main
Route::get('/inventory', Actions\Inventory\Index::class)->middleware(['auth'])->name('inventory');

// Tags
Route::group(['middleware' => ['auth'], 'as' => 'tags.', 'prefix' => 'tags'], function ($router) {
    $router->post('/multiple', Actions\Tag\StoreMultipleTags::class)->middleware(['can:activateTags'])->name('store.multiple');
    $router->delete('/{tag}/delete', Actions\Tag\DeleteTag::class)->middleware(['can:deleteTags'])->name('destroy');
    $router->put('/{tag}/restore', Actions\Tag\RestoreTag::class)->middleware(['can:restoreTags'])->name('restore');
    $router->put('/{tag}/finish', Actions\Tag\FinishTag::class)->middleware(['can:finishTags'])->name('finish');
    $router->put('/finish/multiple', Actions\Tag\FinishMultipleTags::class)->middleware(['can:finishTags'])->name('finish.multiple');
    $router->put('/{tag}/reactivate', Actions\Tag\ReactivateTag::class)->middleware(['can:activateTags'])->name('reactivate');
    $router->post('/', Actions\Tag\StoreTag::class)->middleware(['can:activateTags'])->name('store');
});

// Items
Route::group(['middleware' => ['auth', 'can:administerItems'], 'as' => 'items.', 'prefix' => 'items'], function ($router) {
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
    $router->get('/', Actions\Report\Index::class)->name('list');
    $router->get('/{type}/{date}', Actions\Report\ShowIndividualReport::class)->middleware(['date'])->name('individual.show');
    $router->get('/{date}', Actions\Report\ShowComprehensiveReport::class)->middleware(['date'])->name('comprehensive.show');
});

// Uploads
Route::post('/uploads', Actions\Upload\StoreUpload::class)->middleware(['auth', 'can:administerReports'])->name('uploads.store');
Route::get('/uploads/check', Actions\Upload\CheckUpload::class)->middleware(['auth', 'can:administerReports'])->name('uploads.check');

// PDF
Route::get('pdf/{type}/{date}', Actions\Pdf\ShowPdf::class)->middleware(['auth', 'date'])->name('pdf.show');

// Orders
Route::group(['middleware' => ['auth', 'can:administerReports'], 'as' => 'orders.', 'prefix' => 'orders'], function ($router) {
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
    $router->get('/', Actions\Artwork\ListArtworkVouchers::class)->name('list');
});

// Materials
Route::group(['middleware' => ['auth'], 'as' => 'materials.', 'prefix' => 'materials'], function ($router) {
    $router->get('/', Actions\Materials\ListMaterials::class)->name('list');
});

// Colors
Route::group(['middleware' => ['auth'], 'as' => 'colors.', 'prefix' => 'colors'], function ($router) {
    $router->get('/create', Actions\Color\CreateColor::class)->middleware(['can:createColors'])->name('create');
    $router->post('/', Actions\Color\StoreColor::class)->middleware(['can:createColors'])->name('store');
    $router->put('/{color}', Actions\Color\UpdateColor::class)->middleware(['can:administerColors'])->name('update');
    $router->delete('/{color}', Actions\Color\DeleteColor::class)->middleware(['can:deleteColors'])->name('destroy');
    $router->put('/{color}/restore', Actions\Color\RestoreColor::class)->middleware(['can:restoreColors'])->name('restore');
    $router->get('/{color}', Actions\Color\ShowColor::class)->name('show');
    $router->put('/{color}/printer/{printer}', Actions\Color\SetColor::class)->middleware(['can:administerColors'])->name('set');
    $router->get('/printer/{printer}/colors', Actions\Color\ShowPrinterColors::class)->name('printer');
    $router->get('/printer/{printer}/colors/pdf', Actions\Color\Pdf\ShowPrinterColorsPdf::class)->name('printer.pdf');
});

// Fabrics
Route::group(['middleware' => ['auth'], 'as' => 'fabrics.', 'prefix' => 'fabrics'], function ($router) {
    $router->get('/', Actions\Fabric\ListFabricsPdf::class)->name('pdf');
    $router->get('/create', Actions\Fabric\CreateFabric::class)->middleware(['can:createFabrics'])->name('create');
    $router->get('/{fabric}', Actions\Fabric\ShowFabric::class)->name('show');
    $router->post('/', Actions\Fabric\StoreFabric::class)->middleware(['can:createFabrics'])->name('store');
    $router->put('/{fabric}', Actions\Fabric\UpdateFabric::class)->middleware(['can:administerFabrics'])->name('update');
    $router->delete('/{fabric}', Actions\Fabric\DeleteFabric::class)->middleware(['can:deleteFabrics'])->name('destroy');
    $router->put('/{fabric}/restore', Actions\Fabric\RestoreFabric::class)->middleware(['can:restoreFabrics'])->name('restore');
});

// Printers
Route::group(['middleware' => ['auth'], 'as' => 'printers.', 'prefix' => 'printers'], function ($router) {
    $router->post('/', Actions\Printer\StorePrinter::class)->middleware(['can:createPrinters'])->name('store');
    $router->get('/create', Actions\Printer\CreatePrinter::class)->middleware(['can:createPrinters'])->name('create');
    $router->get('/{printer}', Actions\Printer\ShowPrinter::class)->name('show');
    $router->put('/{printer}', Actions\Printer\UpdatePrinter::class)->middleware(['can:administerPrinters'])->name('update');
    $router->delete('/{printer}', Actions\Printer\DeletePrinter::class)->middleware(['can:deletePrinters'])->name('destroy');
    $router->put('/{printer}/restore', Actions\Printer\RestorePrinter::class)->middleware(['can:restorePrinters'])->name('restore');
});

// Inks
Route::group(['middleware' => ['auth'], 'as' => 'inks.', 'prefix' => 'inks'], function ($router) {
    $router->get('/create', Actions\Ink\CreateInk::class)->middleware(['can:createInks'])->name('create');
    $router->get('/{ink}', Actions\Ink\ShowInk::class)->name('show');
    $router->post('/', Actions\Ink\StoreInk::class)->middleware(['can:createInks'])->name('store');
    $router->put('/{ink}', Actions\Ink\UpdateInk::class)->middleware(['can:administerInks'])->name('update');
    $router->delete('/{ink}', Actions\Ink\DeleteInk::class)->middleware(['can:deleteInks'])->name('destroy');
    $router->put('/{ink}/restore', Actions\Ink\RestoreInk::class)->middleware(['can:restoreInks'])->name('restore');
});
