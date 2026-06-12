<?php // routes/breadcrumbs.php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Example definition
Breadcrumbs::for('adminhome', function (BreadcrumbTrail $trail) {
    $trail->push('Admin Dash', route('admin.nbd.dashboard'));
});

Breadcrumbs::for('adminsalesperson', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('adminhome');
    $trail->push($id, route('sales.user', $id));
});

Breadcrumbs::for('adminallleads', function (BreadcrumbTrail $trail) {
    $trail->parent('adminhome');
    $trail->push('All Leads', route('admin.nbd.leads'));
});

Breadcrumbs::for('adminallopps', function (BreadcrumbTrail $trail) {
    $trail->parent('adminhome');
    $trail->push('All Opportunities', route('admin.nbd.opps'));
});

Breadcrumbs::for('adminallpipelines', function (BreadcrumbTrail $trail) {
    $trail->parent('adminhome');
    $trail->push('All Vending Pipelines', route('admin.nbd.pipelines'));
});