<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Photo;
use App\Models\SeoOperation;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function __invoke()
    {
        $photos = Photo::get();
        $about_us = AboutUs::all()->first();
        $seo_operation = SeoOperation::where('page_name', 'About Us')->get()->first();
        return view('front_end_inners.about_us' , compact('photos', 'about_us', 'seo_operation'));
    }
}
