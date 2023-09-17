<?php

namespace App\Http\Controllers\Backend\Admin;
use App\Http\Controllers\Controller;
use App\Models\SeoOperation;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Http\Requests\Backend\Seo\UpdateSeoOperationsFormRequest;
use Illuminate\Support\Facades\File;

class SeoOperationsController extends Controller
{

    public function index(Request $request,Route $route)
    {
        try {

           $operations = SeoOperation::select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.seo_operations.index', compact('operations'));

      //  $operations = new SeoOperation();
     //    $operations = $operations->where($id)->select('*')->orderBy('created_at', 'asc')->get();
          // return view('admin.seo_operations.index', compact('operations'));


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
            $operations = SeoOperation::find($id);
            if ($operations) {
                return view('admin.seo_operations.edit', compact('operations'));
            } else {
                return redirect()->route('super_admin.seo_operations-index')->with('danger', 'This record is not in the records');
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


    public function update($id,UpdateSeoOperationsFormRequest $request, Route $route)
    {
        try {
            $operations = SeoOperation::find($id);
            if ($operations) {
                // General Updated Data :
                $update_data = [
                    'seo_title_ar'=> $request->seo_title_ar,
                    'seo_title_en'=> $request->seo_title_en,
                    'keywords_ar'=>$request->keywords_ar,
                    'keywords_en'=>$request->keywords_en,
                    'meta_desc_ar' => $request->meta_desc_ar,
                    'meta_desc_en' => $request->meta_desc_en,
                ];


                DB::transaction(function () use ($update_data, $id) {
                    SeoOperation::find($id)->update($update_data);
                });
                return redirect()->back()->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.seo_operations-index')->with('danger', 'This record does not exist in the records');
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
