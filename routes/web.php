<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Requestor\TSController as RequestorTs;
use App\Http\Controllers\Approver\TSController as ApproverTs;
use App\Http\Controllers\Audit\TSController as AuditTs;
use App\Http\Controllers\Admin\TSController as AdminTs;
use App\Http\Controllers\Requestor\PCVController as RequestorPCVController;
use App\Http\Controllers\Approver\PCVController as ApproverPCVController;
use App\Http\Controllers\Payable\PCVController as PayablePCVController;
use App\Http\Controllers\Audit\PCVController as AuditPCVController;
use App\Http\Controllers\Admin\PCVController as AdminPCVController;
use App\Http\Controllers\Requestor\PCFRController as RequestorPCFRController;
use App\Http\Controllers\Approver\PCFRController as ApproverPCFRController;
use App\Http\Controllers\Payable\PCFRController as PayablePCFRController;
use App\Http\Controllers\Treasury\PCFRController as TreasuryPCFRController;
use App\Http\Controllers\Audit\PCFRController as AuditPCFRController;
use App\Http\Controllers\Admin\PCFRController as AdminPCFRController;
use App\Http\Controllers\PCFRController;
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

use App\Http\Controllers\ReportController;


Route::get('/', function () {
    
    return redirect('login');

});


Route::middleware(['web', 'auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')->group(function() {

        Route::get('/', [UsersController::class, 'index'])->name('users.index');
        Route::get('inactive', [UsersController::class, 'inactive'])->name('users.inactive');
        Route::get('create', [UsersController::class, 'create'])->name('users.create');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::get('show/{id}', [UsersController::class, 'show'])->name('users.show');

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
        Route::get('inactive', [VendorsController::class, 'inactive'])->name('vendors.inactive');
        Route::get('create', [VendorsController::class, 'create'])->name('vendors.create');
        Route::get('search-branch', [VendorsController::class, 'search'])->name('vendors.search');        
        Route::get('edit/{id}', [VendorsController::class, 'edit'])->name('vendors.edit');
        Route::get('show/{id}', [VendorsController::class, 'show'])->name('vendors.show');


        Route::post('store', [VendorsController::class, 'store'])->name('vendors.store');

        Route::put('update/{id}', [VendorsController::class, 'update'])->name('vendors.update');

        Route::delete('/{id}', [VendorsController::class, 'delete'])->name('vendors.delete');

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
        Route::get('inactive', [ChargesController::class, 'inactive'])->name('charges.inactive');
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
            Route::get('edit/{id}', [RequestorTs::class, 'edit'])->name('requestor.ts.edit');
            Route::get('/print/{id}', [RequestorTs::class, 'print'])->name('requestor.ts.print');

            Route::post('store', [RequestorTs::class, 'store'])->name('requestor.ts.store');

            Route::put('update/{id}', [RequestorTs::class, 'update'])->name('requestor.ts.update');
            Route::put('update1/{id}', [RequestorTs::class, 'update1'])->name('requestor.ts.update1');
            Route::put('status-update/{id}', [RequestorTs::class, 'statusUpdate'])->name('requestor.ts.status-update');

        });
        
        Route::prefix('approver')->group(function() {
            Route::get('/', [ApproverTs::class, 'index'])->name('approver.ts.index');
            Route::get('show/{id}', [ApproverTs::class, 'show'])->name('approver.ts.show');
            Route::get('/print/{id}', [ApproverTs::class, 'print'])->name('approver.ts.print');

            Route::put('approve/{id}', [ApproverTs::class, 'approve'])->name('approver.ts.approve');            
            Route::put('approve-with-code/{id}', [ApproverTs::class, 'approveWithCode'])->name('approver.ts.approve-with-code');
            Route::put('disapprove/{id}', [ApproverTs::class, 'disapprove'])->name('approver.ts.disapprove');

        });


        Route::prefix('audit')->group(function() {
            Route::get('/', [AuditTs::class, 'index'])->name('audit.ts.index');
            Route::get('show/{id}', [AuditTs::class, 'show'])->name('audit.ts.show');

            Route::get('ts-data', [AuditTs::class, 'tsData'])->name('audit.ts.data');

        });

        Route::prefix('admin')->group(function() {
            Route::get('/', [AdminTs::class, 'index'])->name('admin.ts.index');
            Route::get('show/{id}', [AdminTs::class, 'show'])->name('admin.ts.show');
        });


        Route::put('approver-action/{id}', [TSController::class, 'approverAction'])->name('ts.approver-action');

    });


    Route::prefix('pcv')->group(function() {

        Route::prefix('requestor')->group(function() {
            Route::get('/', [RequestorPCVController::class, 'index'])->name('requestor.pcv.index');
            Route::get('create', [RequestorPCVController::class, 'create'])->name('requestor.pcv.create');
            Route::get('get-cancelled-pcv', [RequestorPCVController::class, 'cancelled'])->name('requestor.pcv.cancelled');
            Route::get('check-billing-date', [RequestorPCVController::class, 'checkBillingDate'])->name('requestor.pcv.check-billing-date');
            Route::get('show/{pcv}', [RequestorPCVController::class, 'show'])->name('requestor.pcv.show');
            Route::get('edit/{pcv}', [RequestorPCVController::class, 'edit'])->name('requestor.pcv.edit');
            Route::get('/print/{id}', [RequestorPCVController::class, 'print'])->name('requestor.pcv.print');
            

            Route::get('copy-pcv/{pcv}', [RequestorPCVController::class, 'copyPCV'])->name('requestor.pcv.copy-pcv');

            Route::post('store', [RequestorPCVController::class, 'store'])->name('requestor.pcv.store');

            Route::put('update/{pcv}', [RequestorPCVController::class, 'update'])->name('requestor.pcv.update');
            Route::put('pcv-signed-attachment/{pcv}', [RequestorPCVController::class, 'pcvSigned'])->name('requestor.pcv.pcv-signed-attachment');
            Route::put('status-update/{id}', [RequestorPCVController::class, 'statusUpdate'])->name('requestor.pcv.status-update');
            Route::put('status-update1/{id}', [RequestorPCVController::class, 'statusUpdate1'])->name('requestor.pcv.status-update1');
            Route::put('received-pcv/{id}', [RequestorPCVController::class, 'receivedPcv'])->name('requestor.pcv.received-pcv');

        });

        Route::prefix('approver')->group(function() {

            Route::get('/', [ApproverPCVController::class, 'index'])->name('approver.pcv.index');
            Route::get('show/{pcv}', [ApproverPCVController::class, 'show'])->name('approver.pcv.show');

            Route::put('approve/{id}', [ApproverPCVController::class, 'approve'])->name('approver.pcv.approve');
            Route::put('approve-cancel/{id}', [ApproverPCVController::class, 'approveCancel'])->name('approver.ts.approve-cancel');
            Route::put('approve-with-code/{id}', [ApproverPCVController::class, 'approveWithCode'])->name('approver.pcv.approve-with-code');
            Route::put('disapprove/{id}', [ApproverPCVController::class, 'disapprove'])->name('approver.pcv.disapprove');

        });

        Route::prefix('audit')->group(function() {

            Route::get('/', [AuditPCVController::class, 'index'])->name('audit.pcv.index');
            Route::get('show/{pcv}', [AuditPCVController::class, 'show'])->name('audit.pcv.show');

        });

        Route::prefix('admin')->group(function() {

            Route::get('/', [AdminPCVController::class, 'index'])->name('admin.pcv.index');
            Route::get('show/{pcv}', [AdminPCVController::class, 'show'])->name('admin.pcv.show');

        });



    });


    Route::prefix('pcfr')->group(function() {

        Route::get('pcv/{id}', [PCFRController::class, 'showPCV'])->name('pcfr.show-pcv');

        Route::prefix('requestor')->group(function() {
            Route::get('/', [RequestorPCFRController::class, 'index'])->name('requestor.pcfr.index');
            Route::get('create', [RequestorPCFRController::class, 'create'])->name('requestor.pcfr.create');
            Route::get('generatepcrf', [RequestorPCFRController::class, 'generatepcrf'])->name('requestor.pcfr.generatepcrf');
            Route::get('show/{id}', [RequestorPCFRController::class, 'show'])->name('requestor.pcfr.show');
            Route::get('edit/{pcv}', [RequestorPCFRController::class, 'edit'])->name('requestor.pcfr.edit');
            Route::get('print/{id}', [RequestorPCFRController::class, 'print'])->name('requestor.pcfr.print');
            
            Route::post('store', [RequestorPCFRController::class, 'store'])->name('requestor.pcfr.store');

            Route::put('status-update/{id}', [RequestorPCFRController::class, 'statusUpdate'])->name('requestor.pcfr.status-update');
            Route::put('update/{id}', [RequestorPCFRController::class, 'update'])->name('requestor.pcfr.update');

        });

        Route::prefix('approver')->group(function() {

            Route::get('/', [ApproverPCFRController::class, 'index'])->name('approver.pcfr.index');
            Route::get('show/{id}', [ApproverPCFRController::class, 'show'])->name('approver.pcfr.show');

            Route::put('disapprove/{id}', [ApproverPCFRController::class, 'disapprove'])->name('approver.pcfr.disapprove');
            Route::put('approve/{id}', [ApproverPCFRController::class, 'approve'])->name('approver.pcfr.approve');
            Route::put('approve-with-code/{id}', [ApproverPCFRController::class, 'approveWithCode'])->name('approver.pcfr.approve-with-code');

        });


        Route::prefix('payables')->group(function() {

            Route::get('/', [PayablePCFRController::class, 'index'])->name('payable.pcfr.index');
            Route::get('for-replenished', [PayablePCFRController::class, 'forReplenished'])->name('payable.pcfr.for-replenished');
            Route::get('replenished', [PayablePCFRController::class, 'replenished'])->name('payable.pcfr.replenished');
            Route::get('show/{id}', [PayablePCFRController::class, 'show'])->name('payable.pcfr.show');

            Route::put('disapprove/{id}', [PayablePCFRController::class, 'disapprove'])->name('payable.pcfr.disapprove');
            Route::put('approve/{id}', [PayablePCFRController::class, 'approve'])->name('payable.pcfr.approve');

            Route::put('pcv/{id}/remove', [PayablePCFRController::class, 'pcvRemove'])->name('payable.pcfr.pcv-remove');

            // Route::put('approve-with-code/{id}', [ApproverPCFRController::class, 'approveWithCode'])->name('approver.pcfr.approve-with-code');

        });


        Route::prefix('treasury')->group(function() {

            Route::get('/', [TreasuryPCFRController::class, 'index'])->name('treasury.pcfr.index');
            Route::get('create', [TreasuryPCFRController::class, 'create'])->name('treasury.pcfr.create');
            Route::get('for-approval', [TreasuryPCFRController::class, 'forApproval'])->name('treasury.pcfr.for-approval');
            Route::get('temp-slips', [TreasuryPCFRController::class, 'tempSlips'])->name('treasury.pcfr.temp-slips');
            Route::get('pcvs', [TreasuryPCFRController::class, 'pcvs'])->name('treasury.pcfr.pcvs');
            Route::get('show-pcfr/{id}', [TreasuryPCFRController::class, 'showPcfr'])->name('treasury.pcfr.show-pcfr');
            Route::get('show-pcv/{id}', [TreasuryPCFRController::class, 'showPcv'])->name('treasury.pcfr.show-pcv');
            Route::get('show-ts/{id}', [TreasuryPCFRController::class, 'showTs'])->name('treasury.pcfr.show-ts');
            Route::get('edit/{id}', [TreasuryPCFRController::class, 'edit'])->name('treasury.pcfr.edit');
            Route::get('print/{id}', [TreasuryPCFRController::class, 'print'])->name('treasury.pcfr.print');

            Route::post('store', [TreasuryPCFRController::class, 'store'])->name('treasury.pcfr.store');

            Route::put('pcv/{id}/remove', [TreasuryPCFRController::class, 'pcvRemove'])->name('treasury.pcfr.pcv-remove');
            Route::put('disapprove/{id}', [TreasuryPCFRController::class, 'disapprove'])->name('treasury.pcfr.disapprove');
            Route::put('approve/{id}', [TreasuryPCFRController::class, 'approve'])->name('treasury.pcfr.approve');
            Route::put('update/{id}', [TreasuryPCFRController::class, 'update'])->name('treasury.pcfr.update');

        });


        Route::prefix('audit')->group(function() {

            Route::get('/', [AuditPCFRController::class, 'index'])->name('audit.pcfr.index');
            Route::get('show/{id}', [AuditPCFRController::class, 'show'])->name('audit.pcfr.show');

        });

        Route::prefix('admin')->group(function() {

            Route::get('/', [AdminPCFRController::class, 'index'])->name('admin.pcfr.index');
            Route::get('show/{id}', [AdminPCFRController::class, 'show'])->name('admin.pcfr.show');

        });

    });


    Route::prefix('attachments')->group(function() {

        Route::post('upload', [AttachmentController::class, 'upload'])->name('attachments.upload');

    });


    Route::prefix('pos-transactions')->group(function() {

        Route::get('search', [PosTransactionController::class, 'search'])->name('pos-transactions.search');
        Route::get('show/{id}', [PosTransactionController::class, 'show'])->name('pos-transactions.show');

    });


    Route::prefix('job-request')->group(function() {

        Route::get('search', [JobRequestController::class, 'search'])->name('job-request.search');

    });


    Route::prefix('branch')->group(function() {

        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('create', [BranchController::class, 'create'])->name('branch.create');
        Route::get('sync-branch', [BranchController::class, 'sync'])->name('branch.sync');
        Route::get('department-list', [BranchController::class, 'list'])->name('branch.list');        
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
        Route::get('show/{id}', [BranchController::class, 'show'])->name('branch.show');
        

        Route::post('store', [BranchController::class, 'store'])->name('branch.store');

        Route::put('update/{id}', [BranchController::class, 'update'])->name('branch.update');

    });


    Route::prefix('branch-group')->group(function() {

        Route::get('/', [BranchGroupController::class, 'index'])->name('branch-group.index');
        Route::get('create', [BranchGroupController::class, 'create'])->name('branch-group.create');
        Route::get('edit/{id}', [BranchGroupController::class, 'edit'])->name('branch-group.edit');
        Route::get('show/{id}', [BranchGroupController::class, 'show'])->name('branch-group.show');


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
        Route::get('inactive', [AccountMatrixController::class, 'inactive'])->name('account-matrix.inactive');
        Route::get('create', [AccountMatrixController::class, 'create'])->name('account-matrix.create');
        Route::get('edit/{id}', [AccountMatrixController::class, 'edit'])->name('account-matrix.edit');
        Route::get('show/{id}', [AccountMatrixController::class, 'show'])->name('account-matrix.show');

        Route::post('store', [AccountMatrixController::class, 'store'])->name('account-matrix.store');

        Route::put('update/{id}', [AccountMatrixController::class, 'update'])->name('account-matrix.update');
       
    });


    Route::prefix('reports')->group(function() {

        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('search', [ReportController::class, 'search'])->name('reports.search');

    });

});



// API CALL

// BRANCH

Route::get('api-branch', function() {

    return $api_branch = \DB::table('api_branch')->get();

})->name('api.branch');


Route::get('api-charge-to', function() {


    return $api_branch = \DB::table('api_branch')->get();

})->name('api.branch');


Route::get('logmeout', function() {

    \Session::flush();
    auth()->logout();
    return redirect('login');

});