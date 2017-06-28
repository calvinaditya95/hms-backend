<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatTindakan;

class ObatTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTindakan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obat_tindakan = new ObatTindakan;
        $obat_tindakan->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_tindakan->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_tindakan->waktu_keluar = $request->input('waktu_keluar');
        $obat_tindakan->jumlah = $request->input('jumlah');       
        $obat_tindakan->keterangan = $request->input('keterangan');
        $obat_tindakan->id_transaksi = $request->input('id_transaksi');
        $obat_tindakan->id_tindakan = $request->input('id_tindakan');        
        $obat_tindakan->save();
        return response ($obat_tindakan, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatTindakan::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obat_tindakan = ObatTindakan::findOrFail($id);
        $obat_tindakan->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_tindakan->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_tindakan->waktu_keluar = $request->input('waktu_keluar');
        $obat_tindakan->jumlah = $request->input('jumlah');       
        $obat_tindakan->keterangan = $request->input('keterangan');
        $obat_tindakan->id_transaksi = $request->input('id_transaksi');
        $obat_tindakan->id_tindakan = $request->input('id_tindakan');       
        $obat_tindakan->save();
        return response ($obat_tindakan, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obat_tindakan = ObatTindakan::find($id);
        $obat_tindakan->delete();
        return response ($id.' deleted', 200);
    }
}
