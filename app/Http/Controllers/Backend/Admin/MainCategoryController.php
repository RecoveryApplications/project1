<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MainCategories\StoreMainCategoryFormRequest;
use App\Http\Requests\Backend\MainCategories\UpdateMainCategoryFormRequest;
use App\Models\MainCategory;
use App\Models\SuperCategory;
use App\Models\SupportTicket;
use App\Traits\SharedMethod;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MainCategoryController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {
            $mainCategories = new MainCategory();
            $mainCategories = $mainCategories->select('*')->orderBy('created_at','asc')->paginate(100);
            return view('admin.main_categories.index', compact('mainCategories'));
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
    // ======================= Create Function ========================
    // ================================================================
    public function create(Route $route)
    {
        try {

            // $super_categories = SuperCategory::get();

            return view('admin.main_categories.create');
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
    // ======================= Store Function =========================
    // ================================================================
    public function store(Request $request, Route $route)
    {
        try {

            // Upload Image Section :
            if (isset($request->image)) {
                $orginal_image = $request->file('image');
                $upload_location = 'storage/main_categories/';
                $original_name = $orginal_image->getClientOriginalName();
                $last_image = $this->saveFileWithOriginalName('main_categories', 'image', $orginal_image, $original_name, $upload_location);
            } else {
                $last_image = null;
            }

            $created_data = [
                // 'super_category_id'=>$request->super_category_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'status' => $request->status,
                'image' => $last_image,
                'slug_ar' => $this->generateSlugAr($request->name_ar),
                'slug_en' => $this->generateSlugEn($request->name_en),
                'seo_title_ar'=> $request->seo_title_ar,
                'seo_title_en'=> $request->seo_title_en,
                'keywords_ar'=> $request->keywords_ar,
                'keywords_en'=> $request->keywords_en,
                'meta_desc_ar' => $request->meta_desc_ar,
                'meta_desc_en' => $request->meta_desc_en,
                'tags' => $request->tags,
                'updated_by' => auth()->user()->id,
            ];
            // return $created_data;

            DB::transaction(function () use ($created_data) {
                MainCategory::create($created_data);
            });

            return redirect()->route('super_admin.mainCategories-index')->with('success', 'The data has been successfully updated');
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
    // ======================== Edit Function =========================
    // ================================================================
    public function edit($mainCategory_id, Route $route)
    {
        try {
            $mainCategory = MainCategory::find($mainCategory_id);
            if ($mainCategory) {
                // $super_categories = SuperCategory::get();
                return view('admin.main_categories.edit', compact('mainCategory'));
            } else {
                return redirect()->route('super_admin.mainCategories-index')->with('danger', 'This record is not in the records');
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
    // ======================= Update Function ========================
    // ================================================================
    public function update($mainCategory_id, UpdateMainCategoryFormRequest $request, Route $route)
    {
        try {
            $mainCategory = MainCategory::find($mainCategory_id);

            if ($mainCategory) {
                // Standard Updated Data :
                // $update_data['super_category_id'] = $request->super_category_id;
                $update_data['name_en'] = $request->name_en;
                $update_data['name_ar'] = $request->name_ar;
                $update_data['status'] = $request->status;
                $update_data['slug_ar'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->name_ar);
                $update_data['slug_en'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->name_en);
                $update_data['seo_title_ar'] = $request->seo_title_ar;
                $update_data['seo_title_en'] = $request->seo_title_en;
                $update_data['keywords_ar'] = $request->keywords_ar;
                $update_data['keywords_en'] = $request->keywords_en;
                $update_data['meta_desc_ar'] = $request->meta_desc_ar;
                $update_data['meta_desc_en'] = $request->meta_desc_en;
                $update_data['updated_by'] = auth()->user()->id;

                // Upload Image Section :
                if (isset($request->image)) {
                    $orginal_image = $request->file('image');
                    $upload_location = 'storage/main_categories/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['image'] = $this->saveFileWithOriginalName('main_categories', 'image', $orginal_image, $original_name, $upload_location);
                    File::delete($mainCategory->image);
                }

                DB::table('main_categories')->where('id', $mainCategory_id)->update($update_data);

                return redirect()->route('super_admin.mainCategories-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.mainCategories-index')->with('danger', 'This record does not exist in the records');
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
    public function activeInactiveSingle($mainCategory_id, Route $route)
    {
        try {
            $mainCategory = MainCategory::find($mainCategory_id);
            if ($mainCategory) {
                if ($mainCategory->status == 1) {
                    $mainCategory->status = 2;  // 2 => Inactive
                    $mainCategory->save();
                } elseif ($mainCategory->status == 2) {
                    $mainCategory->status = 1;  // 1 => Active
                    $mainCategory->save();
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

    // ================================================================
    // ===================== Soft Delete Function =====================
    // ================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $mainCategory = MainCategory::find($id);
            if ($mainCategory) {
                DB::transaction(function () use ($mainCategory) {
                    $mainCategory->delete();
                });
                return redirect()->route('super_admin.mainCategories-index')->with('success', 'The deletion process has been successful');
            } else {
                return redirect()->route('super_admin.mainCategories-index')->with('danger', 'This record is not in the records');
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
    // ====================== Show Soft Delete ========================
    // ================================================================
    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $mainCategories = new MainCategory();
            $mainCategories = $mainCategories->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.main_categories.trashed', compact('mainCategories'));
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
    // ===================== Soft Delete Restore ======================
    // ================================================================
    public function softDeleteRestore($id, Route $route)
    {
        try {
            $mainCategories = MainCategory::onlyTrashed()->find($id);
            if ($mainCategories) {
                $mainCategories->restore();
                return redirect()->route('super_admin.mainCategories-index')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->route('super_admin.mainCategories-index')->with('danger', 'This section does not exist in the records');
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
    // ===================== Destroy Function =========================
    // ================================================================
    public function destroy($mainCategory_id, Route $route)
    {
        try {
            $mainCategory = MainCategory::where('id', $mainCategory_id)->withTrashed()->get()->first();
            if ($mainCategory) {
                File::delete($mainCategory->image);
                $mainCategory->forceDelete();
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
           $old = MainCategory::where('slug_ar','like', '%' . $slug . '%')->first();
           if($old){
               $max = MainCategory::where('slug_ar','like', '%' . $slug . '%')->count();
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

           $old = MainCategory::where('slug_en','like', '%' . $slug . '%')->first();
           if($old){
               $max =  MainCategory::where('slug_en','like', '%' . $slug . '%')->count();
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
