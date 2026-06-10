<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    // ========================
    // GET ACTIVE HERO (Frontend)
    // ========================
    public function index()
    {
        return Hero::where('is_active', true)->get();
    }

    // ========================
    // ADMIN: LIST ALL HEROES
    // ========================
    public function all()
    {
        return Hero::orderBy('created_at', 'desc')->get();
    }

    // ========================
    // CREATE HERO
    // ========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'primary_button_text' => 'nullable|string',
            'secondary_button_text' => 'nullable|string',
            'layout' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }

        $hero = Hero::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero created successfully',
            'data' => $hero
        ]);
    }

    // ========================
    // UPDATE HERO
    // ========================
    public function update(Request $request, $id)
    {
        $hero = Hero::findOrFail($id);

        $validated = $request->validate([
            'badge' => 'nullable|string',
            'title' => 'sometimes|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'primary_button_text' => 'nullable|string',
            'secondary_button_text' => 'nullable|string',
            'layout' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($hero->image) {
                Storage::disk('public')->delete($hero->image);
            }

            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }

        $hero->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero updated successfully',
            'data' => $hero
        ]);
    }

    // ========================
    // DELETE HERO
    // ========================
    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);

        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero deleted successfully'
        ]);
    }

    // ========================
    // SET ACTIVE HERO
    // ========================
    public function setActive($id)
    {
        Hero::where('is_active', true)->update(['is_active' => false]);

        $hero = Hero::findOrFail($id);
        $hero->update(['is_active' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Active hero updated',
            'data' => $hero
        ]);
    }
}
