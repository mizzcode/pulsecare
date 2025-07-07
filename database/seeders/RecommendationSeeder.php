<?php

namespace Database\Seeders;

use App\Models\Recommendation;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recommendations = [
            ['level' => 'normal', 'title' => 'Jaga Pola Hidup Sehat', 'description' => 'Pertahankan gaya hidup sehat dengan pola makan seimbang dan olahraga teratur.'],
            ['level' => 'normal', 'title' => 'Kelola Stres Harian', 'description' => 'Lanjutkan teknik manajemen stres yang efektif seperti mindfulness atau hobi.'],
            ['level' => 'normal', 'title' => 'Jaga Hubungan Sosial', 'description' => 'Tetap terhubung dengan teman dan keluarga untuk menjaga kesehatan emosional.'],
            ['level' => 'normal', 'title' => 'Lakukan Refleksi Diri', 'description' => 'Luangkan waktu secara berkala untuk merefleksikan perasaan dan pencapaian Anda.'],

            ['level' => 'ringan', 'title' => 'Aktivitas Fisik', 'description' => 'Lakukan aktivitas fisik ringan seperti jalan kaki atau peregangan'],
            ['level' => 'ringan', 'title' => 'Tidur Teratur', 'description' => 'Tidur yang cukup dan teratur'],
            ['level' => 'ringan', 'title' => 'Waktu Hobi', 'description' => 'Luangkan waktu untuk hobi yang menyenangkan'],
            ['level' => 'ringan', 'title' => 'Minum Air Putih', 'description' => 'Pastikan hidrasi dengan minum air putih secara rutin'],

            ['level' => 'sedang', 'title' => 'Meditasi', 'description' => 'Latihan pernapasan dalam atau meditasi 10 menit per hari'],
            ['level' => 'sedang', 'title' => 'Batasi Kafein', 'description' => 'Batasi konsumsi kafein dan gula'],
            ['level' => 'sedang', 'title' => 'Berbicara', 'description' => 'Bicarakan dengan teman atau keluarga tentang apa yang Anda rasakan'],
            ['level' => 'sedang', 'title' => 'Catat Pikiran', 'description' => 'Tuliskan pikiran Anda dalam jurnal untuk refleksi harian'],

            ['level' => 'berat', 'title' => 'Konsultasi Profesional', 'description' => 'Pertimbangkan untuk berkonsultasi dengan profesional kesehatan mental'],
            ['level' => 'berat', 'title' => 'Jadwal Istirahat', 'description' => 'Jadwalkan waktu istirahat secara rutin dan hindari stresor berlebih'],
            ['level' => 'berat', 'title' => 'Aktivitas Relaksasi', 'description' => 'Lakukan aktivitas relaksasi seperti yoga atau journaling'],
            ['level' => 'berat', 'title' => 'Hindari Isolasi', 'description' => 'Tetap terhubung dengan orang terdekat untuk dukungan emosional'],

            ['level' => 'sangat berat', 'title' => 'Hubungi Profesional Segera', 'description' => 'Segera hubungi psikolog atau dokter untuk penanganan intensif'],
            ['level' => 'sangat berat', 'title' => 'Gunakan Hotline Darurat', 'description' => 'Hubungi layanan darurat kesehatan mental Kementerian Kesehatan RI. Untuk informasi lebih lanjut dapat menghubungi nomor hotline Halo Kemenkes melalui nomor hotline 1500-567, SMS 081281562620 dan alamat email kontak@kemkes.go.id'],
            ['level' => 'sangat berat', 'title' => 'Istirahat Total dan Dukungan', 'description' => 'Berhenti dari aktivitas berat, cari dukungan keluarga, dan pertimbangkan rawat inap jika diperlukan'],
            ['level' => 'sangat berat', 'title' => 'Pantau Keamanan', 'description' => 'Pantau diri sendiri dan minta bantuan jika ada pikiran berbahaya'],
        ];

        foreach ($recommendations as $rec) {
            Recommendation::create($rec);
        }
    }
}