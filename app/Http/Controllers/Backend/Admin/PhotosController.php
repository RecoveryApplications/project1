<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Photo;
use App\Models\ProductImage;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class PhotosController extends Controller
{


    use UploadImageTrait;
    use SharedMethod;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.photos.index')->with('photos',Photo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Route $route)
    {
        try {
            // Upload Image :
            if (isset($request->product_other_images)) {
                $request_data = [];
                foreach ($request->product_other_images as $key => $value) {
                    $orginal_image = $value;
                    $upload_location = 'storage/other_images/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $request_data['name_img'] = $this->saveFileWithOriginalName('photos', 'name_img', $orginal_image, $original_name, $upload_location);
                    DB::transaction(function () use ($request_data) {
                        Photo::create($request_data);
                    });
                }
            } else {
                return redirect()->back()->with('danger', 'You must add an ImageS');
            }
            return redirect()->back()->with('success', 'The data has been successfully Added');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Route $route)
    {
         try {
            $image = Photo::findOrFail($id);
            if ($image) {
                DB::transaction(function () use ($image) {
                    $image->delete();
                    File::delete($image->image);
                });
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
