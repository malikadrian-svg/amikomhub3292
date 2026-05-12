<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar semua partner.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $partners = Partner::when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id')
            ->get();

        return view('admin.partners.index', compact('partners', 'search'));
    }

    /**
     * Menampilkan form untuk mendaftarkan partner baru.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Menyimpan data partner baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'logo_url' => 'required|url|max:500',
        ]);

        Partner::create([
            'name'     => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')
                         ->with('success', 'Partner berhasil ditambahkan!');
    }
}
