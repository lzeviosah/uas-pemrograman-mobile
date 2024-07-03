<?php

namespace App\Models;

use CodeIgniter\Model;

class Payment extends Model
{
    protected $table            = 'payment';
    protected $primaryKey       = 'kode';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nis_siswa','nominal','berita'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Function to get payment with related siswa data
    public function getPaymentWithSiswa()
    {
        return $this->select('payment.*, siswa.nama_siswa')
                    ->join('siswa', 'siswa.nis = payment.nis_siswa')
                    ->findAll();
    }

    public function getPaymentWithSiswaByNis($nis_siswa)
    {
        return $this->select('payment.*, siswa.nama_siswa')
                    ->join('siswa', 'siswa.nis = payment.nis_siswa')
                    ->where('payment.nis_siswa', $nis_siswa)
                    ->findAll();
    }
    
    public function getPaymentWithSiswaByTanggal($tanggal_payment)
    {
    return $this->select('payment.kode, payment.tanggal_payment, payment.nis_siswa,
                          siswa.nama_siswa, payment.nominal, payment.berita')
                ->join('siswa', 'siswa.nis = payment.nis_siswa')
                ->where('DATE(payment.tanggal_payment)', $tanggal_payment)
                ->orderBy('payment.kode', 'DESC')
                ->findAll();
    }
}
