<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prompt;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prompts = Prompt::latest()->paginate(10);
        return view('admin.prompts.index', compact('prompts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prompts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:prompts,name',
            'button_text' => 'required|string|max:255',
            'description' => 'required|string',
            'prompt_template' => 'required|string',
            'color' => 'required|string|max:7',
        ]);

        Prompt::create($validatedData);

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prompt $prompt)
    {
        return view('admin.prompts.edit', compact('prompt'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prompt $prompt)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:prompts,name,' . $prompt->id,
            'button_text' => 'required|string|max:255',
            'description' => 'required|string',
            'prompt_template' => 'required|string',
            'color' => 'required|string|max:7',
        ]);

        $prompt->update($validatedData);

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prompt $prompt)
    {
        $prompt->delete();
        return redirect()->route('admin.prompts.index')->with('success', 'Prompt berhasil dihapus.');
    }
}
