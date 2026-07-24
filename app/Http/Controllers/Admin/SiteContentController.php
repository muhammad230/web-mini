<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use App\Helpers\SiteContentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    public const DEFAULTS = [
        'hero' => [
            'heading_prefix' => 'Get Your Home<br>Jobs Done&nbsp;',
            'highlight_word' => 'Fast &amp;<br>Reliably',
            'subheading' => 'Connect with vetted local professionals for plumbing,<br>electrical, carpentry, and more. Book in minutes,<br>get the job done right.',
            'hero_image' => 'images/slider.png',
            'search_placeholder' => 'Enter your city or zip code',
        ],
        'stats_bar' => [
            'auto_calculate' => true,
            'stats' => [
                ['icon' => 'shield', 'number' => '5,000+', 'label' => "Verified<br>Professionals"],
                ['icon' => 'lightning', 'number' => '< 2h', 'label' => "Avg Response<br>Time"],
                ['icon' => 'briefcase', 'number' => '50,000+', 'label' => "Jobs<br>Completed"],
                ['icon' => 'star', 'number' => '4.8', 'label' => "Avg<br>Rating"],
            ],
        ],
        'browse_trades' => [
            'trades' => [
                ['name' => 'Plumbing', 'description' => 'Pipes, leaks, fittings', 'icon' => 'plumbing', 'color' => '#1b3a30', 'bg' => '#e8f4f1', 'active' => true],
                ['name' => 'Electrical', 'description' => 'Wiring, lights,<br>switches', 'icon' => 'electrical', 'color' => '#d4900a', 'bg' => '#fff8e6', 'active' => true],
                ['name' => 'Carpentry', 'description' => 'Woodwork, furniture,<br>repairs', 'icon' => 'carpentry', 'color' => '#111827', 'bg' => '#fef3ee', 'active' => true],
                ['name' => 'Painting', 'description' => 'Interior, exterior,<br>walls', 'icon' => 'painting', 'color' => '#111827', 'bg' => '#fef0f0', 'active' => true],
                ['name' => 'AC Repair', 'description' => 'AC installation,<br>repair, service', 'icon' => 'ac', 'color' => '#111827', 'bg' => '#eef6fb', 'active' => true],
                ['name' => 'Cleaning', 'description' => 'Home, office,<br>deep cleaning', 'icon' => 'cleaning', 'color' => '#111827', 'bg' => '#e8f4f1', 'active' => true],
                ['name' => 'Appliance Repair', 'description' => 'Washing machines,<br>fridge, more', 'icon' => 'appliance', 'color' => '#111827', 'bg' => '#f0eef8', 'active' => true],
                ['name' => 'Handyman', 'description' => 'General repairs<br>&amp; maintenance', 'icon' => 'handyman', 'color' => '#111827', 'bg' => '#faf3e8', 'active' => true],
            ],
        ],
        'how_it_works' => [
            'steps' => [
                [
                    'number' => 1,
                    'title' => 'Post Your Job',
                    'description' => 'Describe what you need done, your location, and when you want it completed.',
                    'icon' => 'post',
                ],
                [
                    'number' => 2,
                    'title' => "Get Matched with<br>Vetted Pros",
                    'description' => 'Receive quotes and profiles from verified, local professionals.',
                    'icon' => 'match',
                ],
                [
                    'number' => 3,
                    'title' => "Book &amp; Get It Done",
                    'description' => 'Choose your pro, schedule the job, and get your home service completed.',
                    'icon' => 'book',
                ],
            ],
        ],
        'featured_pros' => [
            'mode' => 'auto',
            'title' => 'Featured Professionals',
            'featured_ids' => [],
        ],
        'testimonials' => [
            'mode' => 'auto',
            'title' => "What Our Customers Say",
            'pinned_ids' => [],
            'custom_testimonials' => [],
        ],
        'cta_banner' => [
            'heading' => 'Are You a Home Service Professional?',
            'description' => 'Join Fixly and get access to hundreds of local job leads every month.',
            'button_text' => 'Join as a professional',
        ],
        'footer' => [
            'company_description' => 'Connecting homeowners with reliable local professionals for all their home service needs.',
            'social' => [
                'facebook' => '#',
                'instagram' => '#',
                'twitter' => '#',
                'youtube' => '#',
            ],
            'link_groups' => [
                [
                    'title' => 'Company',
                    'links' => [
                        ['label' => 'About us', 'url' => '/about'],
                        ['label' => 'Careers', 'url' => '/careers'],
                        ['label' => 'Press', 'url' => '/press'],
                    ],
                ],
                [
                    'title' => 'For Customers',
                    'links' => [
                        ['label' => 'How it works', 'url' => '/#how-it-works'],
                        ['label' => 'Browse services', 'url' => '/#browse'],
                        ['label' => 'Help center', 'url' => '/contact'],
                    ],
                ],
                [
                    'title' => 'For Pros',
                    'links' => [
                        ['label' => 'Join as a pro', 'url' => '/professionals/why-join'],
                        ['label' => 'Pro dashboard', 'url' => '/dashboard/professional'],
                        ['label' => 'Resources', 'url' => '/resources'],
                    ],
                ],
            ],
            'copyright' => 'Fixly. All rights reserved.',
        ],
        'navigation' => [
            'links' => [
                ['label' => 'How it works', 'url' => '#how-it-works'],
                ['label' => 'Browse services', 'url' => '#browse'],
                ['label' => 'For professionals', 'url' => '#professionals'],
            ],
        ],
    ];

    public function index()
    {
        $sections = SiteContent::with('updater')->get()->keyBy('section');
        return view('dashboard.cms', compact('sections'));
    }

    public function update(Request $request, string $section)
    {
        $validSections = array_keys(self::DEFAULTS);
        if (!in_array($section, $validSections)) {
            return back()->with('error', 'Invalid section.');
        }

        $defaults = self::DEFAULTS[$section];
        $rules = $this->getValidationRules($section);
        $validated = $request->validate($rules);

        $content = $this->processInput($section, $validated, $defaults);

        SiteContent::updateOrCreate(
            ['section' => $section],
            [
                'content' => $content,
                'last_updated_by' => Auth::id(),
            ]
        );

        SiteContentHelper::flush($section);

        return back()->with('success', ucwords(str_replace('_', ' ', $section)) . ' section updated successfully.');
    }

    public function reset(string $section)
    {
        $validSections = array_keys(self::DEFAULTS);
        if (!in_array($section, $validSections)) {
            return back()->with('error', 'Invalid section.');
        }

        SiteContent::updateOrCreate(
            ['section' => $section],
            [
                'content' => self::DEFAULTS[$section],
                'last_updated_by' => Auth::id(),
            ]
        );

        SiteContentHelper::flush($section);

        return back()->with('success', ucwords(str_replace('_', ' ', $section)) . ' section reset to defaults.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('image')->store('site-content', 'public');

        return response()->json([
            'url' => Storage::url($path),
            'path' => $path,
        ]);
    }

    private function getValidationRules(string $section): array
    {
        return match ($section) {
            'hero' => [
                'heading_prefix' => 'nullable|string|max:500',
                'highlight_word' => 'nullable|string|max:200',
                'subheading' => 'nullable|string|max:1000',
                'hero_image' => 'nullable|string|max:500',
                'search_placeholder' => 'nullable|string|max:200',
            ],
            'stats_bar' => [
                'auto_calculate' => 'nullable|boolean',
                'stats.*.icon' => 'nullable|string|max:50',
                'stats.*.number' => 'nullable|string|max:50',
                'stats.*.label' => 'nullable|string|max:200',
            ],
            'browse_trades' => [
                'trades.*.name' => 'nullable|string|max:100',
                'trades.*.description' => 'nullable|string|max:200',
                'trades.*.icon' => 'nullable|string|max:50',
                'trades.*.color' => 'nullable|string|max:20',
                'trades.*.bg' => 'nullable|string|max:20',
                'trades.*.active' => 'nullable|boolean',
            ],
            'how_it_works' => [
                'steps.*.title' => 'nullable|string|max:200',
                'steps.*.description' => 'nullable|string|max:500',
                'steps.*.icon' => 'nullable|string|max:50',
            ],
            'featured_pros' => [
                'mode' => 'nullable|in:auto,manual',
                'title' => 'nullable|string|max:200',
                'featured_ids' => 'nullable|array',
                'featured_ids.*' => 'nullable|integer|exists:users,id',
            ],
            'testimonials' => [
                'mode' => 'nullable|in:auto,manual',
                'title' => 'nullable|string|max:200',
                'pinned_ids' => 'nullable|array',
                'pinned_ids.*' => 'nullable|integer',
                'custom_testimonials' => 'nullable|array',
                'custom_testimonials.*.author_name' => 'nullable|string|max:100',
                'custom_testimonials.*.author_avatar' => 'nullable|string|max:500',
                'custom_testimonials.*.service' => 'nullable|string|max:100',
                'custom_testimonials.*.text' => 'nullable|string|max:1000',
                'custom_testimonials.*.rating' => 'nullable|integer|min:1|max:5',
            ],
            'cta_banner' => [
                'heading' => 'nullable|string|max:300',
                'description' => 'nullable|string|max:500',
                'button_text' => 'nullable|string|max:100',
            ],
            'footer' => [
                'company_description' => 'nullable|string|max:500',
                'social.facebook' => 'nullable|string|max:500',
                'social.instagram' => 'nullable|string|max:500',
                'social.twitter' => 'nullable|string|max:500',
                'social.youtube' => 'nullable|string|max:500',
                'link_groups' => 'nullable|array',
                'link_groups.*.title' => 'nullable|string|max:100',
                'link_groups.*.links' => 'nullable|array',
                'link_groups.*.links.*.label' => 'nullable|string|max:100',
                'link_groups.*.links.*.url' => 'nullable|string|max:500',
                'copyright' => 'nullable|string|max:200',
            ],
            'navigation' => [
                'links.*.label' => 'nullable|string|max:100',
                'links.*.url' => 'nullable|string|max:500',
            ],
            default => [],
        };
    }

    private function processInput(string $section, array $validated, array $defaults): array
    {
        $content = $defaults;

        foreach ($validated as $key => $value) {
            data_set($content, $key, $value);
        }

        return $content;
    }
}
