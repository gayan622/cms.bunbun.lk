<?php

namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    // LIST PAGE (Blade)
    public function index()
    {
        $heroes = Hero::latest()->get();

        return view('admin.heroes.index', compact('heroes'));
    }

    // CREATE PAGE
    public function create()
    {
        return view('admin.heroes.create');
    }

    // STORE HERO
    public function store(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'primary_button_text' => 'nullable|string',
            'secondary_button_text' => 'nullable|string',
            'layout' => 'required|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }

        // if checkbox not sent
        $validated['is_active'] = $request->has('is_active');

        Hero::create($validated);

        return redirect('/admin/heroes')
            ->with('success', 'Hero created successfully');
    }

    // EDIT PAGE
    public function edit(Hero $hero)
    {
        return view('admin.heroes.edit', compact('hero'));
    }

    // UPDATE HERO
    public function update(Request $request, Hero $hero)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'primary_button_text' => 'nullable|string',
            'secondary_button_text' => 'nullable|string',
            'layout' => 'required|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($hero->image) {
                Storage::disk('public')->delete($hero->image);
            }

            $validated['image'] = $request->file('image')->store('heroes', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $hero->update($validated);

        return redirect('/admin/heroes')
            ->with('success', 'Hero updated successfully');
    }

    // DELETE HERO
    public function destroy(Hero $hero)
    {
        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return redirect('/admin/heroes')
            ->with('success', 'Hero deleted successfully');
    }

    // SET ACTIVE HERO
    public function setActive(Hero $hero)
        {
            Hero::where('is_active', true)->update(['is_active' => false]);

            $hero->update(['is_active' => true]);

            return redirect('/admin/heroes')
                ->with('success', 'Active hero updated');
        }
}
