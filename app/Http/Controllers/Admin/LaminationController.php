<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lamination;
use Illuminate\Http\Request;

class LaminationController extends Controller
{
    public function index()
    {
        $laminations = Lamination::latest()->get();
        return view('admin.laminations.index', compact('laminations'));
    }

    public function create()
    {
        return view('admin.laminations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Lamination::create($request->all());
        return redirect()->route('admin.laminations.index')->with('success', 'Laminasi berhasil ditambahkan.');
    }

    public function edit(Lamination $lamination)
    {
        return view('admin.laminations.edit', compact('lamination'));
    }

    public function update(Request $request, Lamination $lamination)
    {
        $request->validate(['name' => 'required']);
        $lamination->update($request->all());
        return redirect()->route('admin.laminations.index')->with('success', 'Laminasi berhasil diperbarui.');
    }

    public function destroy(Lamination $lamination)
    {
        $lamination->delete();
        return redirect()->route('admin.laminations.index')->with('success', 'Laminasi berhasil dihapus.');
    }
}
