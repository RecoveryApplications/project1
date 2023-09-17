<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AboutUs\UpdateAboutUsRequest;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\SupportTicket;
use App\Traits\UploadImageTrait;
use App\Traits\SharedMethod;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    use UploadImageTrait;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {
            $about = AboutUs::first();
            return view('admin.about_us.index', compact('about'));
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
    // ======================== edit  Function ========================
    // ================================================================
    public function edit(Request $request, Route $route)
    {
        try {
            $about = AboutUs::first();
            return view('admin.about_us.edit', compact('about'));
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
    public function update(UpdateAboutUsRequest $request,  Route $route)
    {
        try {
            $about = AboutUs::first();
            if ($about) {
                // Validation Section :
                $request->validated();
                // General Updated Data :
                $update_data = [
                    'about_us_en' => $request->about_us_en,
                    'about_us_ar' => $request->about_us_ar,
                    'vision_en' => $request->vision_en,
                    'vision_ar' => $request->vision_ar,
                    'mission_en' => $request->mission_en,
                    'mission_ar' => $request->mission_ar,
                ];
                // Upload about_us_image  :
                if (isset($request->about_us_image)) {
                    $orginal_image = $request->file('about_us_image');
                    $upload_location = 'storage/about_us/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['about_us_image'] = $this->saveFileWithOriginalName('about_us', 'about_us_image', $orginal_image, $original_name, $upload_location);
                }

                // Upload vision_image  :
                if (isset($request->vision_image)) {
                    $orginal_image = $request->file('vision_image');
                    $upload_location = 'storage/vision_image/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['vision_image'] = $this->saveFileWithOriginalName('about_us', 'vision_image', $orginal_image, $original_name, $upload_location);
                }

                // Upload mission_image  :
                if (isset($request->mission_image)) {
                    $orginal_image = $request->file('mission_image');
                    $upload_location = 'storage/mission_image/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['mission_image'] = $this->saveFileWithOriginalName('about_us', 'mission_image', $orginal_image, $original_name, $upload_location);
                }
                DB::transaction(function () use ($update_data, $about) {
                    DB::table('about_us')->where('id', $about->id)->update($update_data);
                });
                return redirect()->route('super_admin.about_us-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.about_us-index')->with('danger', 'This record does not exist in the records');
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
