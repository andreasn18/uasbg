<?php

namespace App\Http\Controllers;

use App\JumlahPasien;
use App\MasterKabupaten;
use Illuminate\Http\Request;

class JumlahPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = JumlahPasien::all();
        // dd($results);
        return view('welcome', compact('results'));
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
     * @param  \App\JumlahPasien  $jumlahPasien
     * @return \Illuminate\Http\Response
     */
    public function show(JumlahPasien $jumlahPasien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JumlahPasien  $jumlahPasien
     * @return \Illuminate\Http\Response
     */
    public function edit(JumlahPasien $jumlahPasien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JumlahPasien  $jumlahPasien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JumlahPasien $jumlahPasien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JumlahPasien  $jumlahPasien
     * @return \Illuminate\Http\Response
     */
    public function destroy(JumlahPasien $jumlahPasien)
    {
        //
    }
}
