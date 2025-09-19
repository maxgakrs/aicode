<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CostumeController extends Controller
{
    /**
     * Display a listing of costumes
     */
    public function index(Request $request)
    {
        $query = Costume::query();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $costumes = $query->paginate(12);

        return view('costumes.index', compact('costumes'));
    }

    /**
     * Show the form for creating a new costume
     */
    public function create()
    {
        return view('costumes.create');
    }

    /**
     * Store a newly created costume
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('costumes', 'public');
            $data['image'] = $imagePath;
        }

        Costume::create($data);

        return redirect()->route('costumes.index')->with('success', 'ชุดถูกเพิ่มเรียบร้อยแล้ว');
    }

    /**
     * Display the specified costume
     */
    public function show(Costume $costume)
    {
        return view('costumes.show', compact('costume'));
    }

    /**
     * Show the form for editing the specified costume
     */
    public function edit(Costume $costume)
    {
        return view('costumes.edit', compact('costume'));
    }

    /**
     * Update the specified costume
     */
    public function update(Request $request, Costume $costume)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,rented,maintenance',
            'available_from' => 'nullable|date',
            'available_to' => 'nullable|date|after:available_from',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($costume->image) {
                Storage::disk('public')->delete($costume->image);
            }
            $imagePath = $request->file('image')->store('costumes', 'public');
            $data['image'] = $imagePath;
        }

        $costume->update($data);

        return redirect()->route('costumes.index')->with('success', 'ชุดถูกอัพเดทเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified costume
     */
    public function destroy(Costume $costume)
    {
        // Delete image if exists
        if ($costume->image) {
            Storage::disk('public')->delete($costume->image);
        }

        $costume->delete();

        return redirect()->route('costumes.index')->with('success', 'ชุดถูกลบเรียบร้อยแล้ว');
    }
}
