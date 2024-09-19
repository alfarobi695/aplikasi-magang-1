<?php

namespace App\Http\Controllers;
use App\Models\HakimPembimbing;
use Illuminate\Http\Request;

class HakimPembimbingController extends Controller
{
    public function index()
    {
        $hakimPembimbing = HakimPembimbing::with('mahasiswa')->orderBy('nama_hakim')->get();
        return view('hakim_pembimbing.index', compact('hakimPembimbing'));
    }

    public function create()
    {
        return view('hakim_pembimbing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hakim' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:hakim_pembimbing',
        ]);

        HakimPembimbing::create($request->all());
        return redirect()->route('hakim_pembimbing.index')->with('success', 'Data hakim pembimbing berhasil ditambahkan.');
    }

    public function edit(HakimPembimbing $hakimPembimbing)
    {
        return view('hakim_pembimbing.edit', compact('hakimPembimbing'));
    }

    public function update(Request $request, HakimPembimbing $hakimPembimbing)
    {
        $request->validate([
            'nama_hakim' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:hakim_pembimbing,nip,' . $hakimPembimbing->id,
        ]);

        $hakimPembimbing->update($request->all());
        return redirect()->route('hakim_pembimbing.index')->with('success', 'Data hakim pembimbing berhasil diperbarui.');
    }

    public function destroy(HakimPembimbing $hakimPembimbing)
    {
        $hakimPembimbing->delete();
        return redirect()->route('hakim_pembimbing.index')->with('success', 'Data hakim pembimbing berhasil dihapus.');
    }
}
