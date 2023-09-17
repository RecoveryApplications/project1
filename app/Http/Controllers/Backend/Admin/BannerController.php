<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\AboutUs\UpdateAboutUsRequest;
use App\Http\Requests\Backend\Banner\StoreBannerFormRequest;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\File;


class BannerController extends Controller
{
    use UploadImageTrait;
    public function index(Request $request, Route $route)
    {
        try {
            $banners = new Banner();

            $banners = $banners->select('*')->orderBy('created_at', 'asc')->get();

            return view('admin.banner.index', compact('banners'));
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


    public function edit($id,Request $request, Route $route)
    {
        try {
            $banner = Banner::find($id);
            return view('admin.banner.edit', compact('banner'));
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

    public function update($id, Request $request,  Route $route)
    {
        try {
            // return $request;
            $banner = Banner::find($id);
            if ($banner) {
                $update_data = [
                    'title' => $request->title,
                    'page' => $request->page,
                    'status' => $request->status,

                ];
                  // Upload Image Section :
                  if (isset($request->image)) {
                    $orginal_image = $request->file('image');
                    $upload_location = 'storage/banners/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['image'] = $this->saveFile($orginal_image, $upload_location);
                    // $update_data['image'] = $this->saveFileWithCompression('sliders', 'image', $orginal_image, $original_name, $upload_location);
                    File::delete($banner->image);
                }
                // return "FOOOOOOO";

                DB::transaction(function () use ($update_data, $banner) {

                    $banner->update($update_data);
                });
                return redirect()->route('super_admin.banners-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.banners-index')->with('danger', 'This record does not exist in the records');
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

    public function create(Route $route)
    {
        try {
            return view('admin.banner.create');
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

    public function store(StoreBannerFormRequest $request, Route $route)
    {
        try {
             // Upload Image Section :
             if (isset($request->image)) {
                $orginal_image = $request->file('image');
                $upload_location = 'storage/banners/';
                $original_name = $orginal_image->getClientOriginalName();
                $last_image = $this->saveFile($orginal_image, $upload_location);

            } else {
                $last_image = null;
            }

            $created_data = [
                'title' => $request->title,
                'page' => $request->page,
                'status' => $request->status,
                'image' =>  $last_image,
            ];

            DB::transaction(function () use ($created_data) {
                Banner::create($created_data);
            });

            return redirect()->route('super_admin.banners-index')->with('success', 'The data has been successfully updated');
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
            $banner = Banner::find($id);

            if ($banner) {
                // return $news_blog;
                return view('admin.banner.show', compact('banner'));
            } else {
                return redirect()->route('super_admin.banners-index')->with('danger', 'This record is not in the records');
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
            $banners = Banner::find($id);
            if ($banners) {
                DB::transaction(function () use ($banners) {
                    $banners->delete();
                });
                return redirect()->route('super_admin.banners-index')->with('success', 'The deletion process has been successful');
            } else {
                return redirect()->route('super_admin.banners-index')->with('danger', 'This record is not in the records');
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
            $banners = new Banner();
            $banners = $banners->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            // return $news_blogs;
            return view('admin.banner.trashed', compact(
                'banners',
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
            $banners = Banner::onlyTrashed()->find($id);
            if ($banners) {
                DB::transaction(function () use ($banners) {
                    $banners->restore();
                });
                return redirect()->route('super_admin.banners-index')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->route('super_admin.banners-index')->with('danger', 'This section does not exist in the records');
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
            $banners = Banner::where('id', $id)->withTrashed()->get()->first();
            if ($banners) {
                File::delete($banners->image);
                $banners->forceDelete();
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
            $banners = Banner::find($id);
            if ($banners) {
                if ($banners->status == '1') {
                    $banners->status = 2;  // 2 => Inactive
                    $banners->save();
                } elseif ($banners->status == '2') {
                    $banners->status = 1;  // 1 => Active
                    $banners->save();
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

}
