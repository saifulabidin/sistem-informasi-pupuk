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

    /**
     * Show the about us page
     * 
     * @return \Illuminate\View\View
     */
    public function tentangKami()
    {
        return view('pages.tentang-kami');
    }

    /**
     * Show the user guide page
     * 
     * @return \Illuminate\View\View
     */
    public function panduanPenggunaan()
    {
        return view('pages.panduan-penggunaan');
    }

    /**
     * Show the privacy policy page
     * 
     * @return \Illuminate\View\View
     */
    public function kebijakanPrivasi()
    {
        return view('pages.kebijakan-privasi');
    }

    /**
     * Show the terms and conditions page
     * 
     * @return \Illuminate\View\View
     */
    public function syaratKetentuan()
    {
        return view('pages.syarat-ketentuan');
    }
}