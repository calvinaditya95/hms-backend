<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AntrianFrontOffice;
use App\Poliklinik;
use Carbon\Carbon;
use SMS;

class AntrianSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SMS::send('Your SMS Message', null, function($sms) {
            $sms->to('6281317370628');
        });
        return AntrianFrontOffice::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $antrian_front_office = new AntrianFrontOffice;
        $antrian_front_office->nama_layanan_poli = $request->input('nama_layanan_poli');
        $antrian_front_office->nama_layanan_lab = $request->input('nama_layanan_lab');
        $antrian_front_office->jenis = $request->input('jenis');
        $antrian_front_office->kategori_antrian = $request->input('kategori_antrian');
        $antrian_front_office->kesempatan = $request->input('kesempatan');
        $antrian_front_office->save();

        if ($request->input('nama_layanan_poli')) {
            $poli = Poliklinik::findOrFail($request->input('nama_layanan_poli'));
            if ($poli && $poli->sisa_pelayanan <= 0) {
                AntrianFrontOffice::destroy($antrian_front_office->nama_layanan_poli, $antrian_front_office->no_antrian);
                return response()->json([
                    'error' => 'Pembuatan Antrian Gagal'
                ], 500);
            }
        }

        return response($antrian_front_office, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kategori_antrian
     * @return \Illuminate\Http\Response
     */
    public function show($kategori_antrian)
    {
        return AntrianFrontOffice::where('kategori_antrian', '=', $kategori_antrian)
          ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function update($nama_layanan, $no_antrian)
    {
        $antrian_front_office = AntrianFrontOffice::
            where([['no_antrian', '=', $no_antrian], ['nama_layanan_poli', '=', $nama_layanan]])
            ->orWhere([['no_antrian', '=', $no_antrian], ['nama_layanan_lab', '=', $nama_layanan]])
            ->first();
        $antrian_front_office->waktu_perubahan_antrian = Carbon::now();
        $antrian_front_office->kesempatan = $antrian_front_office->kesempatan - 1;
        $antrian_front_office->save();
        if ($antrian_front_office->kesempatan <= 0) {
            $antrian_front_office->delete();
        }
		return response($antrian_front_office, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama_layanan, $no_antrian)
    {
        $deletedRows = AntrianFrontOffice::
            where([['no_antrian', '=', $no_antrian], ['nama_layanan_poli', '=', $nama_layanan]])
            ->orWhere([['no_antrian', '=', $no_antrian], ['nama_layanan_lab', '=', $nama_layanan]])
              ->first()
              ->delete();
        return response('', 204);
    }
}