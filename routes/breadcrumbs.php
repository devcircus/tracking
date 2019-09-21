<?php

use Illuminate\Support\Carbon;

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Home > Users
Breadcrumbs::for('users.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.list'));
});

// Home > Users > Create
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.list');
    $trail->push('Create User', route('users.create'));
});

// Home > Users > Edit User
Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('users.list');
    $trail->push($user->name, route('users.edit', $user->id));
});

// Home > Activities
Breadcrumbs::for('activities.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Activities', route('activities.list'));
});

// Home > Inventory
Breadcrumbs::for('inventory', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Inventory', route('inventory'));
});

// Home > Items > Create
Breadcrumbs::for('items.create', function ($trail) {
    $trail->parent('inventory');
    $trail->push('Create Item', route('items.create'));
});

// Home > Materials > Show Item
Breadcrumbs::for('items.show', function ($trail, $item) {
    $trail->parent('inventory');
    $trail->push($item->name, route('items.show', $item->id));
});

// Home > Reports
Breadcrumbs::for('reports.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Reports', route('reports.list'));
});

// Home > Reports > Comprehensive Report
Breadcrumbs::for('reports.comprehensive.show', function ($trail, $date) {
    $trail->parent('reports.list');
    $trail->push(Carbon::createFromTimestamp($date)->format('m/d/y g:i a'), route('reports.comprehensive.show', $date));
});

// Home > Reports > Comprehensive Report > Individual Report
Breadcrumbs::for('reports.individual.show', function ($trail, $type, $date) {
    $trail->parent('reports.comprehensive.show', $date);
    $trail->push(strtoupper($type), route('reports.individual.show', ['type' => $type, 'date' => $date]));
});

// Home > Reports > Comprehensive Report > Summary
Breadcrumbs::for('summary.show', function ($trail, $date) {
    $trail->parent('reports.comprehensive.show', $date);
    $trail->push('Summary', route('summary.show', $date));
});

// Home > Artwork
Breadcrumbs::for('artwork.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Artwork', route('artwork.list'));
});

// Home > Materials
Breadcrumbs::for('materials.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Materials', route('materials.list'));
});

// Home > Materials > Create Color
Breadcrumbs::for('colors.create', function ($trail) {
    $trail->parent('materials.list');
    $trail->push('Create Color', route('colors.create'));
});

// Home > Materials > Show Color
Breadcrumbs::for('colors.show', function ($trail, $color) {
    $trail->parent('materials.list');
    $trail->push($color->name, route('colors.show', $color->id));
});

// Home > Materials > Show Printer
Breadcrumbs::for('printers.show', function ($trail, $printer) {
    $trail->parent('materials.list');
    $trail->push($printer->name, route('printers.show', $printer->id));
});

// Home > Materials > Printers > Show Printer Colors
Breadcrumbs::for('colors.printer', function ($trail, $printer) {
    $trail->parent('printers.show', $printer);
    $trail->push("{$printer->name} colors", route('colors.printer', $printer->id));
});

// Home > Materials > Create Fabric
Breadcrumbs::for('fabrics.create', function ($trail) {
    $trail->parent('materials.list');
    $trail->push('Create Fabric', route('fabrics.create'));
});

// Home > Materials > Show Fabric
Breadcrumbs::for('fabrics.show', function ($trail, $fabric) {
    $trail->parent('materials.list');
    $trail->push($fabric->name, route('fabrics.show', $fabric->id));
});

// Home > Materials > Create Printer
Breadcrumbs::for('printers.create', function ($trail) {
    $trail->parent('materials.list');
    $trail->push('Create Printer', route('printers.create'));
});

// Home > Materials > Show Ink
Breadcrumbs::for('inks.show', function ($trail, $ink) {
    $trail->parent('materials.list');
    $trail->push("{$ink->manufacturer}-{$ink->version}-{$ink->type}", route('inks.show', $ink->id));
});

// Home > Materials > Create Ink
Breadcrumbs::for('inks.create', function ($trail) {
    $trail->parent('materials.list');
    $trail->push('Create Ink', route('inks.create'));
});
