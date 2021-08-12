<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
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

    public function saveJawaban(Request $request)
    {
        if($request->type == 'remedial')
        {
            $remed = Jawaban::where('type', $request->type)->where('user_id', $request->user_id);
            $remed->delete();
        }
        foreach ($request->list_jawaban as $jwb)
        {
            $jawaban = new Jawaban;
            $jawaban->level = $request->level;
            $jawaban->soal_id = $jwb['id'];
            $jawaban->is_true = $jwb['is_true'];
            $jawaban->type = $request->type;
            $jawaban->user_id = $request->user_id;
            $jawaban->save();
        }
        return response()->json(['status' => 'OK'], 200);

    }

    public function cekJawaban(Request $request)
    {
        $jawaban = Jawaban::where('level', $request->level)->where('user_id', $request->user_id)
            ->where('type', $request->type)->get();

        $total = 0;
        if(count($jawaban) == 0){
            return response()->json(['level' => 'locked']);
        }
        foreach ($jawaban as $jwb)
        {
            if($jwb->is_true)
            {
                $total += 1;
            }
        }
        if($total < 7){
            return response()->json(['level' => 'remedial', 'nilai' => $total]);
        }
            return response()->json(['level' => 'unlocked']);

    }
}
