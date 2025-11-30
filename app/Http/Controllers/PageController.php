<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('questions')->orderBy('created_at', 'desc')->get();
        $allQuestions = QuizQuestion::where('is_active', true)->orderBy('order')->get();
        return view('admin.pages', compact('pages', 'allQuestions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'questions' => 'nullable|array',
            'questions.*' => 'exists:quiz_questions,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page = Page::create($validated);

        // Attach questions with order
        if (!empty($validated['questions'])) {
            foreach ($validated['questions'] as $order => $questionId) {
                $page->questions()->attach($questionId, ['order' => $order + 1]);
            }
        }

        return redirect()->route('admin.pages')->with('success', 'Página criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'questions' => 'nullable|array',
            'questions.*' => 'exists:quiz_questions,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->update($validated);

        // Sync questions with order
        $syncData = [];
        if (!empty($validated['questions'])) {
            foreach ($validated['questions'] as $order => $questionId) {
                $syncData[$questionId] = ['order' => $order + 1];
            }
        }
        $page->questions()->sync($syncData);

        return redirect()->route('admin.pages')->with('success', 'Página atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages')->with('success', 'Página excluída com sucesso!');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page-quiz', compact('page'));
    }

    public function getQuestions($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return response()->json($page->questions);
    }
}
