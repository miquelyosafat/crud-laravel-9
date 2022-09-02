<?php

namespace App\Http\Controllers;

use App\Models\Kamera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KameraController extends Controller
{
    public function index()
    {
        //get posts
        $kameras = Kamera::latest()->paginate(5);

        //render view with posts
        return view('kameras.index', compact('kameras'));
    }

    public function create()
    {
        return view('kameras.create');
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'     => 'required|min:1',
            'brand'     => 'required|min:2',
            'harga'   => 'required|min:1',
            'stock'   => 'required|min:1',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/kameras', $image->hashName());

        //create Kamera
        Kamera::create([
            'image'     => $image->hashName(),
            'nama'      => $request->nama,
            'brand'     => $request->brand,
            'harga'     => $request->harga,
            'stock'     => $request->stock
        ]);

        //redirect to index
        return redirect()->route('kameras.index')->with(['success' => 'Data Kamera Berhasil Disimpan!']);
    }

    public function edit(Kamera $kamera)
    {
        return view('kameras.edit', compact('kamera'));
    }

    public function update(Request $request, Kamera $kamera)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'      => 'required|min:1',
            'brand'     => 'required|min:2',
            'harga'     => 'required|min:1',
            'stock'     => 'required|min:1',
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/kameras', $image->hashName());

            //delete old image
            Storage::delete('public/kameras/'.$kamera->image);

            //update post with new image
            $kamera->update([
                'image'     => $image->hashName(),
                'nama'      => $request->nama,
                'brand'     => $request->brand,
                'harga'     => $request->harga,
                'stock'     => $request->stock
            ]);

        } else {

            //update post without image
            $kamera->update([
                'nama'      => $request->nama,
                'brand'     => $request->brand,
                'harga'     => $request->harga,
                'stock'     => $request->stock
            ]);
        }

        //redirect to index
        return redirect()->route('kameras.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Kamera $kamera)
    {
        //delete image
        Storage::delete('public/kameras/'. $kamera->image);

        //delete post
        $kamera->delete();

        //redirect to index
        return redirect()->route('kameras.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
