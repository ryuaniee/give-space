<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.campaigns.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,active,completed,closed'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'title.required' => 'Judul campaign wajib diisi.',
            'description.required' => 'Deskripsi campaign wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2 MB.',
            'target_amount.required' => 'Target donasi wajib diisi.',
            'target_amount.numeric' => 'Target donasi harus berupa angka.',
            'target_amount.min' => 'Target donasi harus lebih dari 0.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'status.required' => 'Status campaign wajib dipilih.',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('campaigns', 'public');
        }

        Campaign::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'image' => $imagePath,
            'target_amount' => $validated['target_amount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil ditambahkan.');
    }

    public function show(Campaign $campaign)
    {
        return redirect()->route('admin.campaigns.edit', $campaign);
    }

    public function edit(Campaign $campaign)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.campaigns.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,active,completed,closed'],
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }

            $data['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil diperbarui.');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaign berhasil dihapus.');
    }
}