<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/otp', function () {
    return view('otp');
})->name('otp');
Route::get('/', [PostController::class, 'displaypost'])->name('homepage');
Route::get('allpostview', [PostController::class, 'viewallpost'])->name('loadallpost');
Route::get('readpost/{id}', [PostController::class, 'readmore'])->name('readmore');
Route::post('review', [PostController::class, 'reviewpost'])->name('review');

Route::get('/login', [UserController::class, 'login'])->name('ulogin');
Route::post('/auth', [UserController::class, 'auth_login'])->name('login');
Route::get('/logout', [UserController::class, 'auth_logout'])->name('logout');
Route::get('registerp', [UserController::class, 'register'])->name('rpage');
Route::post('/register', [UserController::class, 'create_user'])->name('register');
Route::any('verify', [UserController::class, 'OTPAction'])->name('otpverify');
Route::any('resend', [UserController::class, 'resendotp'])->name('resendotp');




Route::group(['middleware' => 'useradmin'], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserController::class, 'userlist'])->name('listdata');
    Route::post('approve/{id}', [UserController::class, 'adminaprove'])->name('approve');
    Route::get('/allpost', [PostController::class, 'postlist'])->name('allpost');



    Route::get('usersdetails', [UserController::class, 'userdetial'])->name('userdetails');
    Route::get('remove{id}', [UserController::class, 'delete'])->name('remove_user');
    Route::get('edit-details/{id}', [UserController::class, 'edit']);
    Route::post('update', [UserController::class, 'updatedetail'])->name('update');
    Route::get('admindel{id}', [UserController::class, 'admindel'])->name('admindelete');

    Route::get('addpost', [PostController::class, 'addpost'])->name('addpost');
    Route::get('showpost', [PostController::class, 'showpost'])->name('postlist');
    Route::post('post', [PostController::class, 'insertpost'])->name('post');
    Route::get('edit-post/{id}', [PostController::class, 'editpost']);
    route::post('updatepost', [PostController::class, 'updatepost'])->name('updatepost');

    Route::get('postdel{id}', [PostController::class, 'deletepost'])->name('deletepost');
    Route::get('adpostdel{id}', [PostController::class, 'admindeletepost'])->name('admindeletepost');

    Route::post('postaprove/{id}', [PostController::class, 'adminpostapprove'])->name('adminpostapprove');

    route::get('/envfile', [UserController::class, 'envfile'])->name('envfile');
    Route::post('/', [UserController::class, 'updateenv'])->name('updateenv');


    // Route::post('/send-message', [UserController::class, 'sendMessage'])->name('sendmsg');

    // Route::get('notificaton', [UserController::class, 'userNoti'])->name('usernotification');

    // Route::get('feedback', [UserController::class, 'giveFedback'])->name('userfedback');
    // Route::post('/sfeedback', [UserController::class, 'submitFeedback'])->name('feedback');
    // Route::get('viewfeedback', [UserController::class, 'showfeedback'])->name('viewfeedback');

    //Admin send message user Route
    Route::get('chat', [UserController::class, 'adminchat'])->name('chat');
    Route::post('/adminchat', [UserController::class, 'Adminmsg'])->name('Adminsendmessage');
    Route::post('/adminsend', [UserController::class, 'sendmessageuser'])->name('adminchatsenmsg');
    //end admin

    //User send Admin message user Route
    Route::get('uchat', [UserController::class, 'userchat'])->name('userchating');
    Route::post('userchat', [UserController::class, 'usermsg'])->name('usershowchat');
    Route::post('/usersend', [UserController::class, 'sendmessageadmin'])->name('userchatsenmsg');
    //end user
});
