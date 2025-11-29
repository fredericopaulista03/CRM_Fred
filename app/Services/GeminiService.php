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
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function analyzeLead(array $data)
    {
        $prompt = "Você é um assistente de qualificação de leads para uma agência de tráfego pago. Receba as respostas abaixo e devolva um JSON contendo:
        faturamento_categoria (0-10k, 10-50k, 50-200k, 200k+)
        invest_categoria (1k, 3k, 5k, 10k, 10k+)
        tags_ai = lista com insights do lead
        score_potencial (0-100)
        urgencia (baixa, média, alta)
        resumo = descrição curta do potencial do lead
        Responda apenas com JSON puro.

        Dados do lead:
        Faturamento: {$data['revenue_raw']}
        Investimento: {$data['investment_raw']}
        Ramo: {$data['branch']}
        Objetivo: {$data['objective']}
        Já faz tráfego: {$data['has_traffic']}
        Instagram: {$data['instagram']}
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
