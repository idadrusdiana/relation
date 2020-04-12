<?php

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
    return view('welcome');
});

use App\Category;
use App\Post;
use App\Profile;
use App\User;

Route::get('/create_user', function(){
    $user = User::create([
        'name' => 'Idad',
        'email' => 'Idad@outlook.com',
        'password' => bcrypt('password')
    ]);
    return $user;
});

Route::get('/create_profile', function(){
    // $profile = Profile::create([
    //     'user_id'   => '2',           
    //     'phone'     => '0996222938116',
    //     'address'   => 'Kp. Sukamaju'
    // ]);

    $user = User::find(3);

    $data = [
        'phone' => '089622938113',
        'address' => 'Jln Maju Terus'
    ];

    $user->profile()->create($data);
    return $user;
});

Route::get('/create_user_profile', function()
{
    $user   = User::find(2);

    $profile = new Profile([
        'phone'  => '089622938112',
        'address' => 'Kp. Maju'
    ]);
    $user->profile()->save($profile);
    return $user;
    
});

Route::get('/read_user', function()
{
    $user = User::find(2);

    $data = [
        'name' => $user->name,
        'phone' => $user->profile->phone,
        'address' => $user->profile->address
    ];
    return $data;
});

Route::get('/read_profile', function()
{
    $profile = Profile::where('phone','089622938112')->first();
    
    // return $profile->user->name;
    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->phone,
        'address' => $profile->address
    ];
    
    return $data;
});

Route::get('/update_profile', function()
{
    $user = User::find(2);

    $data = [
        'phone' => '08762212123',
        'address' => 'Jl. Kenangan, 123'
    ];

    $user->profile()->update($data);

    return $user;
});

Route::get('/delete_profile', function()
{
    $user=User::find(3);
    $user->profile()->delete();

    return ($user);
});

Route::get('/create_post', function()
{
    $user = User::create([
        'name' => 'Faiz',
        'email' => 'Faiz@gmail.com',
        'password' => bcrypt('password')
    ]);

    // $user = User::findorFail(1);
    $user->posts()->create([
        'title' => 'Isi Title Post Baru Faiz',
        'body' => 'Hello World ! Ini isi dari body table Post Baru Faiz'
    ]);

    return 'Success';
});

Route::get('/read_post', function(){
    $user = User::find(1);

    $posts = $user->posts()->get();

    foreach ($posts as $post) 
    {
        $data[] = [
            'name' => $post->user->name,
            'post_id' => $post->id,
            'title' => $post->title,
            'body' => $post->body
        ];        
    }

    return $data;
});

Route::get('/update_post', function()
{
    $user = User::findorFail(1);

    /**
     * Update data berdasarkan id post
     */
    // $user->posts()->whereId(5)->update([
    //     'title' => 'Ini isian Title post update5',
    //     'body' => 'Ini isian bodypost yang sudah diupdate5'
    // ]);


    /**
     * Update data secara seluruh
     */
    $user->posts()->update([
        'title' => 'Ini isian title post',
        'body'  => 'Ini isian body post yang sudah diupdate'
    ]);
    return $user;
});

Route::get('/delete_post', function()
{
    $user = User::find(5);

    $user->posts()->whereuser_id(5)->delete();

    // Untuk menhapus berdasarkan id post
    // $user->posts()->whereid(1)->delete();

    return 'Success';
});

Route::get('/create_categories', function()
{
    // $post = Post::find(8);     
    // $post->categories()->create([
    //     'slug' => str_slug('PHP', '-'),
    //     'category' => 'PHP'
    // ]);

    // return 'Success';


    $user = User::create([
        'name' => 'Hakim',
        'email' => 'hakim@gmail.com',
        'password' => bcrypt('password')
    ]);

    $user->posts()->create(
        [
            'title' => 'New Title',
            'body'  => 'New Body Content'
        ])->categories()->create(
            [
                'slug' => str_slug('New Category', '-'),
                'category' => 'New Category'
            ]);

    return 'Success';
});

Route::get('/read_categories', function()
{
    // $posts = Post::find(8);

    // $categories = $posts->categories->where('id',3);
    // foreach ($categories as $category) {
    //     echo $category->slug. '</br>';
    // }

    $categories = Category::find(4);

    $posts = $categories->posts;
    foreach ($posts as $post) {
        echo $post->title . '</br>';        
    }
});

Route::get('/attach', function()
{
    $post = Post::find(11);
    $post->categories()->attach([2,3,4]);

    return 'Success';
});

Route::get('/detach', function()
{
    $post = Post::find(11);
    // $post->categories()->detach([2,3]); for ditentukan yang akan di deletnya
    $post->categories()->detach(); //for all data will delete
    
    return 'Success';
});

Route::get('/sync', function()
{
    $post = Post::find(11);
    $post->categories()->sync([3]);

    return 'Success';
});
