<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class AdminTableController extends Controller
{
    public function index()
    {
        $tables = Table::orderBy('number')->get();

        return view('dashboard.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('dashboard.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:tables,number',
            'label' => 'nullable|string|max:255',
        ]);

        Table::create($validated);

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(Table $table)
    {
        return view('dashboard.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:tables,number,' . $table->id,
            'label' => 'nullable|string|max:255',
        ]);

        $table->update($validated);

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
