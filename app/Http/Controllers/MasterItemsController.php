<?php

namespace App\Http\Controllers;


use App\Models\MasterItem;
use Illuminate\Http\Request;
use App\Models\Category;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        // Mulai query dasar
        $data_search = MasterItem::query();

        // Filter berdasarkan kode jika ada
        if (!empty($kode)) {
            $data_search = $data_search->where('kode', $kode);
        }

        // Filter berdasarkan nama jika ada
        if (!empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        // Filter berdasarkan harga min dan max
        if (!empty($hargamin) && !empty($hargamax)) {
            $data_search = $data_search->whereBetween('harga_beli', [$hargamin, $hargamax]);
        } elseif (!empty($hargamin)) {
            // Jika hanya harga min yang diisi
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            // Jika hanya harga max yang diisi
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        // Ambil data yang sudah difilter dan urutkan berdasarkan ID
        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

public function formView($method, $id = 0)
{
    // Ambil item berdasarkan ID jika sedang edit, atau buat baru jika method adalah 'new'
    if ($method == 'new') {
        $item = new MasterItem;
    } else {
        // Memastikan untuk memuat relasi 'categories' dengan item
        $item = MasterItem::with('categories')->find($id);  // Memuat relasi categories
    }

    // Ambil semua kategori untuk ditampilkan di form
    $categories = Category::all();  // Menarik semua kategori

    // Kirim data item, kategori, dan metode (new/edit) ke view
    return view('master_items.form.form', [
        'item' => $item,
        'categories' => $categories,
        'method' => $method,
    ]);
}
    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

 public function formSubmit(Request $request, $method, $id = 0)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'harga_beli' => 'required|numeric',
        'laba' => 'required|numeric',
        'supplier' => 'required|string|max:255',
        'jenis' => 'required|string|max:255',
        'categories' => 'nullable|array', // Menambahkan validasi untuk kategori
        'categories.*' => 'exists:categories,id', // Memastikan kategori yang dipilih ada di tabel categories
    ]);

    // Menyimpan atau mengupdate Master Item
    if ($method == 'new') {
        $data_item = new MasterItem;
        $kode = MasterItem::count('id');
        $kode = $kode + 1;
        $kode = str_pad($kode, 5, '0', STR_PAD_LEFT); // Menambahkan 1 ke kode
    } else {
        $data_item = MasterItem::find($id);
        $kode = $data_item->kode;
    }

    // Menyimpan data lainnya
    $data_item->nama = $request->nama;
    $data_item->harga_beli = $request->harga_beli;
    $data_item->laba = $request->laba;
    $data_item->kode = $kode;
    $data_item->supplier = $request->supplier;
    $data_item->jenis = $request->jenis;
    $data_item->save();

    // Menyimpan relasi kategori many-to-many
    if ($request->has('categories')) {
        $data_item->categories()->sync($request->categories);  // Sync kategori yang dipilih
    }

    return redirect()->route('master-items.index');
}

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }


}
