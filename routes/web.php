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

//GET
Route::get('/movie', function () use ($movies) {
    if (!empty($movies)) {
        return $movies;
    } else {
        return response()->json('Data tidak tersedia !', 404);
    }
});

//POST
Route::post('/movie', function () use ($movies) {
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
});


// PUT
Route::put('/movie/{id}', function ($id) use ($movies) {
    if (!empty($movies)) {
        $movies[$id]['judul'] = request('judul');
        $movies[$id]['genre'] = request('genre');
        $movies[$id]['tahun'] = request('tahun');
        return $movies;
    } else {
        return response()->json('Maaf data tidak tersedia !');
    }
});

// PATCH
Route::patch('/movie/{id}', function ($id) use ($movies) {
    if (!empty($movies)) {
        $movies[$id]['judul'] = request('judul');
        $movies[$id]['tahun'] = request('tahun');
        return $movies;
    } else {
        return response()->json('Maaf data tidak tersedia !');
    }
});

// DELETE
Route::delete('/movie/{id}', function ($id) use ($movies) {
    if (!empty($movies)) {
        unset($movies[$id]);
        return $movies;
    } else {
        return response()->json('Maaf data tidak tersedia');
    }
});


// membuat route khusus member
Route::get('/movie/{id}', function ($id) use ($movies) {
    if (!empty($movies[$id])) {
        return $movies[$id];
    } else {
        return response()->json('Maaf data yang anda cari tidak tersedia !', 404);
    }
})->middleware(['isAuth', 'isMember']); //2. pastikan alias sama seperti nama alias di app.php


// membuat route redirect middleware CheckMember
Route::get('/price', function () {
    return response()->json("Silahkan melakukan pembelian terlebih dahulu !", 200);
});

// membuat route redirect middleware isAuth
Route::get("/login", function () {
    return response()->json("Silahkan Login terlebih dahulu !!", 200);
});
