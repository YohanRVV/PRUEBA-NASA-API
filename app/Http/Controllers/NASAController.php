<?php

namespace App\Http\Controllers;

use App\Services\NASAService;
use Illuminate\Http\Request;

class NASAController extends Controller
{
    protected $nasaService;

    public function __construct(NASAService $nasaService)
    {
        $this->nasaService = $nasaService;
    }

    public function getInstruments()
    {
        $endpoints = ['CME', 'GST', 'IPS', 'HSS'];
        $instruments = collect();

        foreach ($endpoints as $endpoint) {
            $data = $this->nasaService->getData($endpoint, ['startDate' => now()->subDays(7)->toDateString(), 'endDate' => now()->toDateString()]);
            $instruments = $instruments->merge(collect($data)->pluck('instruments')->flatten());
        }

        return response()->json($instruments->unique()->values());
    }

    public function getActivities()
    {
        $endpoints = ['CME', 'GST', 'IPS', 'HSS'];
        $activities = collect();

        foreach ($endpoints as $endpoint) {
            $data = $this->nasaService->getData($endpoint, [
                'startDate' => now()->subDays(7)->toDateString(),
                'endDate' => now()->toDateString(),
            ]);

            $activities = $activities->merge(
                collect($data)->pluck('activityID')->map(function ($id) {
                    if (preg_match('/([A-Z]+-\d+)$/', $id, $matches)) {
                        return $matches[1];
                    }
                    return $id;
                })
            );
        }

        return response()->json($activities->unique()->values());
    }



    public function getInstrumentUsage()
    {
        $endpoints = ['CME', 'GST', 'IPS', 'HSS'];
        $instruments = collect();

        foreach ($endpoints as $endpoint) {
            $data = $this->nasaService->getData($endpoint, ['startDate' => now()->subDays(7)->toDateString(), 'endDate' => now()->toDateString()]);
            $instruments = $instruments->merge(collect($data)->pluck('instruments')->flatten());
        }

        $total = $instruments->count();
        $usage = $instruments->groupBy(fn($instrument) => $instrument)
            ->map(fn($group) => $group->count() / $total);

        return response()->json($usage);
    }

    public function getInstrumentUsageByInstrument(Request $request)
    {
        $instrument = $request->input('instrument');
    
        if (empty($instrument)) {
            return response()->json(['error' => 'Instrument is required'], 400);
        }
    
        $endpoints = ['CME', 'GST', 'IPS', 'HSS'];
        $instruments = collect();
    
        foreach ($endpoints as $endpoint) {
            $data = $this->nasaService->getData($endpoint, [
                'startDate' => now()->subDays(7)->toDateString(),
                'endDate' => now()->toDateString(),
            ]);
    
            $instruments = $instruments->merge(collect($data)->pluck('instruments')->flatten());
        }
    
        $total = $instruments->count();
        $usage = $instruments->groupBy(fn($instr) => $instr)
            ->map(fn($group) => round($group->count() / $total, 4));
    
        $percentage = $usage[$instrument] ?? 0;
    
        return response()->json([$instrument => $percentage]);
    }
    
    
    
}
