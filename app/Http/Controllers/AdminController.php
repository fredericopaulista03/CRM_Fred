<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalLeads = Lead::count();
        $leadsByStatus = Lead::selectRaw('kanban_status, COUNT(*) as count')
            ->groupBy('kanban_status')
            ->pluck('count', 'kanban_status');
        
        $recentLeads = Lead::orderBy('created_at', 'desc')->take(5)->get();
        $avgScore = Lead::avg('score');
        
        return view('admin.dashboard', compact('totalLeads', 'leadsByStatus', 'recentLeads', 'avgScore'));
    }

    public function kanban()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $leads = Lead::all()->groupBy('kanban_status');
        return view('admin.kanban', compact('leads'));
    }

    public function show($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $lead = Lead::findOrFail($id);
        return view('admin.details', compact('lead'));
    }

    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Hardcoded credentials as requested
        if ($credentials['email'] === 'admin@example.com' && $credentials['password'] === 'admin123') {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function updateStatus(Request $request, $id)
    {
         if (!Session::get('admin_logged_in')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $lead = Lead::findOrFail($id);
        $lead->kanban_status = $request->status;
        $lead->save();

        return response()->json(['success' => true]);
    }

    public function reanalyze($id, \App\Services\GeminiService $geminiService)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $lead = Lead::findOrFail($id);
        
        // Prepare data for analysis
        $data = $lead->toArray();
        
        $analysis = $geminiService->analyzeLead($data);

        if ($analysis) {
            $lead->update([
                'revenue_category' => $analysis['faturamento_categoria'] ?? null,
                'investment_category' => $analysis['invest_categoria'] ?? null,
                'ai_tags' => $analysis['tags_ai'] ?? [],
                'score' => $analysis['score_potencial'] ?? 0,
                'urgency' => $analysis['urgencia'] ?? 'baixa',
                'kanban_status' => $this->determineKanbanStatus($analysis['faturamento_categoria'] ?? '0-10k'),
            ]);
            
            return back()->with('success', 'Lead reanalisado com sucesso!');
        }

        return back()->with('error', 'Falha ao reanalisar lead. Verifique a chave da API.');
    }

    private function determineKanbanStatus($revenueCategory)
    {
        if (str_contains($revenueCategory, '200k+')) return 'Ultra Quente';
        if (str_contains($revenueCategory, '50-200k')) return 'Quente';
        if (str_contains($revenueCategory, '10-50k')) return 'Morno';
        return 'Frio';
    }
}
