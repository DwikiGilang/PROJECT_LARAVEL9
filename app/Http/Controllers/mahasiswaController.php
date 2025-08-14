<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class mahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if (strlen($katakunci)) {
            $data = mahasiswa::where('nim', 'like', "%$katakunci%")
                ->orWhere('nama', 'like', "%$katakunci%")
                ->orWhere('jurusan', 'like', "%$katakunci%")
                 ->orWhere('kelas', 'like', "%$katakunci%")
                 ->orWhere('umur', 'like', "%$katakunci%")
                ->paginate($jumlahbaris);
        } else {
            $data = mahasiswa::orderBy('nim', 'desc')->paginate($jumlahbaris);
        }
        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
        Session::flash('kelas', $request->kelas);
        Session::flash('umur', $request->umur);

        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'nama' => 'required',
            'jurusan' => 'required',
             'kelas' => 'required',
             'umur' => 'required|numeric',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.numeric' => 'NIM wajib dalam angka',
            'nim.unique' => 'NIM yang diisikan sudah ada dalam database',
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
            'kelas.required' => 'kelas wajib diisi',
            'umur.required' => 'Umur wajib diisi',
            'umur.numeric' => 'Umur wajib dalam angka',
        ]);
        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'umur' => $request->umur,
        ];
        mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'umur' => 'required|numeric',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
             'kelas.required' => 'kelas wajib diisi',
            'umur.required' => 'Umur wajib diisi',
            'umur.numeric' => 'Umur wajib dalam angka',
        ]);
        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'umur' => $request->umur,
        ];
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success', 'Berhasil melakukan delete data');
    }
}
