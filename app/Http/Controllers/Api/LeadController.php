<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'instagram' => 'nullable|string',
            'branch' => 'nullable|string',
            'revenue_raw' => 'nullable|string',
            'investment_raw' => 'nullable|string',
            'objective' => 'nullable|string',
            'has_traffic' => 'nullable|string',
        ]);

        // Call Gemini AI
        $aiAnalysis = $this->geminiService->analyzeLead($validated);

        $leadData = array_merge($validated, [
            'revenue_category' => $aiAnalysis['faturamento_categoria'] ?? null,
            'investment_category' => $aiAnalysis['invest_categoria'] ?? null,
            'ai_tags' => $aiAnalysis['tags_ai'] ?? [],
            'score' => $aiAnalysis['score_potencial'] ?? 0,
            'urgency' => $aiAnalysis['urgencia'] ?? 'baixa',
            'kanban_status' => $this->determineKanbanStatus($aiAnalysis['faturamento_categoria'] ?? '0-10k'),
        ]);

        $lead = Lead::create($leadData);

        return response()->json(['message' => 'Lead created successfully', 'lead' => $lead], 201);
    }

    private function determineKanbanStatus($revenueCategory)
    {
        // Map revenue category to Kanban status
        // 0-10k -> Cold
        // 10-50k -> Warm
        // 50-200k -> Hot
        // 200k+ -> Ultra Hot
        
        // Normalize string to match expected keys if needed, but assuming Gemini follows prompt
        if (str_contains($revenueCategory, '200k+')) return 'Ultra Quente';
        if (str_contains($revenueCategory, '50-200k')) return 'Quente';
        if (str_contains($revenueCategory, '10-50k')) return 'Morno';
        return 'Frio';
    }
}
