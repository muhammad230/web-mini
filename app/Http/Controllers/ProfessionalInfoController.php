<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SiteContentHelper;
use App\Http\Controllers\Admin\SiteContentController;

class ProfessionalInfoController extends Controller
{
    public function show()
    {
        $navData = SiteContentHelper::get('navigation', SiteContentController::DEFAULTS['navigation']);
        $footerData = SiteContentHelper::get('footer', SiteContentController::DEFAULTS['footer']);

        return view('professionals.why-join', compact('navData', 'footerData'));
    }
}
