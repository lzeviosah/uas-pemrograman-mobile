<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PaymentController extends ResourceController
{
    protected $modelName = 'App\Models\Payment';
    protected $format    ='json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
        $data = [
            'message' => 'success',
            'data_payment' => $this->model->orderBy('payment.kode','DESC')->getPaymentWithSiswa()
        ];

        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($nis_siswa = null)
    {
        //
        $data = $this->model->orderBy('payment.kode','DESC')->getPaymentWithSiswaByNis($nis_siswa);

        if (!$data) {
            return $this->failNotFound('Data not found');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        // Post Data
        $siswaModel = new \App\Models\Siswa();

        $nis_siswa = $this->request->getVar('nis_siswa');
        $nominal = $this->request->getVar('nominal');
        $berita = $this->request->getVar('berita');

        // Cek apakah siswa dengan NIS tersebut ada
        $siswa = $siswaModel->find($nis_siswa);

        if (!$siswa) {
            return $this->fail('Siswa not found for NIS: ' . $nis_siswa, 404);
        }

        // Data payment yang akan disimpan
        $data = [
            'nis_siswa' => $nis_siswa,
            'nominal' => $nominal,
            'berita' => $berita
        ];

        // Simpan data payment
        $this->model->insert($data);

        // Ambil data payment yang baru saja disimpan beserta nama siswa
        $newPayment = $this->model->select('payment.*, siswa.nama_siswa')
                                 ->join('siswa', 'siswa.nis = payment.nis_siswa')
                                 ->where('payment.kode', $this->model->getInsertID())
                                 ->first();

        return $this->respondCreated([
            'message' => 'payment created successfully',
            'data' => $newPayment
        ]);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($kode = null)
    {
        //
        
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($kode = null)
    {
        //
        $rules = $this->validate([
            'nis_siswa'  => 'required',
            'nominal'    => 'required',
            'berita'     => 'required',
        ]);

        if(!$rules)
        {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }


        // Update data payment
        $this->model->update($kode,[
            'nis_siswa' => esc($this->request->getVar('nis_siswa')),
            'nominal'   => esc($this->request->getVar('nominal')),
            'berita'    => esc($this->request->getVar('berita')),
        ]);

        // Ambil data payment yang baru saja diupdate beserta nama siswa
        $updatedPayment = $this->model->select('payment.*, siswa.nama_siswa')
                                    ->join('siswa', 'siswa.nis = payment.nis_siswa')
                                    ->where('payment.kode', $kode)
                                    ->first();

        return $this->respondUpdated([
            'message' => 'payment updated successfully',
            'data' => $updatedPayment
        ]);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($kode = null)
    {
        // Cek keberadaan data pembayaran
        $payment = $this->model->find($kode);
        if (!$payment) {
            return $this->failNotFound('Payment not found');
        }

        // Lakukan proses penghapusan data
        $this->model->delete($kode);

        return $this->respondDeleted([
            'message' => 'Pembayaran deleted successfully',
            'data' => $payment
        ]);
    }
}
