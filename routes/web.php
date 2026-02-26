<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ScriptController;
use App\Http\Controllers\CallLeadUploadController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\TwilioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect('/login');
});


Auth::routes(['verify' => true, 'reset' => true]);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marks the user as verified
    return redirect('/user/dashboard'); // Change to your redirect path
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');





Route::middleware(['auth', 'session.expired', 'verified'])->group(function () {    

    // User Dashboard
    Route::get('/user/dashboard', [App\Http\Controllers\UserController::class, 'userdashboard'])->name('userdashboard');
    Route::get('/user/profile', [App\Http\Controllers\ProfileController::class, 'profile'])->name('profile');

    // Check Admin Approval Status for User Dashboard 
    Route::get('/check-approval-status', function () {return response()->json(['approved' => auth()->check() && auth()->user()->is_admin_approved, ]);})->name('check.approval.status');
    
    // Ticket Support
    Route::post('/user/ticket/submit', [App\Http\Controllers\TicketController::class, 'submitTicket'])->name('ticket.submit');
    Route::post('/user/tickets/store', [App\Http\Controllers\TicketController::class, 'storeTicket'])->name('ticket.store');

    // Pages
    
    Route::get('/user/scripts', [App\Http\Controllers\UserController::class, 'scripts'])->name('scripts');
    Route::get('/user/calllogs', [App\Http\Controllers\UserController::class, 'calllogs'])->name('calllogs');

    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/user/flow-us', [App\Http\Controllers\UserController::class, 'flowus'])->name('flowus');
    Route::get('/user/how-to-use', [App\Http\Controllers\UserController::class, 'use'])->name('use');

    Route::get('/user/mobile-apps', [App\Http\Controllers\UserController::class, 'mobileapp'])->name('mobileapp');
    
    Route::get('/user/help_support', [App\Http\Controllers\UserController::class, 'help'])->name('help');
    Route::get('/user/privacy', [App\Http\Controllers\UserController::class, 'privacy'])->name('privacy');


    // Lock Pages
    Route::get('/user/paid/index',[App\Http\Controllers\LockPageController::class, 'index'])->name('paidpage.index');

    // Robotic Call pages
    Route::get('user/scripts', [ScriptController::class, 'index'])->name('scripts.index');
    Route::post('user/scripts', [ScriptController::class, 'store'])->name('scripts.store');
    Route::put('user/scripts/{script}', [ScriptController::class, 'update'])->name('scripts.update');
    Route::delete('user/scripts/{script}', [ScriptController::class, 'destroy'])->name('scripts.destroy');
    
    // Upload option
    Route::get('/user/uploadcsv', [CallLeadUploadController::class, 'index'])->name('uploadcsv.index');

    Route::post('/call-leads/upload', [CallLeadUploadController::class, 'store'])
        ->name('call-leads.upload.store');

    // Campaigns
    Route::get('/user/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::post('/user/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');

    Route::post('/user/campaigns/{campaign}/start', [CampaignController::class, 'start'])->name('campaigns.start');
    Route::post('/user/campaigns/{campaign}/stop', [CampaignController::class, 'stop'])->name('campaigns.stop');

});

Route::middleware('auth','is_Admin')->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'admindashboard'])->name('admindashboard');
    Route::get('/admin/all-user', [App\Http\Controllers\AdminController::class, 'alluser'])->name('alluser');

    Route::get('/admin/user/edit/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->name('editUser');
    Route::post('/admin/user/update/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('updateUser');

    Route::post('/admin/user/del/{id}', [App\Http\Controllers\AdminController::class, 'userDelete'])->name('userDelete');

    Route::get('/admin/user/create', [App\Http\Controllers\AdminController::class, 'admCreateReg'])->name('admCreateReg');
    Route::post('/admin/user/create/success', [App\Http\Controllers\AdminController::class, 'admUserReg'])->name('admUserReg');

    // Search User
    Route::get('/admin/user/search', [App\Http\Controllers\AdminController::class, 'searchUser'])->name('searchUser');

    // Download All User
    Route::get('/admin/user/download', [App\Http\Controllers\AdminController::class, 'downloadUser'])->name('downloadUser');




});
Route::match(['get','post'], '/twilio/voice', [TwilioController::class, 'voice']);
