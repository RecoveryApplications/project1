<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Traits\SharedMethod;
use App\Http\Controllers\Controller;
use App\Models\Blogs;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;

class BlogDetailsController extends Controller
{
    use SharedMethod;


    public function BlogDetails(Route $route,$aliasname)
    {
        if (Config::get('app.locale') == 'en'){
            $news_blog = Blogs::where('slug_en','=',$aliasname)->get()->first();
        }else{
            $news_blog = Blogs::where('slug_ar','=',$aliasname)->get()->first();
        }

        if($news_blog){
            $popular_blogs=Blogs::latest()->where('id','!=',$news_blog->id)->limit(6)->get();


            return view('front_end_inners.blog-single',compact('news_blog','popular_blogs'));
        }else{
            return redirect()->back()->with('danger','Blog Not Found !!!');
        }

    }


}
