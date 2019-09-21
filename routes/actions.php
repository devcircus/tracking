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
    $router->get('/', User\ListUsers::class)->middleware(['auth', 'is_admin'])->name('list');
    $router->get('/create', User\CreateUser::class)->middleware(['auth', 'is_admin'])->name('create');
    $router->post('/', User\StoreUser::class)->middleware(['auth', 'is_admin'])->name('store');
    $router->delete('/{user}', User\DeleteUser::class)->middleware(['auth', 'is_admin'], 'selfdelete.prevent')->name('destroy');
    $router->get('/{user}/edit', User\EditUser::class)->middleware(['auth', 'is_target'])->name('edit');
    $router->put('/{user}', User\UpdateUser::class)->middleware(['auth', 'is_target'])->name('update');
    $router->put('/{user}/restore', User\RestoreUser::class)->middleware(['auth', 'is_admin'])->name('restore');
});

// Activities
Route::get('/activities', Activity\ListActivities::class)->middleware(['auth', 'is_super_admin'])->name('activities.list');

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
    $router->get('/create', InventoryItem\CreateInventoryItem::class)->name('create');
    $router->delete('/{item}/delete', InventoryItem\DeleteInventoryItem::class)->name('destroy');
    $router->put('/{item}/restore', InventoryItem\RestoreInventoryItem::class)->name('restore');
    $router->put('/{item}', InventoryItem\UpdateInventoryItem::class)->name('update');
    $router->post('/', InventoryItem\StoreInventoryItem::class)->name('store');
    $router->get('/{item}', InventoryItem\ShowInventoryItem::class)->name('show');
});

/***************************************************************
 *# # # # # # # # # # # # ORDER ROUTES # # # # # # # # # # # # #*
 ***************************************************************/

// Reports
Route::group(['middleware' => ['auth'], 'as' => 'reports.', 'prefix' => 'reports'], function ($router) {
    $router->get('/', Report\Index::class)->middleware(['auth'])->name('list');
    $router->get('/{type}/{date}', Report\ShowIndividualReport::class)->middleware(['date'])->name('individual.show');
    $router->get('/{date}', Report\ShowComprehensiveReport::class)->middleware(['date'])->name('comprehensive.show');
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
    $router->post('/batch/info', Order\BatchUpdateInfo::class)->name('info.batch.update');
});

// Summary
Route::group(['middleware' => ['auth', 'date'], 'as' => 'summary.', 'prefix' => 'summary'], function ($router) {
    $router->get('/{date}', Summary\ShowSummary::class)->name('show');
    $router->get('/pdf/{date}', Summary\Pdf\ShowSummaryPdf::class)->name('pdf.show');
});

// Voucher tracking for artists
Route::group(['middleware' => ['auth', 'is_artist'], 'as' => 'vouchers.', 'prefix' => 'vouchers'], function ($router) {
    $router->post('/batch/art', Artwork\BatchArtComplete::class)->name('art.batch');
    $router->put('/{order}/art', Artwork\ArtComplete::class)->name('art');
});

// Artwork
Route::group(['middleware' => ['auth'], 'as' => 'artwork.', 'prefix' => 'artwork'], function ($router) {
    $router->get('/', Artwork\ListVouchersForArtists::class)->name('list');
});

// Materials
Route::group(['middleware' => ['auth'], 'as' => 'materials.', 'prefix' => 'materials'], function ($router) {
    $router->get('/', Materials\ListMaterials::class)->name('list');
});

// Colors
Route::group(['middleware' => ['auth'], 'as' => 'colors.', 'prefix' => 'colors'], function ($router) {
    $router->get('/create', Color\CreateColor::class)->middleware(['is_admin'])->name('create');
    $router->post('/', Color\StoreColor::class)->middleware(['is_admin'])->name('store');
    $router->put('/{color}', Color\UpdateColor::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{color}', Color\DeleteColor::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{color}/restore', Color\RestoreColor::class)->middleware(['is_admin'])->name('restore');
    $router->get('/{color}', Color\ShowColor::class)->name('show');
    $router->put('/{color}/printer/{printer}', Color\SetColor::class)->middleware(['is_admin'])->name('set');
    $router->get('/printer/{printer}/colors', Color\ShowPrinterColors::class)->name('printer');
    $router->get('/printer/{printer}/colors/pdf', Color\Pdf\ShowPrinterColorsPdf::class)->name('printer.pdf');
});

// Fabrics
Route::group(['middleware' => ['auth'], 'as' => 'fabrics.', 'prefix' => 'fabrics'], function ($router) {
    $router->get('/', Fabric\ListFabricsPdf::class)->name('pdf');
    $router->get('/create', Fabric\CreateFabric::class)->middleware(['is_admin'])->name('create');
    $router->get('/{fabric}', Fabric\ShowFabric::class)->name('show');
    $router->post('/', Fabric\StoreFabric::class)->middleware(['is_admin'])->name('store');
    $router->put('/{fabric}', Fabric\UpdateFabric::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{fabric}', Fabric\DeleteFabric::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{fabric}/restore', Fabric\RestoreFabric::class)->middleware(['is_admin'])->name('restore');
});

// Printers
Route::group(['middleware' => ['auth'], 'as' => 'printers.', 'prefix' => 'printers'], function ($router) {
    $router->post('/', Printer\StorePrinter::class)->middleware(['is_admin'])->name('store');
    $router->get('/create', Printer\CreatePrinter::class)->middleware(['is_admin'])->name('create');
    $router->get('/{printer}', Printer\ShowPrinter::class)->name('show');
    $router->put('/{printer}', Printer\UpdatePrinter::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{printer}', Printer\DeletePrinter::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{printer}/restore', Printer\RestorePrinter::class)->middleware(['is_admin'])->name('restore');
});

// Inks
Route::group(['middleware' => ['auth'], 'as' => 'inks.', 'prefix' => 'inks'], function ($router) {
    $router->get('/create', Ink\CreateInk::class)->middleware(['is_admin'])->name('create');
    $router->get('/{ink}', Ink\ShowInk::class)->name('show');
    $router->post('/', Ink\StoreInk::class)->middleware(['is_admin'])->name('store');
    $router->put('/{ink}', Ink\UpdateInk::class)->middleware(['is_admin'])->name('update');
    $router->delete('/{ink}', Ink\DeleteInk::class)->middleware(['is_admin'])->name('destroy');
    $router->put('/{ink}/restore', Ink\RestoreInk::class)->middleware(['is_admin'])->name('restore');
});
