<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Helpers\SiteContentHelper;
use App\Http\Controllers\Admin\SiteContentController;

class ContactController extends Controller
{
    public function show()
    {
        $navData = SiteContentHelper::get('navigation', SiteContentController::DEFAULTS['navigation']);
        $footerData = SiteContentHelper::get('footer', SiteContentController::DEFAULTS['footer']);

        return view('contact', compact('navData', 'footerData'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|in:General Inquiry,Report a Problem,Business Partnership,Other',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')
            ->with('success', "Thanks! We'll get back to you soon.");
    }
}
