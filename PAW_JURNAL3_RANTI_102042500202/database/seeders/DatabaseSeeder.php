<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\MataKuliah;
use App\Models\Material;
use App\Models\Assignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Pengguna LMS (1 Dosen & 1 Mahasiswa)

        // TODO 1: Buat akun awal untuk Dosen.
        // Hint:
        // - Gunakan email sebagai identitas akun.
        // - Lengkapi nama, password yang di-hash, role Dosen, dan nomor induk.

        // Akun dosen untuk pengujian
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@celoe.test'],
            [
                'name' => 'Dewi Marini Umi Atmaja, S.Kom., M.Kom.',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'nomor_induk' => 'DSN001',
            ]
        );


        // TODO 2: Buat akun awal untuk Mahasiswa.
        // Hint:
        // - Gunakan email sebagai identitas akun.
        // - Lengkapi nama, password yang di-hash, role Mahasiswa, dan nomor induk.

        // Akun mahasiswa untuk pengujian
        $mahasiswa = User::updateOrCreate(
            ['email' => 'mahasiswa@celoe.test'],
            [
                'name' => 'Ahmad Raihan Arifinza',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nomor_induk' => '102042500202',
            ]
        );


        // TODO 3: Buat data mata kuliah untuk Dosen.
        // Hint:
        // - Gunakan model MataKuliah.
        // - Isi kode_mk, nama_mk, deskripsi, sks, dan semester.
        // - Hubungkan mata kuliah dengan dosen melalui dosen_id.

        $course = MataKuliah::updateOrCreate(
            ['kode_mk' => 'PAW'],
            [
                'nama_mk' => 'Pengembangan Aplikasi Website',
                'deskripsi' => 'Pembelajaran pengembangan aplikasi website menggunakan Laravel.',
                'sks' => 3,
                'semester' => 'Ganjil 2026/2027',
                'dosen_id' => $dosen->id,
            ]
        );


        // TODO 4: Daftarkan Mahasiswa ke mata kuliah.
        // Hint:
        // - Gunakan relasi students() dari model MataKuliah.
        // - Hubungkan mahasiswa dengan mata kuliah.
        // - Atur status pendaftaran menjadi approved.

        $course->students()->syncWithoutDetaching([
            $mahasiswa->id => [
                'status' => 'approved',
            ],
        ]);


        // TODO 5: Buat data materi perkuliahan.
        // Hint:
        // - Gunakan model Material.
        // - Hubungkan materi dengan mata kuliah melalui course_id.
        // - Isi judul, konten, minggu_ke, dan urutan.

        Material::updateOrCreate(
            [
                'course_id' => $course->id,
                'judul' => 'Materi Pertemuan 01',
            ],
            [
                'konten' => 'Pengenalan Pengembangan Aplikasi Website menggunakan Laravel.',
                'minggu_ke' => 1,
                'urutan' => 1,
            ]
        );


        // TODO 6: Buat data tugas perkuliahan.
        // Hint:
        // - Gunakan model Assignment.
        // - Hubungkan tugas dengan mata kuliah melalui course_id.
        // - Isi judul, deskripsi, dan deadline tugas.

        Assignment::updateOrCreate(
            [
                'course_id' => $course->id,
                'judul' => 'Tugas 01 - Bikin Sistem Kasir pake Laravel',
            ],
            [
                'deskripsi' => 'Buatlah aplikasi sistem kasir sederhana menggunakan Laravel.',
                'deadline' => now()->addDays(7),
            ]
        );
    }
}
