<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Traits\SharedMethod;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use App\Models\SeoOperation;

class BlogsController extends Controller
{
    use SharedMethod;


    public function Blogs()
    {
        $blogs=Blogs::select('*')->orderBy('created_at', 'asc')->paginate(9);


        $seo_operation = SeoOperation::where('page_name', 'Blogs')->get()->first();
        return view('front_end_inners.blog-archive',compact('blogs','seo_operation'));
    }
}
