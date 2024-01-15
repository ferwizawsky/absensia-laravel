<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsensiResource;
use App\Http\Resources\AbsensiStudentResource;
use App\Http\Resources\JadwalUjianResource;
use App\Http\Resources\KelasResource;
use App\Http\Resources\StudentViewResource;
use App\Models\Absensi;
use App\Models\JadwalUjian;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groupedData = Absensi::where("user_id", $request->user()?->id ?? 3)->selectRaw('*, COUNT(*) as total')
            ->groupBy('kelas_id', 'user_id')
            ->get();
        $kelas = Kelas::find($request->user_id ?? 3);
        // return $groupedData;
        return response()->json([
            // "kelas" => new KelasResource($kelas),
            // "kelas" => $kelas,
            "absensi" => AbsensiStudentResource::collection($groupedData)
        ]);
    }

    public function jadwal(Request $request)
    {
        $today = Carbon::now()->toDateString();

        // Query the model for records where the date is today or in the future
        // $futureRecords = YourModel::whereDate('your_date_column', '>=', $today)->get();

        $results = JadwalUjian::whereDate('day', '>=', $today);
        $results = $results->where('user_id', $request->user()?->user_id);
        $results = $results->get();
        return  JadwalUjianResource::collection($results);
    }
}
