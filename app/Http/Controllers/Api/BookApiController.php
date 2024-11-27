<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku; // Import model Buku
use App\Http\Resources\BookResource;

class BookApiController extends Controller
{
    /**
     * Menampilkan daftar buku (GET /api/books).
     */
    public function index()
    {
        $books = Buku::latest()->paginate(5);
        return new BookResource(true, 'List Data Buku', $books);
    }

    /**
     * Menyimpan buku baru (POST /api/books).
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul'     => 'required|string',
            'penulis'   => 'required|string|max:30',
            'harga'     => 'required|numeric',
            'tgl_terbit'=> 'required|date',
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return new BookResource(true, 'Data Buku Berhasil Ditambahkan', $buku);
    }

    /**
     * Menampilkan detail buku (GET /api/books/{id}).
     */
    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data Buku Tidak Ditemukan'
            ], 404);
        }

        return new BookResource(true, 'Detail Data Buku', $buku);
    }

    /**
     * Memperbarui buku (PUT /api/books/{id}).
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul'     => 'required|string',
            'penulis'   => 'required|string|max:30',
            'harga'     => 'required|numeric',
            'tgl_terbit'=> 'required|date',
        ]);

        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data Buku Tidak Ditemukan'
            ], 404);
        }

        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return new BookResource(true, 'Data Buku Berhasil Diperbarui', $buku);
    }

    /**
     * Menghapus buku (DELETE /api/books/{id}).
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Data Buku Tidak Ditemukan'
            ], 404);
        }

        $buku->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Buku Berhasil Dihapus'
        ]);
    }

    /**
     * Menampilkan halaman view books_api.
     */
    public function viewBooksApi()
    {
        return view('api.books_api'); // Path ke file Blade
    }
}
