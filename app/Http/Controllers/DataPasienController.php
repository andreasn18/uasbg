<?php

namespace App\Http\Controllers;

use App\DataPasien;
use App\JumlahPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = DataPasien::all();
        $results = JumlahPasien::all();
        $provinsi = DB::table('master_kabupaten')
            ->select('nama_prop', 'kode_prop')
            ->distinct()
            ->get();
        $kabupaten = DB::table('master_kabupaten')->select('nama_kab', 'kode_kab')->where('nama_prop', '=', 'PAPUA')->get();
        // dd($kabupaten);
        return view('admin.index', compact(['results', 'provinsi', 'kabupaten']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DataPasien  $dataPasien
     * @return \Illuminate\Http\Response
     */
    public function show(DataPasien $dataPasien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DataPasien  $dataPasien
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPasien $dataPasien)
    {
        $pasien = $dataPasien;
        $results = JumlahPasien::all();

        $provinsi = DB::table('master_kabupaten')
            ->select('nama_prop', 'kode_prop')
            ->distinct()
            ->get();
        $kabupaten = DB::table('master_kabupaten')->select('nama_kab', 'kode_kab')->where('kode_prop', '=', $pasien->lokasi_propinsi)->get();
        return view('admin.edit', compact(['pasien', 'provinsi', 'kabupaten', 'results']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DataPasien  $dataPasien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataPasien $dataPasien)
    {
        // dd($request);
        if ($request->file('foto') != null) {
            $file = $request->file('foto');
            $imgFolder = "images";
            $imgFile = $dataPasien->id . "." . $request->get('extUrl');
            $file->move($imgFolder, $imgFile);
            $dataPasien->ext = $request->get('extUrl');
        }
        if ($request->get('nama') != null) {
            $dataPasien->nama = $request->get('nama');
        }
        if ($request->get('noKtp') != null) {
            $dataPasien->no_ktp = $request->get('noKtp');
        }
        if ($request->get('alamat') != null) {
            $dataPasien->alamat = $request->get('alamat');
        }
        if ($request->get('provinsi') != null) {
            $dataPasien->lokasi_propinsi = $request->get('provinsi');
        }
        if ($request->get('kabupaten') != null) {
            $dataPasien->lokasi_kabkot = $request->get('kabupaten');
        }
        if ($request->get('keluhan') != null) {
            $dataPasien->keluhan = $request->get('keluhan');
        }
        if ($request->get('riwayat') != null) {
            $dataPasien->riwayat_perjalanan = $request->get('riwayat');
        }
        if ($request->get('jenis') != null) {
            $dataPasien->jenis = $request->get('jenis');
        }
        $dataPasien->save();
        return redirect('dataPasien')->with('status', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DataPasien  $dataPasien
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataPasien $dataPasien)
    {
        try {
            // dd($dataPasien);
            if($dataPasien->jenis == "Suspect"){
                $jumlahPasien = JumlahPasien::where('kode_kabupaten',$dataPasien->lokasi_kabkot)->get();
                $jumlahPasien[0]->suspect = $jumlahPasien[0]->suspect-1;
                $jumlahPasien[0]->save();

            }
            else if($dataPasien->jenis == "Penderita"){
                $jumlahPasien = JumlahPasien::where('kode_kabupaten',$dataPasien->lokasi_kabkot)->get();
                $jumlahPasien[0]->penderita = $jumlahPasien[0]->penderita - 1;
                $jumlahPasien[0]->save();
            }
            $dataPasien->delete();
            return redirect('dataPasien')->with('status', 'Data Berhasil dihapus');
        } catch (\PDOException $e) {
            return redirect('dataPasien')->with('error', 'Data gagal dihapus \n '.$e);
        }
    }
}
