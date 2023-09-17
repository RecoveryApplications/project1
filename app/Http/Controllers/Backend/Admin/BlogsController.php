<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Blogs;
use Illuminate\Support\Str;
use App\Traits\SharedMethod;
use App\Traits\UploadImageTrait;
use App\Http\Requests\Backend\Blogs\StoreBlogFormRequest;
use App\Http\Requests\Backend\Blogs\UpdateBlogFormRequest;

class BlogsController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    public function index(Route $route)
    {
        try {
            $news_blogs = new Blogs();

            $news_blogs = $news_blogs->select('*')->orderBy('created_at', 'asc')->get();

            return view('admin.Blogs.index', compact('news_blogs',));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function create(Route $route)
    {
        try {
            return view('admin.Blogs.create');
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function store(StoreBlogFormRequest $request, Route $route)
    {
        try {
            // Upload Image Section :
            if (isset($request->image)) {
                $orginal_image = $request->file('image');
                $upload_location = 'storage/blogs/';
                $original_name = $orginal_image->getClientOriginalName();
                $last_image = $this->saveFile($orginal_image, $upload_location);

            } else {
                $last_image = null;
            }

            $created_data = [
                'user_id' => auth()->user()->id,
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'status' => $request->status,
                'desc_ar' => $request->desc_ar,
                'desc_en' => $request->desc_en,
                'slug_ar' => $this->generateSlugAr($request->title_ar),
                'slug_en' => $this->generateSlugEn($request->title_en),
                'image' =>  $last_image,
                'seo_title_ar'=> $request->seo_title_ar,
                'seo_title_en'=> $request->seo_title_en,
                'keywords_ar'=> $request->keywords_ar,
                'keywords_en'=> $request->keywords_en,
                'meta_desc_ar' => $request->meta_desc_ar,
                'meta_desc_en' => $request->meta_desc_en,
                'tags' => $request->tags
            ];

            DB::transaction(function () use ($created_data) {
                Blogs::create($created_data);
            });

            return redirect()->route('super_admin.blogs-index')->with('success', 'The data has been successfully updated');
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();
            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }


    public function show($id, Route $route)
    {
        try {
            $news_blog = Blogs::find($id);

            if ($news_blog) {
                // return $news_blog;
                return view('admin.Blogs.show', compact('news_blog'));
            } else {
                return redirect()->route('super_admin.blogs-index')->with('danger', 'This record is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }


    public function edit($id, Route $route)
    {
        try {
            $news_blog = Blogs::find($id);
            if ($news_blog) {
                return view('admin.Blogs.edit', compact('news_blog'));
            } else {
                return redirect()->route('super_admin.blogs-index')->with('danger', 'This record is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function update($id, UpdateBlogFormRequest $request, Route $route)
    {
        try {
            $news_blog = Blogs::find($id);

            if ($news_blog) {
                // Standard Updated Data :
                $update_data['title_ar'] = $request->title_ar;
                $update_data['title_en'] = $request->title_en;
                $update_data['status'] = $request->status;
                $update_data['desc_ar'] = $request->desc_ar;
                $update_data['desc_en'] = $request->desc_en;
                $update_data['slug_ar'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->title_ar);
                $update_data['slug_en'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->title_en);
                $update_data['seo_title_ar'] = $request->seo_title_ar;
                $update_data['seo_title_en'] = $request->seo_title_en;
                $update_data['keywords_ar'] = $request->keywords_ar;
                $update_data['keywords_en'] = $request->keywords_en;
                $update_data['meta_desc_ar'] = $request->meta_desc_ar;
                $update_data['meta_desc_en'] = $request->meta_desc_en;

                // Upload Image Section :
                if (isset($request->image)) {
                    $orginal_image = $request->file('image');
                    $upload_location = 'storage/blogs/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['image'] = $this->saveFile($orginal_image, $upload_location);
                    // $update_data['image'] = $this->saveFileWithCompression('sliders', 'image', $orginal_image, $original_name, $upload_location);
                    File::delete($news_blog->image);
                }

                DB::table('blogs')->where('id', $id)->update($update_data);

                return redirect()->route('super_admin.blogs-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.blogs-index')->with('danger', 'This record does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function softDelete($id, Route $route)
    {
        try {
            $news_blog = Blogs::find($id);
            if ($news_blog) {
                DB::transaction(function () use ($news_blog) {
                    $news_blog->delete();
                });
                return redirect()->route('super_admin.blogs-index')->with('success', 'The deletion process has been successful');
            } else {
                return redirect()->route('super_admin.blogs-index')->with('danger', 'This record is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $news_blogs = new Blogs();
            $news_blogs = $news_blogs->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            // return $news_blogs;
            return view('admin.Blogs.trashed', compact(
                'news_blogs',
            ));
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function softDeleteRestore($id, Route $route)
    {
        try {
            $news_blog = Blogs::onlyTrashed()->find($id);
            if ($news_blog) {
                DB::transaction(function () use ($news_blog) {
                    $news_blog->restore();
                });
                return redirect()->route('super_admin.blogs-index')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->route('super_admin.blogs-index')->with('danger', 'This section does not exist in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

    public function destroy($id, Route $route)
    {
        try {
            $news_blog = Blogs::where('id', $id)->withTrashed()->get()->first();
            if ($news_blog) {
                File::delete($news_blog->image);
                $news_blog->forceDelete();
                return redirect()->back()->with('success', 'The process has successfully');
            } else {
                return redirect()->back()->with('danger', 'This record is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }

     // ================================================================
    // ================== Active/Inactive Single ======================
    // ================================================================
    public function activeInactiveSingle($id, Route $route)
    {
        try {
            $news_blog = Blogs::find($id);
            if ($news_blog) {
                if ($news_blog->status == 'Active') {
                    $news_blog->status = 2;  // 2 => Inactive
                    $news_blog->save();
                } elseif ($news_blog->status == 'Inactive') {
                    $news_blog->status = 1;  // 1 => Active
                    $news_blog->save();
                }
                return redirect()->back()->with('success', 'The process has successfully');
            } else {
                return redirect()->back()->with('danger', 'This record is not in the records');
            }
        } catch (\Throwable $th) {
            $function_name =  $route->getActionName();
            $check_old_errors = new SupportTicket();
            $check_old_errors = $check_old_errors->select('*')->where([
                'error_location' => $th->getFile(),
                'error_description' => $th->getMessage(),
                'function_name' => $function_name,
                'error_line' => $th->getLine(),
            ])->get();

            if ($check_old_errors->count() == 0) {
                $new_error_ticket = SupportTicket::create([
                    'error_location' => $th->getFile(),
                    'error_description' => $th->getMessage(),
                    'function_name' => $function_name,
                    'error_line' =>  $th->getLine(),
                ]);
                $end_error_ticket = $new_error_ticket;
            } else {
                $end_error_ticket = $check_old_errors->first();
            }
            return view('errors.support_tickets', compact('th', 'function_name', 'end_error_ticket'));
        }
    }






    // Generate Slugs
    private function generateSlugAr($name)
    {
        $slug = str_replace(array(' ', '"', '>', '<', '#', '%', '|', '/'), '-',$name);

        $count = 0;
        $old = Blogs::where('slug_ar','like', '%' . $slug . '%')->first();
        if($old){
            $max = Blogs::where('slug_ar','like', '%' . $slug . '%')->count();
            if (isset($max) && is_numeric($max)) {
                $count = $max + 1;
            }
        }
        if($count == 0){
            return $slug;
        }else{
            return $slug.'-'.$count;
        }
    }

    private function generateSlugEn($name)
    {
        $slug = str_replace(array(' ', '"', '>', '<', '#', '%', '|', '/'), '-',$name);
        $count = 0;

        $old = Blogs::where('slug_en','like', '%' . $slug . '%')->first();
        if($old){
            $max =  Blogs::where('slug_en','like', '%' . $slug . '%')->count();
            if (isset($max) && is_numeric($max)) {
                $count = $max + 1;
            }
        }

        if($count == 0){
            return $slug;
        }else{
            return $slug.'-'.$count;
        }
    }





}

