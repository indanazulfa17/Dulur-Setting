<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->get();
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Material::create($request->all());
        return redirect()->route('admin.materials.index')->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate(['name' => 'required']);
        $material->update($request->all());
        return redirect()->route('admin.materials.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Bahan berhasil dihapus.');
    }
}

