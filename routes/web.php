<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Requestor\TSController as RequestorTs;
use App\Http\Controllers\Approver\TSController as ApproverTs;
use App\Http\Controllers\Requestor\PCVController as RequestorPCVController;
use App\Http\Controllers\Approver\PCVController as ApproverPCVController;
use App\Http\Controllers\Payable\PCVController as PayablePCVController;
use App\Http\Controllers\Requestor\PCFRController as RequestorPCFRController;
use App\Http\Controllers\Approver\PCFRController as ApproverPCFRController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\ChargesController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\PosTransactionController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BranchGroupController;
use App\Http\Controllers\TruckersController;
use App\Http\Controllers\AccountMatrixController;
use App\Http\Controllers\BranchDepartmentController;
use App\Http\Controllers\JobRequestController;



Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['web', 'auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->group(function() {

        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::get('create', [UsersController::class, 'create'])->name('users.create');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('users.edit');

        Route::post('store', [UsersController::class, 'store'])->name('users.store');

        Route::put('update/{id}', [UsersController::class, 'update'])->name('users.update');

    });


    Route::prefix('roles')->group(function() {

        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
        Route::get('create', [RolesController::class, 'create'])->name('roles.create');
        Route::get('edit/{id}', [RolesController::class, 'edit'])->name('roles.edit');


        Route::post('store', [RolesController::class, 'store'])->name('roles.store');
        Route::post('/roles-permissions', [RolesController::class, 'rolePermissions'])->name('roles.permissions');

        Route::put('update/{id}', [RolesController::class, 'update'])->name('roles.update');

    });


    Route::prefix('permissions')->group(function() {

        Route::get('/', [PermissionsController::class, 'index'])->name('permissions.index');
        Route::get('create', [PermissionsController::class, 'create'])->name('permissions.create');

        Route::post('store', [PermissionsController::class, 'store'])->name('permissions.store');

    });


    Route::prefix('modules')->group(function() {

        Route::get('/', [ModulesController::class, 'index'])->name('modules.index');
        Route::get('create', [ModulesController::class, 'create'])->name('modules.create');
        Route::get('edit/{id}', [ModulesController::class, 'edit'])->name('modules.edit');

        Route::post('store', [ModulesController::class, 'store'])->name('modules.store');

        Route::put('update/{id}', [ModulesController::class, 'update'])->name('modules.update');

    });


    Route::prefix('vendors')->group(function() {

        Route::get('/', [VendorsController::class, 'index'])->name('vendors.index');
        Route::get('create', [VendorsController::class, 'create'])->name('vendors.create');
        Route::get('edit/{id}', [VendorsController::class, 'edit'])->name('vendors.edit');

        Route::post('store', [VendorsController::class, 'store'])->name('vendors.store');

        Route::put('update/{id}', [VendorsController::class, 'update'])->name('vendors.update');

    });


    Route::prefix('accounts')->group(function() {

        Route::get('/', [AccountsController::class, 'index'])->name('accounts.index');
        Route::get('create', [AccountsController::class, 'create'])->name('accounts.create');
        Route::get('edit/{id}', [AccountsController::class, 'edit'])->name('accounts.edit');
        Route::get('show/{id}', [AccountsController::class, 'show'])->name('accounts.show');

        Route::post('store', [AccountsController::class, 'store'])->name('accounts.store');

        Route::put('update/{id}', [AccountsController::class, 'update'])->name('accounts.update');

    });


    Route::prefix('account-transactions')->group(function() {

        Route::get('/', [AccountTransactionController::class, 'index'])->name('account-transactions.index');
        Route::get('create', [AccountTransactionController::class, 'create'])->name('account-transactions.create');
        Route::get('edit/{id}', [AccountTransactionController::class, 'edit'])->name('account-transactions.edit');
        Route::get('show/{id}', [AccountTransactionController::class, 'show'])->name('account-transactions.show');

        Route::post('store', [AccountTransactionController::class, 'store'])->name('account-transactions.store');

        Route::put('update/{id}', [AccountTransactionController::class, 'update'])->name('account-transactions.update');

    });


    Route::prefix('charges')->group(function() {

        Route::get('/', [ChargesController::class, 'index'])->name('charges.index');
        Route::get('create', [ChargesController::class, 'create'])->name('charges.create');
        Route::get('edit/{id}', [ChargesController::class, 'edit'])->name('charges.edit');
        Route::get('show/{id}', [ChargesController::class, 'show'])->name('charges.show');

        Route::post('store', [ChargesController::class, 'store'])->name('charges.store');

        Route::put('update/{id}', [ChargesController::class, 'update'])->name('charges.update');

    });


    Route::prefix('ts')->group(function() {

        Route::prefix('requestor')->group(function() {
            Route::get('/', [RequestorTs::class, 'index'])->name('requestor.ts.index');
            Route::get('create', [RequestorTs::class, 'create'])->name('requestor.ts.create');
            Route::get('ts-search', [RequestorTs::class, 'search'])->name('requestor.ts.search');
            Route::get('show/{id}', [RequestorTs::class, 'show'])->name('requestor.ts.show');

            Route::post('store', [RequestorTs::class, 'store'])->name('requestor.ts.store');

            Route::put('status-update/{id}', [RequestorTs::class, 'statusUpdate'])->name('requestor.ts.status-update');

        });
        Route::prefix('approver')->group(function() {
            Route::get('/', [ApproverTs::class, 'index'])->name('approver.ts.index');
            Route::get('show/{id}', [ApproverTs::class, 'show'])->name('approver.ts.show');

            Route::put('approve/{id}', [ApproverTs::class, 'approve'])->name('approver.ts.approve');
            Route::put('approve-with-code/{id}', [ApproverTs::class, 'approveWithCode'])->name('approver.ts.approve-with-code');
            Route::put('disapprove/{id}', [ApproverTs::class, 'disapprove'])->name('approver.ts.disapprove');

        });

        Route::put('approver-action/{id}', [TSController::class, 'approverAction'])->name('ts.approver-action');

    });


    Route::prefix('pcv')->group(function() {

        Route::prefix('requestor')->group(function() {
            Route::get('/', [RequestorPCVController::class, 'index'])->name('requestor.pcv.index');
            Route::get('create', [RequestorPCVController::class, 'create'])->name('requestor.pcv.create');
            Route::get('get-cancelled-pcv', [RequestorPCVController::class, 'cancelled'])->name('requestor.pcv.cancelled');
            Route::get('show/{pcv}', [RequestorPCVController::class, 'show'])->name('requestor.pcv.show');
            Route::get('edit/{pcv}', [RequestorPCVController::class, 'edit'])->name('requestor.pcv.edit');

            Route::get('copy-pcv/{pcv}', [RequestorPCVController::class, 'copyPCV'])->name('requestor.pcv.copy-pcv');

            Route::post('store', [RequestorPCVController::class, 'store'])->name('requestor.pcv.store');

            Route::put('update/{pcv}', [RequestorPCVController::class, 'update'])->name('requestor.pcv.update');
            Route::put('status-update/{id}', [RequestorPCVController::class, 'statusUpdate'])->name('requestor.pcv.status-update');
            Route::put('received-pcv/{id}', [RequestorPCVController::class, 'receivedPcv'])->name('requestor.pcv.received-pcv');

        });

        Route::prefix('approver')->group(function() {

            Route::get('/', [ApproverPCVController::class, 'index'])->name('approver.pcv.index');
            Route::get('show/{pcv}', [ApproverPCVController::class, 'show'])->name('approver.pcv.show');

            Route::put('approve/{id}', [ApproverPCVController::class, 'approve'])->name('approver.pcv.approve');
            Route::put('approve-with-code/{id}', [ApproverPCVController::class, 'approveWithCode'])->name('approver.pcv.approve-with-code');
            Route::put('disapprove/{id}', [ApproverPCVController::class, 'disapprove'])->name('approver.pcv.disapprove');

        });

    });


    Route::prefix('pcfr')->group(function() {

        Route::prefix('requestor')->group(function() {
            Route::get('/', [RequestorPCFRController::class, 'index'])->name('requestor.pcfr.index');
            Route::get('create', [RequestorPCFRController::class, 'create'])->name('requestor.pcfr.create');
            Route::get('generatepcrf', [RequestorPCFRController::class, 'generatepcrf'])->name('requestor.pcfr.generatepcrf');
            Route::get('show/{id}', [RequestorPCFRController::class, 'show'])->name('requestor.pcfr.show');

            Route::post('store', [RequestorPCFRController::class, 'store'])->name('requestor.pcfr.store');

            Route::put('status-update/{id}', [RequestorPCFRController::class, 'statusUpdate'])->name('requestor.pcfr.status-update');

        });

        Route::prefix('approver')->group(function() {

            Route::get('/', [ApproverPCFRController::class, 'index'])->name('approver.pcfr.index');
            Route::get('show/{id}', [ApproverPCFRController::class, 'show'])->name('approver.pcfr.show');

            Route::put('disapprove/{id}', [ApproverPCFRController::class, 'disapprove'])->name('approver.pcfr.disapprove');
            Route::put('approve/{id}', [ApproverPCFRController::class, 'approve'])->name('approver.pcfr.approve');
            Route::put('approve-with-code/{id}', [ApproverPCFRController::class, 'approveWithCode'])->name('approver.pcfr.approve-with-code');

        });

    });


    Route::prefix('attachments')->group(function() {

        Route::post('upload', [AttachmentController::class, 'upload'])->name('attachments.upload');

    });


    Route::prefix('pos-transactions')->group(function() {

        Route::get('search', [PosTransactionController::class, 'search'])->name('pos-transactions.search');

    });


    Route::prefix('job-request')->group(function() {

        Route::get('search', [JobRequestController::class, 'search'])->name('job-request.search');

    });


    Route::prefix('branch')->group(function() {

        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('create', [BranchController::class, 'create'])->name('branch.create');
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
        Route::get('department-list', [BranchController::class, 'list'])->name('branch.list');

        Route::post('store', [BranchController::class, 'store'])->name('branch.store');

        Route::put('update/{id}', [BranchController::class, 'update'])->name('branch.update');

    });


    Route::prefix('branch-group')->group(function() {

        Route::get('/', [BranchGroupController::class, 'index'])->name('branch-group.index');
        Route::get('create', [BranchGroupController::class, 'create'])->name('branch-group.create');
        Route::get('edit/{id}', [BranchGroupController::class, 'edit'])->name('branch-group.edit');

        Route::post('store', [BranchGroupController::class, 'store'])->name('branch-group.store');

        Route::put('update/{id}', [BranchGroupController::class, 'update'])->name('branch-group.update');

    });

    Route::prefix('branch-departments')->group(function() {

        Route::get('show/{id}', [BranchDepartmentController::class, 'show'])->name('branch-departments.index');

    });


    Route::prefix('truckers')->group(function() {

        Route::get('search', [TruckersController::class, 'search'])->name('truckers.search');
       
    });


    Route::prefix('account-matrix')->group(function() {

        Route::get('/', [AccountMatrixController::class, 'index'])->name('account-matrix.index');
        Route::get('create', [AccountMatrixController::class, 'create'])->name('account-matrix.create');
        Route::get('edit/{id}', [AccountMatrixController::class, 'edit'])->name('account-matrix.edit');

        Route::post('store', [AccountMatrixController::class, 'store'])->name('account-matrix.store');

        Route::put('update/{id}', [AccountMatrixController::class, 'update'])->name('account-matrix.update');
       
    });

});