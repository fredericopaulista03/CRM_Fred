<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = \App\Models\Setting::get('gemini_api_key', env('GEMINI_API_KEY'));
    }

    public function analyzeLead(array $data)
    {
        // Extract custom data if present
        $customData = $data['custom_data'] ?? [];
        unset($data['custom_data']); // Remove from main array to avoid duplication if merged

        // Merge custom data into main data for easier access, but keep original keys if they exist
        $mergedData = array_merge($customData, $data);

        $revenue = $mergedData['revenue_raw'] ?? 'Não informado';
        $investment = $mergedData['investment_raw'] ?? 'Não informado';
        $branch = $mergedData['branch'] ?? 'Não informado';
        $objective = $mergedData['objective'] ?? 'Não informado';
        $hasTraffic = $mergedData['has_traffic'] ?? 'Não informado';
        $instagram = $mergedData['instagram'] ?? 'Não informado';

        // Format other custom fields for the prompt
        $otherFields = "";
        foreach ($customData as $key => $value) {
            if (!in_array($key, ['revenue_raw', 'investment_raw', 'branch', 'objective', 'has_traffic', 'instagram'])) {
                $otherFields .= "{$key}: {$value}\n";
            }
        }

        $prompt = "Você é um assistente de qualificação de leads para uma agência de tráfego pago. Receba as respostas abaixo e devolva um JSON contendo:
        faturamento_categoria (0-10k, 10-50k, 50-200k, 200k+)
        invest_categoria (1k, 3k, 5k, 10k, 10k+)
        tags_ai = lista com insights do lead
        score_potencial (0-100)
        urgencia (baixa, média, alta)
        resumo = descrição curta do potencial do lead
        Responda apenas com JSON puro.

        Dados do lead:
        Faturamento: {$revenue}
        Investimento: {$investment}
        Ramo: {$branch}
        Objetivo: {$objective}
        Já faz tráfego: {$hasTraffic}
        Instagram: {$instagram}
        
        Outras informações:
        {$otherFields}
        ";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json'
                ]
            ]);

            if ($response->successful()) {
                $content = $response->json()['candidates'][0]['content']['parts'][0]['text'];
                return json_decode($content, true);
            }

            Log::error('Gemini API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return null;
        }
    }
}
