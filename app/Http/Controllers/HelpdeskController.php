<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class HelpdeskController extends Controller
{
    // Menampilkan daftar FAQ yang sudah dijawab
    public function index()
    {
        $faqs = FAQ::whereNotNull('answer')->get();
        return Inertia::render('FAQ', ['faqs' => $faqs]); // Pastikan rute sesuai dengan folder Vue
    }

    // Menampilkan daftar FAQ yang masih menunggu jawaban
    public function unanswered()
    {
        $faqs = FAQ::whereNull('answer')->get();
        return Inertia::render('Pages/UnansweredFAQ', ['faqs' => $faqs]);
    }

public function store(Request $request)
{
    DB::enableQueryLog(); // Aktifkan log query

    FAQ::create([
        'category' => $request->category,
        'question' => $request->question,
        'answer' => $request->answer, // Pastikan ini masuk
    ]);

    dd(DB::getQueryLog()); // Cek query yang dijalankan
}

    
    // Menjawab pertanyaan oleh verifikator
    public function answer(Request $request, $id)
    {
        $faq = FAQ::findOrFail($id);

        $request->validate([
            'answer' => 'required|string|max:1000',
        ]);

        $faq->update(['answer' => $request->answer]);

        return redirect()->route('helpdesk.index')->with('message', 'FAQ berhasil dijawab.');
    }
    public function faq()
{
    $faqs = FAQ::whereNotNull('answer')->get();
    return Inertia::render('FAQ', ['faqs' => $faqs]);
}
public function create()
{
    return Inertia::render('Helpdesk'); // Halaman tambah FAQ
}


}
