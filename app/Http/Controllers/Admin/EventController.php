<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $categories = \App\Models\Category::withCount('events')->get();
        $selectedCategory = $request->query('category_id');

        $events = \App\Models\Event::with('category')
            ->when($selectedCategory, fn($q) => $q->where('category_id', $selectedCategory))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.events.index', compact('events', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'category_id'  => 'required',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'date'         => 'required|date',
            'location'     => 'required|string|max:255',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
        ]);

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        \App\Models\Event::create($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Data Event berhasil ditambahkan.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Data event berhasil dihapus secara permanen.');
    }

    public function edit(Event $event)
    {
        $categories = \App\Models\Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(\Illuminate\Http\Request $request, Event $event)
    {
        $data = $request->validate([
            'category_id'  => 'required',
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'date'         => 'required|date',
            'location'     => 'required|string|max:255',
            'price'        => 'required|numeric',
            'stock'        => 'required|numeric',
        ]);

        $event->update($data);

        return redirect()->route('admin.events.index')
            ->with('success', 'Rincian data event berhasil diperbarui.');
    }
}