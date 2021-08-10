<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getSoal(Request $request)
    {
        $soal = Soal::where('level_id', $request->level)->get();
        return response()->json($soal, 200);
    }

    public function index()
    {
        return response()->json("OK",200);
    }

    public function soal()
    {
        return view('soal');
    }

    public function simpanSoal(Request $request)
    {
        $soal = new Soal;
        $soal->level_id = $request->level;
        $soal->soal_number = $request->nomor;
        $soal->soal_text = $request->soal;
        $jawaban = [
            'A' => $request->jawaban_a,
            'B' => $request->jawaban_b,
            'C' => $request->jawaban_c,
            'D' => $request->jawaban_d];
        $soal->list_jawaban = json_encode($jawaban);
        $soal->kunci_jawaban = $request->kunci_jawaban;
        $soal->penjelasan = $request->penjelasan;
        $soal->save();

        return redirect()->back();
    }
}
