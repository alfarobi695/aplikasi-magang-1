<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('mahasiswa')->user()->nik;

        $cek = Presensi::where('tgl_presensi', $hariini)
            ->where('nik', $nik)->count();

        return view('presensi.create', [
            'cek' => $cek
        ]);
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('mahasiswa')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        // LOKASI KANTOR (TITIK RADIUS)
        $latitudeKantor = -7.92990699602328;
        $longitudeKantor = 112.64928605383722;

        // $latitudeKantor = -6.914289335466438;
        // $longitudeKantor = 107.61169550914718;

        // $latitudeKantor = -6.9172307420433965;
        // $longitudeKantor = 107.61005901027413;

        // LOKASI USER
        $lokasi = $request->lokasi;

        // dd($lokasi);

        $lokasiUser = explode(',', $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];
        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);

        $cek = Presensi::where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)->count();

        if ($cek > 0) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }
        // CONVERT IMAGE FROM BASE64 TO READABLE IMAGE
        $image = $request->image;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        // SETTING PATH AND FILE
        $folderPath = 'public/upload/absensi/';
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;



        if ($radius > 55) {
            echo "error|Maaf anda berada diluar radius, jarak anda " . $radius . " meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                // Pulang
                $kegiatan = $request->kegiatan;
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                    'kegiatan' => $kegiatan
                ];
                //$simpanData = Presensi::where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);menggunakan update at dan created at
                $simpanData = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                $clausa = 'out';
            } else {
                // Masuk
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                ];
                //$simpanData = Presensi::create($data); menggunakan update at dan created at
                $simpanData = DB::table('presensi')->insert($data);
                $clausa = 'in';
            }

            
            if ($simpanData) {
                if ($clausa == 'out') {
                    echo "success|Terimakasih, hati-hati dijalan|out";
                } elseif ($clausa == 'in') {
                    echo "success|Terimakasih, selamat bekerja|in";
                }
                Storage::put($file, $image_base64);
            } else {
                if ($clausa == 'out') {
                    echo "error|Maaf Gagal Absen, Hubungai Tim IT|out";
                } elseif ($clausa == 'in') {
                    echo "error|Maaf Gagal Absen, Hubungai Tim IT|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('mahasiswa')->user()->nik;
        $mahasiswa = Mahasiswa::where('nik', $nik)->first();

        return view('presensi.editprofile', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('mahasiswa')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        $dt_mahasiswa = Mahasiswa::where('nik', $nik)->first();

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $dt_mahasiswa->foto;
        }

        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto,
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto,
            ];
        }

        $update = Mahasiswa::where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = 'public/upload/mahasiswa';
                $request->file('foto')->storeAs($folderPath, $foto);
            }

            return Redirect::back()->with(['success' => 'Data berhasil di update']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal di update']);
        }
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.histori', [
            'namabulan' => $namabulan
        ]);
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('mahasiswa')->user()->nik;

        // echo $bulan . "" . $tahun;

        $histori = Presensi::whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', [
            'histori' => $histori
        ]);
    }

    public function izin()
    {
        $nik = Auth::guard('mahasiswa')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', [
            'dataizin' => $dataizin
        ]);
    }

    public function izinadd()
    {
        return view('presensi.izinadd');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('mahasiswa')->user()->nik;
        $status = $request->status;
        $tgl_izin = $request->tgl_izin;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'status' => $status,
            'tgl_izin' => $tgl_izin,
            'keterangan' => $keterangan,
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = Presensi::with('mahasiswa.department')->where('tgl_presensi', $tanggal)->get();

        return view('presensi.getpresensi', [
            'presensi' => $presensi
        ]);
    }

    public function showmaps(Request $request)
    {
        $id = $request->id;
        $presensi = Presensi::with('mahasiswa')->where('id', $id)->first();

        return view('presensi.showmaps', [
            'presensi' => $presensi
        ]);
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('mahasiswa')->user()->nik;

        $cek = Pengajuan::where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();

        return $cek;
    }

    public function laporan()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $mahasiswa = DB::table('mahasiswa')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'mahasiswa'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $mahasiswa = DB::table('mahasiswa')->where('nik', $nik)
        ->join('department', 'mahasiswa.kode_dept', '=', 'department.kode_dept')
        ->first();

        $presensi = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="'. $bulan .'"')
            ->whereRaw('YEAR(tgl_presensi)="'. $tahun .'"')
            ->orderBy('tgl_presensi')
            ->get();

        if(isset($_POST['exportexcel']))
        {
            $time = date("d-M-Y H:i:s");
            header("Content-Type: application/vnd-ms-excel");

            header("Content-Disposition: attachment; filename=Laporan Presensi Mahasiswa $time.xls");

            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namabulan', 'mahasiswa', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'mahasiswa', 'presensi'));
    }
}
