<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Libraries\BaseApi;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //mengambil data dari input search
        $search = $request->search;
        //memanggil libraries baseapi methodnya index dengan mengirim parameteri berupa path data apinya, parameter2 data untuk mengisi search_nama apinya
        //new karena bentukannya class
        $data = (new BaseApi)->index('/api/students', ['search_nama' => $search]);
        //ambil respon jsonnya
        $students = $data->json();
        // dd($students);
        //kirim hasil pengambilan data keblade index
        //ambil property data dari response json
        return view('index')->with(['students' => $students['data']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];
        $proses = (new BaseApi)->store('/api/students/tambah-data', $data);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil menambahkan data baru ke students API');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //proses ambil data api ke route best api /studentd/{id}
        $data = (new BaseApi)->edit('/api/students/'.$id);
        if ($data->failed()) {
            //kalau gagal proses $data diatas ambil deskripsi err dari json property data
            $errors = $data->json('data');
            //balikin kehalaman awal sama errornya
            return redirect()->back()->with(['errorss' => $errors]);
        }else {
            //kalau berhasil ambil data jsonnya
            $student = $data->json(['data']);
            //alihin keblade edit dengan mengirim data $student diaats agar bisa digunakan blade
            return view('edit')->with(['student' => $student]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Request $request ngambil data darisemua input
    public function update(Request $request, $id)
    {
        //data yang akan dikirim dibagian REST APINYA
        $payload = [
            'nama' => $request->nama,
            'nis' => $request->nis,
            'rombel' => $request->rombel,
            'rayon' => $request->rayon,
        ];

        //panggil method update dari baseapi,kirim endpoint (route update dari rest apinya dan data $payload diatas)
        //'/api/students/update/'.$id, $payload ((.) untuk menghubungkanataumenyambungkan (,) buat misahin)
        $proses = (new BaseApi)->update('/api/students/update/'.$id, $payload);
        if ($proses->failed()) {
            //kalau gagal balikin lagi sama pesan errorss dari jsonnya
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            //berhasil,balikin kehalaman paling awal dengan pesan
            return redirect('/')->with('success', 'Berhasil mengubah data siswa dari API');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proses = (new BaseApi)->delete('/api/students/delete/'.$id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect('/')->with('success', 'Berhasil hapus data sementara dari API');
        }
    }
    public function trash()
    {
        $proses = (new BaseApi)->trash('/api/students/show/trash');
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            $studentsTrash = $proses->json('data');
            return view('trash')->with(['studentsTrash' => $studentsTrash]);
        }
    }
    public function permanent($id)
    {
        $proses = (new BaseApi)->permanent('/api/students/trash/delete/permanent/'. $id);
        if ($proses->failed()) {
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors'=> $errors]);
        }else {
            return redirect()->back()->with('success', 'Berhasil menghapus data secara permanent');
        }
    }
    public function restore($id)
    {
        $proses = (new BaseApi)->restore('/api/students/trash/restore/'. $id);
        if ($proses->failed()){
            $errors = $proses->json('data');
            return redirect()->back()->with(['errors' => $errors]);
        }else {
            return redirect()->back()->with('success', 'Berhasil mengembalikan data dari sampah');
        }
    }

}
