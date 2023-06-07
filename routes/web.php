<?php
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Document\DocumentLibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tweet\TweetStoreController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/tweets', TweetStoreController::class)->name('tweets.store');
Route::get('/tweets/{tweet}/edit', 'App\Http\Controllers\Tweet\TweetEditController@edit')->name('tweets.edit');
Route::put('/tweets/{tweet}', 'App\Http\Controllers\Tweet\TweetEditController@update')->name('tweets.update');
Route::delete('/tweets/{tweet}', 'App\Http\Controllers\Tweet\TweetDeleteController')->name('tweets.destroy');

Route::get('/documents', [DocumentLibraryController::class, 'show'])->name('documents.index');
Route::get('/documents/create', [DocumentLibraryController::class, 'create'])->name('documents.create');
Route::post('/documents', [DocumentLibraryController::class, 'store'])->name('documents.store');
Route::delete('/documents/{document}', [DocumentLibraryController::class, 'destroy'])->name('documents.destroy');


Route::middleware('auth')->group(function () {
    Route::resource('contacts', ContactController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
    Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
    Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
    Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
