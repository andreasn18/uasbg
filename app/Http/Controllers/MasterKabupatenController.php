<?php

namespace App\Http\Controllers;

use App\JumlahPasien;
use App\MasterKabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterKabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
     * @param  \App\MasterKabupaten  $masterKabupaten
     * @return \Illuminate\Http\Response
     */
    public function show(MasterKabupaten $masterKabupaten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MasterKabupaten  $masterKabupaten
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterKabupaten $masterKabupaten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MasterKabupaten  $masterKabupaten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterKabupaten $masterKabupaten)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MasterKabupaten  $masterKabupaten
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterKabupaten $masterKabupaten)
    {
        //
    }
}
