<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactForm($validated));

            return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
        } catch (\Exception $e) {
            \Log::error('Mail gönderme hatası: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Mesajınız gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    }
}
