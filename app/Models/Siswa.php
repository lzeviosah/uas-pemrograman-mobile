<?php

namespace App\Models;

use CodeIgniter\Model;

class Siswa extends Model
{
    protected $table            = 'siswa';
    protected $primaryKey       = 'nis';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Function to get payment with related siswa data
    public function getSiswaWithPayment()
    {
        return $this->select('payment.kode, siswa.*, payment.tanggal_payment, payment.nominal, payment.berita')
                    ->join('payment', 'payment.nis_siswa = siswa.nis')
                    ->findAll();
    }
    public function getSiswaWithPaymentByNis($nis)
    {
        return $this->select('payment.kode, siswa.*, payment.tanggal_payment, payment.nominal, payment.berita')
                    ->join('payment', 'payment.nis_siswa = siswa.nis')
                    ->where('siswa.nis', $nis)
                    ->findAll();
    }
}
