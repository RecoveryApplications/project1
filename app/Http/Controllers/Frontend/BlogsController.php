<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Traits\SharedMethod;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\Product;
use App\Models\SeoOperation;
use Illuminate\Support\Facades\Config;

class BlogsController extends Controller
{
    use SharedMethod;


    public function index()
    {
        $blogs = Blogs::select('*')->orderBy('created_at', 'asc')->paginate(8);
        $recent_blogs = Blogs::latest()->limit(6)->get();
        $seo_operation = SeoOperation::where('page_name', 'Blogs')->get()->first();
        
        return view('front_end_inners.blog-archive', compact('blogs', 'seo_operation' , 'recent_blogs'));
    }
    public function view($aliasname)
    {
        if (Config::get('app.locale') == 'en') {
            $blog = Blogs::with(['user'])->where('slug_en', '=', $aliasname)->get()->first();
        } else {
            $blog = Blogs::with(['user'])->where('slug_ar', '=', $aliasname)->get()->first();
        }
        if($blog) {
            $recent_blogs = Blogs::latest()->where('id', '!=', $blog->id)->limit(6)->get();


            return view('front_end_inners.blog-single', compact('blog', 'recent_blogs'));
        } else {
            return redirect()->back()->with('danger', 'Blog Not Found !!!');
        }

    }

}
