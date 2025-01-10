<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

class PageController extends Controller
{
    public function about()
    {
        \Log::info('About page is being accessed');
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
            'message' => 'required|string',
        ]);

        // Mail gönderme işlemi (Mail sınıfını daha sonra oluşturacağız)
        Mail::to(config('mail.from.address'))->send(new ContactForm($validated));

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
