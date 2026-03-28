<?php

namespace App\Http\Controllers;

use App\Support\FortoProjectStore;
use App\Support\FortoSiteLikeStore;
use App\Support\FortoSkillStore;
use App\Support\FortoVisitorStore;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(FortoSiteLikeStore $siteLikeStore, FortoVisitorStore $visitorStore): View
    {
        return view('pages.home', [
            'pageTitle' => 'Home',
            'bodyClass' => 'home-page',
            'highlights' => config('forto.highlights'),
            'owner' => config('forto.owner'),
            'siteLikeSummary' => $siteLikeStore->summary(),
            'visitorSummary' => $visitorStore->summary(),
        ]);
    }

    public function about(FortoSiteLikeStore $siteLikeStore): View
    {
        return view('pages.about', [
            'pageTitle' => 'About',
            'about' => config('forto.about'),
            'siteLikeSummary' => $siteLikeStore->summary(),
            'galleryPhotos' => collect(range(1, 18))
                ->map(fn (int $index) => [
                    'src' => asset("img/foto{$index}.jpeg"),
                    'alt' => "Album Porto {$index}",
                    'caption' => 'Porto Moment ' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                ])
                ->all(),
        ]);
    }

    public function projects(FortoProjectStore $projectStore, FortoSiteLikeStore $siteLikeStore): View
    {
        return view('pages.projects', [
            'pageTitle' => 'Projects',
            'projects' => $projectStore->all(),
            'siteLikeSummary' => $siteLikeStore->summary(),
        ]);
    }

    public function contact(FortoSiteLikeStore $siteLikeStore): View
    {
        return view('pages.contact', [
            'pageTitle' => 'Contact',
            'contact' => config('forto.contact'),
            'siteLikeSummary' => $siteLikeStore->summary(),
        ]);
    }

    public function skills(FortoSiteLikeStore $siteLikeStore, FortoSkillStore $skillStore): View
    {
        return view('pages.skills', [
            'pageTitle' => 'Skills',
            'skills' => $skillStore->all(),
            'siteLikeSummary' => $siteLikeStore->summary(),
        ]);
    }

    public function community(FortoSiteLikeStore $siteLikeStore, FortoVisitorStore $visitorStore): View
    {
        return view('pages.community', [
            'pageTitle' => 'Community',
            'siteLikeSummary' => $siteLikeStore->summary(),
            'visitorSummary' => $visitorStore->summary(),
            'likes' => $siteLikeStore->all(),
            'visitors' => $visitorStore->all(),
        ]);
    }

    public function dashboard(
        FortoProjectStore $projectStore,
        FortoVisitorStore $visitorStore,
        FortoSkillStore $skillStore,
    ): View
    {
        return view('pages.dashboard', [
            'pageTitle' => 'Dashboard',
            'projects' => $projectStore->all(),
            'skills' => $skillStore->all(),
            'visitors' => $visitorStore->all(),
            'admin' => request()->session()->get('forto_admin'),
        ]);
    }
}
