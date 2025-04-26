<?php

namespace App\Http\Controllers;

use App\Models\Pupuk;
use App\Models\KelompokTani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    /**
     * Show the landing page with fertilizer and farmer groups data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Using cache as mentioned in documentation
        $pupuk = Cache::remember('pupuk.all', 300, function () {
            return Pupuk::all();
        });
        
        $kelompokTani = Cache::remember('kelompokTani.with.petani', 300, function () {
            return KelompokTani::with('petani')->get();
        });
        
        return view('landing', compact('pupuk', 'kelompokTani'));
    }
}