<?php

namespace App\Http\Controllers;

use App\Models\AlokasiPupuk;
use App\Models\KelompokTani;
use App\Models\Pupuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export allocation data to PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportAlokasiPdf(Request $request)
    {
        $query = AlokasiPupuk::with(['kelompokTani', 'pupuk']);
        
        // Apply filters
        if ($request->has('kelompok_tani_id')) {
            $query->where('kelompok_tani_id', $request->kelompok_tani_id);
        }
        
        if ($request->has('pupuk_id')) {
            $query->where('pupuk_id', $request->pupuk_id);
        }
        
        if ($request->has('periode')) {
            $query->where('periode', $request->periode);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Get data
        $alokasi = $query->get();
        
        // Additional data for the report
        $data = [
            'alokasi' => $alokasi,
            'title' => 'Laporan Alokasi Pupuk',
            'date' => now()->format('d-m-Y'),
            'filters' => [
                'kelompok_tani' => $request->has('kelompok_tani_id') ? 
                    KelompokTani::find($request->kelompok_tani_id)->nama : 'Semua',
                'pupuk' => $request->has('pupuk_id') ? 
                    Pupuk::find($request->pupuk_id)->nama : 'Semua',
                'periode' => $request->periode ?? 'Semua',
                'status' => $request->status ?? 'Semua',
            ],
        ];
        
        // Generate PDF
        $pdf = PDF::loadView('exports.alokasi-pdf', $data);
        
        // Set paper to landscape for better table display
        $pdf->setPaper('a4', 'landscape');
        
        // Download or stream
        return $request->has('stream') ? 
            $pdf->stream('alokasi-pupuk.pdf') : 
            $pdf->download('alokasi-pupuk.pdf');
    }

    /**
     * Export allocation data to Excel
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportAlokasiExcel(Request $request)
    {
        // Create export functionality using Laravel Excel
        // For now, we'll just redirect to PDF as Excel export needs a dedicated export class
        return redirect()->route('export.alokasi.pdf', $request->all());
    }
}