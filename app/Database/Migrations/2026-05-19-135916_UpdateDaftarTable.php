<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateDaftarTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // 1. Update data typo jika ada
        $db->query("UPDATE daftar SET status_pembayaran = 'Menunggu' WHERE status_pembayaran = 'Menunggul'");
        
        // 2. Modify enum column
        $db->query("ALTER TABLE daftar MODIFY status_pembayaran ENUM('Menunggu', 'Lunas') DEFAULT 'Menunggu'");
        
        // 3. Add new columns
        $this->forge->addColumn('daftar', [
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tanggal_konfirmasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_akun_konfirmasi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
        ]);
        
        // Coba tambahkan FK jika id_akun support (biasanya unsigned)
        // Kita eksekusi query raw agar lebih aman jika tipe datanya sedikit berbeda
        try {
            $db->query("ALTER TABLE daftar ADD CONSTRAINT fk_daftar_akun_konfirmasi FOREIGN KEY (id_akun_konfirmasi) REFERENCES akun(id_akun) ON DELETE SET NULL ON UPDATE CASCADE");
        } catch (\Exception $e) {
            // Abaikan jika tipe data akun berbeda
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        try {
            $db->query("ALTER TABLE daftar DROP FOREIGN KEY fk_daftar_akun_konfirmasi");
        } catch (\Exception $e) {}
        
        $this->forge->dropColumn('daftar', 'bukti_pembayaran');
        $this->forge->dropColumn('daftar', 'tanggal_konfirmasi');
        $this->forge->dropColumn('daftar', 'id_akun_konfirmasi');
    }
}
