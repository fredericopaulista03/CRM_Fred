<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizConfigController extends Controller
{
    public function index()
    {
        $questions = QuizQuestion::orderBy('order')->get();
        return view('admin.quiz-config', compact('questions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'field_name' => 'required|string',
            'input_type' => 'required|in:text,select,radio,email,tel',
            'options_text' => 'nullable|string',
            'placeholder' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
        ]);

        $data = $validated;
        if (!empty($data['options_text'])) {
            $data['options'] = array_filter(array_map('trim', explode("\n", $data['options_text'])));
        } else {
            $data['options'] = null;
        }
        unset($data['options_text']);

        QuizQuestion::create($data);

        return redirect()->route('admin.quiz-config')->with('success', 'Pergunta criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $question = QuizQuestion::findOrFail($id);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'field_name' => 'required|string',
            'input_type' => 'required|in:text,select,radio,email,tel',
            'options_text' => 'nullable|string',
            'placeholder' => 'nullable|string',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
        ]);

        $data = $validated;
        if (!empty($data['options_text'])) {
            $data['options'] = array_filter(array_map('trim', explode("\n", $data['options_text'])));
        } else {
            $data['options'] = null;
        }
        unset($data['options_text']);

        $question->update($data);

        return redirect()->route('admin.quiz-config')->with('success', 'Pergunta atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $question = QuizQuestion::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.quiz-config')->with('success', 'Pergunta excluída com sucesso!');
    }

    public function getQuestions()
    {
        return response()->json(
            QuizQuestion::where('is_active', true)
                ->orderBy('order')
                ->get()
        );
    }
}
