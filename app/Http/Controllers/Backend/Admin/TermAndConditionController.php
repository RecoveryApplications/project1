<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TermAndConditions\StoreTermAndConditionFormRequest;
use App\Http\Requests\Backend\TermAndConditions\UpdateTermAndConditionFormRequest;
use Illuminate\Http\Request;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Models\SupportTicket;
use App\Models\TermAndCondition;
use App\Traits\SharedMethod;
use Illuminate\Support\Facades\File;

class TermAndConditionController extends Controller
{
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {
            $term_and_conditions = new TermAndCondition();
            $term_and_conditions = $term_and_conditions->select('*')->orderBy('created_at', 'asc')->get();

            return view('admin.term_and_conditions.index', compact('term_and_conditions'));
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
            return view('admin.term_and_conditions.create');
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
            $created_data = [
                'term_and_condition_title_en' => $request->term_and_condition_title_en,
                // 'term_and_condition_status' => $request->term_and_condition_status,
                'term_and_condition_des_en' => $request->term_and_condition_des_en,
            ];

            DB::transaction(function () use ($created_data) {
                $base = TermAndCondition::create($created_data);
            });

            return redirect()->route('super_admin.term_and_conditions-index')->with('success', 'Data has been added successfully');
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
    // ======================== show Function =========================
    // ================================================================
    public function show($id, Route $route)
    {
        try {
            $term_and_condition = TermAndCondition::find($id);
            if ($term_and_condition) {
                return view('admin.term_and_conditions.show', compact('term_and_condition'));
            } else {
                return redirect()->route('super_admin.term_and_conditions-index')->with('danger', 'This record is not in the records');
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
    // ======================== Edit Function =========================
    // ================================================================
    public function edit($id, Route $route)
    {
        try {
            $term_and_condition = TermAndCondition::find($id);
            if ($term_and_condition) {
                return view('admin.term_and_conditions.edit', compact('term_and_condition'));
            } else {
                return redirect()->route('super_admin.term_and_conditions-index')->with('danger', 'This record is not in the records');
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
    public function update($id,Request $request, Route $route)
    {
        try {
            $term_and_condition = TermAndCondition::find($id);
            if ($term_and_condition) {
                // General Updated Data :
                $update_data = [
                    'term_and_condition_title_en' => $request->term_and_condition_title_en,
                    // 'term_and_condition_status' => $request->term_and_condition_status,
                    'term_and_condition_des_en' => $request->term_and_condition_des_en,
                ];
                DB::transaction(function () use ($update_data, $id) {
                    DB::table('term_and_conditions')->where('id', $id)->update($update_data);
                });
                return redirect()->route('super_admin.term_and_conditions-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.term_and_conditions-index')->with('danger', 'This record does not exist in the records');
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
    // ======================== softDelete Function ===================
    // ================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $term_and_condition = TermAndCondition::find($id);
            if ($term_and_condition) {
                DB::transaction(function () use ($term_and_condition) {
                    $term_and_condition->delete();
                });
                return redirect()->route('super_admin.term_and_conditions-index')->with('success', 'The deletion process has been successful');
            } else {
                return redirect()->route('super_admin.term_and_conditions-index')->with('danger', 'This record is not in the records');
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
            $term_and_conditions = new TermAndCondition();
            $term_and_conditions = $term_and_conditions->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.term_and_conditions.trashed', compact('term_and_conditions'));
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
            $term_and_condition = TermAndCondition::onlyTrashed()->find($id);
            if ($term_and_condition) {
                DB::transaction(function () use ($term_and_condition) {
                    $term_and_condition->restore();
                });
                return redirect()->route('super_admin.term_and_conditions-index')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->route('super_admin.term_and_conditions-index')->with('danger', 'This section does not exist in the records');
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
