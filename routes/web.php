<?php

//use App\Http\Middleware\CheckMember; // 2. bisa di hapus karna sudah menggunakan nama alias
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Materi route
$movies = [];
for ($i = 0; $i < 10; $i++) {
    $movies[] = [
        'judul' => 'Movie ' . $i,
        'genre' => 'Comedi',
        'tahun' => '2017',
    ];
}

// route group memungkin semua route dapat menggunakan middleware yang sama
Route::group(
    [
        'middleware' => ['isAuth'], //middleware yang di gunakan semua route pada group
        'prefix' => 'movie', //url yang di tuju route jika '/' maka '/movie'
        'as' => 'movie.' //nama dari route jika 'movie.' maka 'movie.namaRoute'
    ],
    function () use ($movies) {

        //GET
        Route::get('/', function () use ($movies) {
            if (!empty($movies)) {
                return $movies;
            } else {
                return response()->json('Data tidak tersedia !', 404);
            }
        })->name('GetAll');

        //POST
        Route::post('/', function () use ($movies) {
            if (isset($movies)) {
                $movies[] = [
                    'judul' => request('judul'),
                    'genre' => request('genre'),
                    'tahun' => request('tahun'),
                ];
                return $movies;
            } else {
                return response()->json('Maaf data tidak tersedia !');
            }
        })->name('Post'); //memberikan nama pada route sehingga menjadi 'movie.Post'

        // PUT
        Route::put('/{id}', function ($id) use ($movies) {
            if (!empty($movies)) {
                $movies[$id]['judul'] = request('judul');
                $movies[$id]['genre'] = request('genre');
                $movies[$id]['tahun'] = request('tahun');
                return $movies;
            } else {
                return response()->json('Maaf data tidak tersedia !');
            }
        })->name('Put');

        // PATCH
        Route::patch('/{id}', function ($id) use ($movies) {
            if (!empty($movies)) {
                $movies[$id]['judul'] = request('judul');
                $movies[$id]['tahun'] = request('tahun');
                return $movies;
            } else {
                return response()->json('Maaf data tidak tersedia !');
            }
        })->name('Patch');

        // DELETE
        Route::delete('/{id}', function ($id) use ($movies) {
            if (!empty($movies)) {
                unset($movies[$id]);
                return $movies;
            } else {
                return response()->json('Maaf data tidak tersedia');
            }
        })->name('Delete');

        // membuat route khusus member
        Route::get('/{id}', function ($id) use ($movies) {
            if (!empty($movies[$id])) {
                return $movies[$id];
            } else {
                return response()->json('Maaf data yang anda cari tidak tersedia !', 404);
            }
        })->middleware('isMember')->name('GetById'); // memberikan tambahan middleware isMember pada route movie.GetById untuk cek apakah user adalah member atau bukan

    }
);

// membuat route redirect middleware CheckMember
Route::get('/price', function () {
    return response()->json("Silahkan melakukan pembelian terlebih dahulu !", 200);
})->middleware('isAuth');

// membuat route redirect middleware isAuth
Route::get("/login", function () {
    return response()->json("Silahkan Login terlebih dahulu !!", 200);
});
