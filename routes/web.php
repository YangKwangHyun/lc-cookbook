<?php

use App\Http\Controllers\ProfileController;
use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

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

// charts
Route::get('/charts', [App\Http\Controllers\ChartsController::class, 'index'])->name('charts');

// stats
Route::get('/stats', function () {
    return view('stats');
})->name('stats');

Route::get('/announcement', function () {
    $announcement = \App\Models\Announcement::first();

    abort_if(!$announcement->isActive, 404);

    return view('announcement', [
        'announcement' => $announcement,
    ]);
});

Route::get('/announcement/edit', function () {
    $announcement = \App\Models\Announcement::first();

    return view('edit-announcement', [
        'announcement' => $announcement,
    ]);
})->name('announcement.edit');

Route::patch('/announcement/update', function (\Illuminate\Http\Request $request) {
    // dd($request->all());

    $fields = $request->validate([
        'isActive'    => 'required',
        'bannerText'  => 'required',
        'bannerColor' => 'required',
        'titleText'   => 'required',
        'titleColor'  => 'required',
        'content'     => 'required',
        'buttonText'  => 'required',
        'buttonLink'  => 'required|url',
        'buttonColor' => 'required',
        'imageUpload' => 'file|image|max:20000',
        'imageUploadFilePond' => 'string|nullable',
    ]);

    if($request->imageUpload) {
        $requestImage = $request->file('imageUpload');

        $image = Image::make($requestImage);

        $image->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $path = config('filesystems.disks.public.root') . '/' . $requestImage->hashName();
        $image->save($path);

        $fields = array_merge($fields, ['imageUpload' => $requestImage->hashName()]);

        // $path = $request->file('imageUpload')->store('images', 'public');
        // $fields = array_merge($fields, ['imageUpload' => $path]);
    }

    // if($request->imageUploadFilePond) {
    //     $newFileName = \Illuminate\Support\Str::after($request->imageUploadFilePond, 'tmp/');
    //     Storage::disk('public')->move($request->imageUploadFilePond, "images/$newFileName");
    //     $fields = array_merge($fields, ['imageUploadFilePond' =>  "images/$newFileName"]);
    // }


    $announcement = \App\Models\Announcement::first();

    $announcement->update($fields);

    return back()->with('success_message', 'Announcement was updated!');
})->name('announcement.update');

Route::post('/upload', function(\Illuminate\Http\Request $request) {
    if($request->imageUploadFilePond) {
        $path = $request->file('imageUploadFilePond')->store('tmp', 'public');
    }

    return $path;
});

Route::get('/posts', function () {
    return view('posts.index', [
        'posts' => Post::latest()->get(),
    ]);
})->name('posts.index');

Route::get('/posts/create', function () {
    return view('posts.create', [
        'post' => new Post,
    ]);
})->name('posts.create');

Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', [
        'post' => $post,
    ]);
});

Route::post('/posts/create', function (PostFormRequest $request) {
    // Post::create(fields($request));
    $request->updateOrCreate(new Post());

    return redirect('/posts')->with('success_message', 'Post was created!');
});

Route::get('/posts/{post}/edit', function (Post $post) {
    return view('posts.edit', [
        'post' => $post,
    ]);
});



Route::patch('/posts/{post}', function (Post $post, PostFormRequest $request) {

    // $post->update(fields($request));
    $request->updateOrCreate($post);

    return redirect('/posts/'.$post->id)->with('success_message', 'Post was updated!');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

function fields(PostFormRequest $request)
{
    return [
        'user_id' => 1,
        'title' => $request->title,
        'body' => $request->body,
    ];
}
