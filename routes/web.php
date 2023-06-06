<?php


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\ForumController;
use App\Http\Controllers\Frontend\ForumCommentsController;
use App\Http\Controllers\Admin\ForumAdminController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Admin\VideoclipController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|App\Http\Controllers\
Route::get('/', function () {
return view('welcome');
});
*/


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [FrontendController::class, 'index']);
Route::get('category', [FrontendController::class, 'category']);
Route::get('category/{name}', [FrontendController::class, 'viewcategory']);
Route::get('category/{cate_name}/{sect_name}', [FrontendController::class, 'sectionview']);
Route::get('section-list', [FrontendController::class, 'sectionlistAjax']);
Route::post('searchsection', [FrontendController::class, 'searchSection']);

Route::get('forum-list', [ForumController::class, 'forumlistAjax']);
Route::post('searchforum', [ForumController::class, 'searchForum']);

Route::get('forum', [ForumController::class, 'index']);
Route::get('forum/{id}', [ForumController::class, 'view']);
Route::get('forum-category/{name}', [ForumController::class, 'category']);
Route::get('add-forum', [ForumController::class, 'add']);
Route::post('insert-forum', [ForumController::class, 'insert']);
Route::post('insert-comment', [ForumController::class, 'insertcomment']);

Route::post('forum/{id}/like', [ForumController::class, 'like']);
Route::post('forum/{id}/dislike', [ForumController::class, 'dislike']);
Route::get('forum-delete/{id}', [ForumController::class, 'destroy']);
Route::get('forum-delete-comment/{id}', [ForumController::class, 'destroycomment']);

Route::post('forum-comment/{id}/like', [ForumController::class, 'likecomment']);
Route::post('forum-comment/{id}/dislike', [ForumController::class, 'dislikecomment']);




Route::get('user/{username}', [UserController::class, 'user'])->name('user');
Route::post('user-update/{id}', [UserController::class, 'update']);
Route::post('user-updategoogle/{id}', [UserController::class, 'updategoogle']);



Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {
    try {
        $user_google = Socialite::driver('google')
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->stateless()
            ->user();

        // Reemplaza los espacios en el nombre con guiones bajos
        $username = str_replace(' ', '_', $user_google->name);

        // Agrega algunos números aleatorios al nombre de usuario
        $username = $username . '_' . rand(100, 999);

        // Recorta el nombre de usuario si es demasiado largo
        $username = substr($username, 0, 20);

        $user = User::updateOrCreate([
            'google_id' => $user_google->id,
        ], [
                'name' => $user_google->name,
                'username' => $username,
                'email' => $user_google->email,
            ]);

        Auth::login($user);

        return redirect('/');
    } catch (\Exception $e) {
        return Redirect::to('/')
            ->with('status', 'error')
            ->with('message', 'No se pudo iniciar sesión con Google. Por favor, inténtalo de nuevo.');
    }
});




Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::post('add-rating', [RatingController::class, 'add']);

    Route::get('add-review/{section_name}/userreview', [ReviewController::class, 'add']);
    Route::post('add-review', [ReviewController::class, 'create']);
    Route::get('edit-review/{section_name}/userreview', [ReviewController::class, 'edit']);
    Route::put('update-review', [ReviewController::class, 'update']);
    Route::get('delete-review/{id}', [ReviewController::class, 'destroy']);

});


Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', 'Admin\FrontendController@index')->name('admin.dashboard');
    Route::get('videoclips', 'Admin\VideoclipController@index');
    Route::get('add-videoclip', 'Admin\VideoclipController@add');
    Route::post('insert-videoclip', 'Admin\VideoclipController@insert');

    Route::get('delete-videoclip/{id}', [VideoclipController::class, 'destroy']);
    Route::get('edit-videoclip/{id}', [VideoclipController::class, 'edit']);
    Route::put('update-videoclip/{id}', [VideoclipController::class, 'update']);

    Route::get('categories', 'Admin\CategoryController@index');
    Route::get('add-category', 'Admin\CategoryController@add');
    Route::post('insert-category', 'Admin\CategoryController@insert');
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [CategoryController::class, 'update']);
    Route::get('delete-category/{id}', [CategoryController::class, 'destroy']);

    Route::get('sections', [SectionController::class, 'index']);
    Route::get('add-sections', [SectionController::class, 'add']);
    Route::post('insert-section', [SectionController::class, 'insert']);
    Route::get('edit-section/{id}', [SectionController::class, 'edit']);
    Route::put('update-section/{id}', [SectionController::class, 'update']);
    Route::get('delete-section/{id}', [SectionController::class, 'destroy']);

    Route::get('users', [DashboardController::class, 'users']);
    Route::get('edit-user/{id}', [DashboardController::class, 'edituser']);
    Route::put('update-user/{id}', [DashboardController::class, 'update']);
    Route::get('delete-user/{id}', [DashboardController::class, 'destroy']);
    Route::get('add-user', [DashboardController::class, 'add']);
    Route::post('insert-user', [DashboardController::class, 'insert']);

    Route::get('forum-admin', 'Admin\ForumAdminController@index');
    Route::get('delete-forum-admin/{id}', 'Admin\ForumAdminController@destroy');
    Route::get('delete-forum-admin/{id}/{id_comment}', 'Admin\ForumAdminController@destroycomment');
    Route::get('forum-admin/{id}', 'Admin\ForumAdminController@view');

});