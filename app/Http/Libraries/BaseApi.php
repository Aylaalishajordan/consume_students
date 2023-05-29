<?php
//perbedaan helpres dan libraries
//helpres : bikin APi (service yang isinya dipakai dimethod dan controller, satu function saja)
//libraries : pake API (banyak method)
namespace App\Http\Libraries;
//mengatur posisi file
use Illuminate\Support\Facades\Http;

class BaseApi
{
    //variable yang cuma bisa diakses diclass ini dan turunannya
    protected $baseUrl;
    //constractor : menyiapkan isi data, dijalankan otomatis tanpa dipanggil
    public function __construct()
    {
        //variable yang diatas diisi nilainya dari isian file .env bagian API_HOSt
        //var ini diisi otomatis ketika file/class BaseApi dipanggil dicontroller
        $this->baseUrl = "http://127.0.0.1:222";
    }
    private function client()
    {
        //koneksikan ip dari var $baseUrl kedepedency http
        //menggunakan depedency Http karena project API nya berbasis web (protocol Http)
        return Http::baseUrl($this->baseUrl);
    }
    public function index(String $endpoint, Array $data = [])
    {
        //manggil ke function client yang diatas, terus manggil path yang di $endpoint yang dikirim controlernya, kalau ada dari yang mau dicari (params dipostman)daimbil dari parameter2 $data
        return $this->client()->get($endpoint, $data);
    }
    public function store(String $endpoint, Array $data = [])
    {
        //pake post() karena buat route tambah data diproject baseapi nya pakai ::post
        return $this->client()->post($endpoint, $data);
    }
    public function edit(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);
    }

    public function update(String $endpoint, Array $data = [])
    {
        return $this->client()->patch($endpoint, $data);
    }

    public function delete(String $endpoint, Array $data = [])
    {
        return $this->client()->delete($endpoint, $data);

    }
    
    public function trash(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);

    }

    public function restore(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);

    }

    public function permanent(String $endpoint, Array $data = [])
    {
        return $this->client()->get($endpoint, $data);

    }
}
?>