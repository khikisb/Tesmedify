<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        // Filter berdasarkan nama dan kode kategori
        if ($request->has('nama') && $request->nama != '') {
            $categories = $categories->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->has('kode') && $request->kode != '') {
            $categories = $categories->where('kode', 'like', '%' . $request->kode . '%');
        }

        $categories = $categories->get();

        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $items = $category->masterItems; // Mendapatkan semua MasterItems yang terkait dengan kategori ini

        return view('categories.show', compact('category', 'items'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required',
        ]);

        $category = Category::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index');
    }
}
