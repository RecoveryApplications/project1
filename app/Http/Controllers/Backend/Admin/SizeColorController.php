<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Colors\ColorsStorFromRequest;
use App\Http\Requests\Backend\Sizes\SizesStorFromRequest;
use App\Models\MainColor;
use App\Models\MainSize;
use App\Models\SupportTicket;
use App\Traits\GeneralTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class SizeColorController extends Controller
{

    use GeneralTrait;
    use UploadImageTrait;
    // =======================================================================================
    // ============================= Colors Index Function ===================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function colorIndex(Route $route){
        try {

            $colors = MainColor::get();
            return view('admin.color_size.colorIndex',compact('colors'));

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

    // =======================================================================================
    // ============================= colors Store Function ===================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function colorStore(SizesStorFromRequest $request,Route $route){
        try {
              // return $request;
        $image = null;

        // Upload Image Section :
        if (isset($request->image)) {
            $orginal_image = $request->file('image');
            $upload_location = 'storage/colors/';
            $original_name = $orginal_image->getClientOriginalName();
            $image = $this->saveFileWithOriginalName('main_colors', 'image', $orginal_image, $original_name, $upload_location);
        } else {
            $image = null;
        }

            $created_data = [
                'name_en'=>$request->name_en,
                'color_code'=>$request->color_code,
                'image' => $image,
                'updated_by'=>auth()->user()->id,
            ];

            MainColor::create($created_data);

            return redirect()->back()->with('success','Added Successfully');

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


    // =======================================================================================
    // ============================= colors Update Ajax Function =============================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function colorUpdate(Request $request){

        // return $request;

        $request->validate([
            'color_id'=>'required|numeric',
            'color_name_en'=>'required|not_in:undefined|unique:main_colors,name_en,'.$request->color_id,
            'color_code'=>'required|not_in:undefined|unique:main_colors,color_code,'.$request->color_id
        ]);

        $color = MainColor::find($request->color_id);

        if($color){
            $color->update([
                'name_en'=>$request->color_name_en,
                'color_code'=>$request->color_code,
                'updated_by'=>auth()->user()->id
            ]);

            return response()->json(['status'=>true]);
        }
        else{

            return response()->json(['status'=>false,'msg'=>'This Record Not Found']);
        }

    }

    // =======================================================================================
    // ============================= colors Destroy Function =================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function colorDestroy($id,Route $route){

        try {
        $color = MainColor::find($id);
            if($color){
                $color->delete();
                return redirect()->back()->with('success','Deleted Successfully');
            }
            else{
                return redirect()->back()->with('danger','The Record Not Found');
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

    // =======================================================================================
    // ============================== Sizes Index Function ===================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function sizeIndex(Route $route){
        try {

            $sizes = MainSize::get();
            return view('admin.color_size.sizeIndex',compact('sizes'));

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

    // =======================================================================================
    // ============================= Sizes Store Function ====================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function SizeStore(SizesStorFromRequest $request,Route $route){
        try {

            $created_data = [
                'name_en'=>$request->name_en,
                'updated_by'=>auth()->user()->id,
            ];

            MainSize::create($created_data);

            return redirect()->back()->with('success','Added Successfully');

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


    // =======================================================================================
    // ============================= Sizes  Update Ajax Function =============================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function sizeUpdate(Request $request){

        // return $request;

        $request->validate([
            'size_id'=>'required|numeric',
            'size_name_en'=>'required|not_in:undefined|unique:main_sizes,name_en,'.$request->size_id,
        ]);

        $size = MainSize::find($request->size_id);

        if($size){
            $size->update([
                'name_en'=>$request->size_name_en,
                'updated_by'=>auth()->user()->id
            ]);

            return response()->json(['status'=>true]);
        }
        else{

            return response()->json(['status'=>false,'msg'=>'This Record Not Found']);
        }

    }

    // =======================================================================================
    // ============================= Sizes  Destroy Function =================================
    // ============================= By : Mohammed Salah =====================================
    // =======================================================================================
    function sizeDestroy($id,Route $route){

        try {
        $size = MainSize::find($id);
            if($size){
                $size->delete();
                return redirect()->back()->with('success','Deleted Successfully');
            }
            else{
                return redirect()->back()->with('danger','The Record Not Found');
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
