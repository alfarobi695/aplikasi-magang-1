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
        $nim = Auth::guard('mahasiswa')->user()->nim;

        $cek = Presensi::where('tgl_presensi', $hariini)
            ->where('nim', $nim)->count();

        return view('presensi.create', [
            'cek' => $cek
        ]);
    }

    public function store(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        // LOKASI KANTOR (TITIK RADIUS) -7.929881702091076, 112.64923962210915
        $latitudeKantor = -7.929854689248487;
        $longitudeKantor = 112.64923962210915;

        // $latitudeKantor = -6.914289335466438;
        // $longitudeKantor = 107.61169550914718;

        // $latitudeKantor = -6.9172307420433965;
        // -7.929854689248487, 112.64917406825107
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
            ->where('nim', $nim)->count();

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
        $formatName = $nim . "-" . $tgl_presensi . "-" . $ket;
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
                //$simpanData = Presensi::where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->update($data_pulang);menggunakan update at dan created at
                $simpanData = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nim', $nim)->update($data_pulang);
                $clausa = 'out';
            } else {
                // Masuk
                $data = [
                    'nim' => $nim,
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
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        return view('presensi.editprofile', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function updateprofile(Request $request)
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);

        $dt_mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if ($request->hasFile('foto')) {
            $foto = $nim . "." . $request->file('foto')->getClientOriginalExtension();
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

        $update = Mahasiswa::where('nim', $nim)->update($data);
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
        $nim = Auth::guard('mahasiswa')->user()->nim;

        // echo $bulan . "" . $tahun;

        $histori = Presensi::whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nim', $nim)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', [
            'histori' => $histori
        ]);
    }

    public function izin()
    {
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $dataizin = DB::table('pengajuan_izin')->where('nim', $nim)->get();
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
        $nim = Auth::guard('mahasiswa')->user()->nim;
        $status = $request->status;
        $tgl_izin = $request->tgl_izin;
        $keterangan = $request->keterangan;

        $data = [
            'nim' => $nim,
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
        $nim = Auth::guard('mahasiswa')->user()->nim;

        $cek = Pengajuan::where('nim', $nim)->where('tgl_izin', $tgl_izin)->count();

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
        $nim = $request->nim;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Ambil data mahasiswa
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)
            ->join('department', 'mahasiswa.kode_dept', '=', 'department.kode_dept')
            ->first();

        // Ambil data presensi untuk bulan dan tahun yang dipilih
        $presensi = DB::table('presensi')
            ->where('nim', $nim)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->get();

        // Ambil data pengajuan izin dan sakit yang disetujui
        $izin_sakit = DB::table('pengajuan_izin')
            ->where('nim', $nim)
            ->whereRaw('MONTH(tgl_izin) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_izin) = ?', [$tahun])
            ->where('status_approved', '1')
            ->get();

        // Tentukan jumlah hari dalam bulan tersebut
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Buat array untuk menyimpan semua tanggal kerja (Senin-Jumat)
        $data_laporan = [];
        for ($day = 1; $day <= $jumlah_hari; $day++) {
            // Tentukan nama hari (1 = Senin, 7 = Minggu)
            $tanggal = sprintf("%04d-%02d-%02d", $tahun, $bulan, $day);
            $nama_hari = date('N', strtotime($tanggal));

            // Hanya cek Senin hingga Jumat (nama_hari 1-5)
            if ($nama_hari <= 5) {
                // Cari presensi untuk tanggal tersebut
                $prs = $presensi->firstWhere('tgl_presensi', $tanggal);



                // Jika presensi ditemukan, tambahkan ke data laporan
                if ($prs) {
                    // Menghitung jam keterlambatan
                    $jam_in = strtotime($prs->jam_in);
                    $waktu_masuk_normal = strtotime('07:30'); // Waktu masuk yang dianggap normal
                    $terlambat = max(0, ($jam_in - $waktu_masuk_normal) / 3600); // Keterlambatan dalam jam

                    // Menghitung total jam kerja
                    if ($prs->jam_out) {

                        $jam_out = strtotime(datetime: $prs->jam_out);
                        $total_jam_kerja = round(num: ($jam_out - $jam_in) / 3600, precision: 2); // Total jam kerja
                    } else {
                        $total_jam_kerja = 'Belum Absen Pulang';
                    }

                    $data_laporan[] = [
                        'tanggal' => $tanggal,
                        'jam_in' => $prs->jam_in,
                        'jam_out' => $prs->jam_out,
                        'status' => 'Hadir',
                        'terlambat' => $terlambat > 0 ? 'terlambat ' . round($terlambat, 2) . ' jam' : 'tepat waktu',
                        'total_jam_kerja' => $total_jam_kerja .' jam',
                        'foto_in' => $prs->foto_in,
                        'keterangan' => $prs->kegiatan,
                        'foto_out' => $prs->foto_out
                    ];


                } else {
                    // Jika tidak ada presensi, cek izin/sakit
                    $izin = $izin_sakit->firstWhere('tgl_izin', $tanggal);

                    if ($izin) {
                        $data_laporan[] = [
                            'tanggal' => $tanggal,
                            'jam_in' => null,
                            'jam_out' => null,
                            'status' => $izin->status == 'i' ? 'Izin' : 'Sakit',
                            'terlambat' => null,
                            'total_jam_kerja' => '-',
                            'keterangan' => $izin->keterangan,
                            'foto_in' => null,
                            'foto_out' => null
                        ];
                    } else {
                        // Jika tidak ada presensi dan tidak ada izin/sakit, tandai sebagai alpha
                        $data_laporan[] = [
                            'tanggal' => $tanggal,
                            'jam_in' => null,
                            'jam_out' => null,
                            'status' => 'Alpha',
                            'terlambat' => null,
                            'total_jam_kerja' => '-',
                            'keterangan' => '-',
                            'foto_in' => null,
                            'foto_out' => null
                        ];
                    }
                }
            }
        }


        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'mahasiswa', 'data_laporan'));
    }


    public function rekap()
    {
        $mahasiswa = DB::table('mahasiswa')->orderBy('nama_lengkap')->get();
        return view('presensi.rekap', compact('mahasiswa'));
    }

    public function cetakrekap(Request $request)
    {
        $nim = $request->nim;
        $tahun = $request->tahun;

        // Mengambil data mahasiswa berdasarkan NIM
        $mahasiswa = DB::table('mahasiswa')
            ->where('nim', $nim)
            ->join('department', 'mahasiswa.kode_dept', '=', 'department.kode_dept')
            ->first();

        // Mengambil data presensi berdasarkan NIM dan tahun
        $presensi = DB::table('presensi')
            ->where('nim', $nim)
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun]) // Memfilter berdasarkan tahun saja
            ->orderBy('tgl_presensi')
            ->get();

        // Jika melakukan eksport ke Excel
        if ($request->has('exportexcel')) // Menggunakan $request untuk cek inputan
        {
            $time = date("d-M-Y H:i:s");
            header("Content-Type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan_Presensi_Mahasiswa_$time.xls");

            return view('presensi.cetaklaporanexcel', compact('tahun', 'mahasiswa', 'presensi')); // 'bulan' dan 'namabulan' dihapus
        }

        // Mengembalikan view cetaklaporan
        return view('presensi.cetakrekap', compact('tahun', 'mahasiswa', 'presensi')); // 'bulan' dan 'namabulan' dihapus
    }


}
