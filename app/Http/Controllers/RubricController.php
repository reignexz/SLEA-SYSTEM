<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubric;

class RubricController extends Controller
{
    public function index()
    {
        $rubrics = Rubric::all()->groupBy('section_key');
        return view('admin.rubrics.index', compact('rubrics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_key' => 'required',
            'sub_section' => 'nullable|string',
            'position_or_title' => 'required|string',
            'points' => 'required|string',
            'max_points' => 'nullable|string',
            'evidence' => 'nullable|string',
        ]);

        Rubric::create($validated);
        return redirect()->route('admin.rubrics.index')->with('status', 'Rubric item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $rubric = Rubric::findOrFail($id);

        $validated = $request->validate([
            'section_key' => 'required',
            'sub_section' => 'nullable|string',
            'position_or_title' => 'required|string',
            'points' => 'required|string',
            'max_points' => 'nullable|string',
            'unit_note' => 'nullable|string',
            'evidence' => 'nullable|string',
        ]);

        $rubric->update($validated);
        return redirect()->route('admin.rubrics.index')->with('status', 'Rubric item updated successfully!');
    }

    public function destroy($id)
    {
        Rubric::destroy($id);
        return redirect()->route('admin.rubrics.index')->with('status', 'Rubric item deleted.');
    }
}
