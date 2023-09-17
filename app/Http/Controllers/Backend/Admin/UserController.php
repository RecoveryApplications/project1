<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Users\StoreUserFormRequest;
use App\Http\Requests\Backend\Users\UpdateUserFormRequest;
use App\Models\Customer;
use App\Models\SupportTicket;
use App\Traits\UploadImageTrait;
use App\Traits\SharedMethod;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {
            $users = new User();
            $users = $users->select('*')->orderBy('created_at', 'asc')->get();

            $customers = new Customer();
            $customers = $customers->select('*')->orderBy('created_at', 'asc')->get();

            return view('admin.users.index', compact('users', 'customers'));
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
            return view('admin.users.create');
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
    public function store(StoreUserFormRequest $request, Route $route)
    {
        try {

            // Upload Image Section :
            if (isset($request->profile_photo_path)) {
                $orginal_image = $request->file('profile_photo_path');
                $upload_location = 'storage/profile-photos/';
                $original_name = $orginal_image->getClientOriginalName();
                if ($request->user_type == 'Super Admin') {
                    $last_image = $this->saveFileWithOriginalName('users', 'profile_photo_path', $orginal_image, $original_name, $upload_location);
                } else {
                    $last_image = $this->saveFileWithOriginalName('customers', 'profile_photo_path', $orginal_image, $original_name, $upload_location);
                }
            } else {
                $last_image = null;
            }

            $created_data = [
                'name_en' => $request->name_en,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'user_type' => $request->user_type,
                'user_status' => $request->user_status,
                'profile_photo_path' => $last_image,
                'created_by' => auth()->user()->id,
            ];

            DB::transaction(function () use ($created_data) {
                // Save Main User Information Section :
                // =====================================================================
                if ($created_data['user_type'] == 'Super Admin') {
                    User::create($created_data);
                } elseif ($created_data['user_type'] == 'Customer') {
                    Customer::create($created_data);
                }
            });

            return redirect()->route('super_admin.users-index')->with('success', 'The data has been successfully updated');
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
    // ======================== Show Function =========================
    // ================================================================
    public function show($user_id, $user_type, Route $route)
    {
        try {
            if ($user_type == 'Super Admin') {
                $user = User::find($user_id);
            } elseif ($user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }
            if ($user) {
                $user['user_type'] = $user_type;
                return view('admin.users.show', compact('user'));
            } else {
                return redirect()->route('super_admin.users-index')->with('danger', 'This record number is not in the records');
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
    public function edit($user_id, $user_type, Route $route)
    {
        try {
            if ($user_type == 'Super Admin') {
                $user = User::find($user_id);
            } elseif ($user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }

            if ($user) {
                $user['user_type'] = $user_type;
                return view('admin.users.edit', compact('user'));
            } else {
                return redirect()->route('super_admin.users-index')->with('danger', 'This record is not in the records');
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
    public function update($user_id, UpdateUserFormRequest $request, Route $route)
    {
        try {
            if ($request->user_type == 'Super Admin') {
                $user = User::find($user_id);
            } elseif ($request->user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }

            if ($user) {
                // Standard Updated Data :
                $update_data['name_en'] = $request->name_en;
                $update_data['username'] = $request->username;
                $update_data['email'] = $request->email;
                $update_data['phone'] = $request->phone;
                $update_data['user_status'] = $request->user_status;

                // Add Password to updated date if exist :
                if (isset($request->password)) {
                    $update_data['password'] = Hash::make($request->password);
                }

                // Upload Image Section :
                if (isset($request->profile_photo_path)) {
                    $orginal_image = $request->file('profile_photo_path');
                    $upload_location = 'storage/profile-photos/';
                    $original_name = $orginal_image->getClientOriginalName();
                    if ($request->user_type == 'Super Admin') {
                        $update_data['profile_photo_path'] = $this->saveFileWithOriginalName('users', 'profile_photo_path', $orginal_image, $original_name, $upload_location);
                    } else {
                        $update_data['profile_photo_path'] = $this->saveFileWithOriginalName('customers', 'profile_photo_path', $orginal_image, $original_name, $upload_location);
                    }
                    File::delete($user->profile_photo_path);
                }

                if ($request->user_type == 'Super Admin') {
                    DB::table('users')->where('id', $user_id)->update($update_data);
                } elseif ($request->user_type == 'Customer') {
                    DB::table('customers')->where('id', $user_id)->update($update_data);
                }

                return redirect()->route('super_admin.users-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.users-index')->with('danger', 'This record does not exist in the records');
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
    // =================== Accept Single User =========================
    // ================================================================
    public function acceptSingle($user_id, $user_type, Route $route)
    {
        try {
            if ($user_type == 'Super Admin') {
                return redirect()->back()->with('danger', 'This action is not allowed on the super admin');
            } elseif ($user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }

            if ($user) {
                if ($user->user_status == 'Pendding') {
                    $user->user_status = 2;  // 2 => Active
                    $user->save();
                    $update_data = $user->toArray();
                    $update_data['user_status'] = 2;
                    return redirect()->back()->with('success', 'The process has successfully');
                } else {
                    return redirect()->back()->with('danger', 'An unexpected error occurred');
                }
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
    // =================== Reject Single User =========================
    // ================================================================
    public function rejectSingle($user_id, $user_type, Route $route)
    {
        try {
            if ($user_type == 'Super Admin') {
                return redirect()->back()->with('danger', 'This action is not allowed on the super admin');
            } elseif ($user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }

            if ($user) {
                if ($user->user_status == 'Pendding') {
                    $user->user_status = 3;  // 3 => Inactive
                    $user->save();
                    $update_data = $user->toArray();
                    $update_data['user_status'] = 3;
                    return redirect()->back()->with('success', 'The process has successfully');
                } else {
                    return redirect()->back()->with('danger', 'An unexpected error occurred');
                }
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
    // =============== Active/Inactive Single User ====================
    // ================================================================
    public function activeInactiveSingle($user_id, $user_type, Route $route)
    {
        try {
            if ($user_type == 'Super Admin') {
                return redirect()->back()->with('danger', 'This action is not allowed on the super admin');
            } elseif ($user_type == 'Customer') {
                $user = Customer::find($user_id);
            } else {
                $user = '';
            }

            if ($user) {
                if ($user->user_status == 'Active') {
                    $user->user_status = 3;  // 3 => Inactive
                    $user->save();
                    $update_data = $user->toArray();
                    $update_data['user_status'] = 3;
                } elseif ($user->user_status == 'Inactive') {
                    $user->user_status = 2;  // 2 => Active
                    $user->save();
                    $update_data = $user->toArray();
                    $update_data['user_status'] = 2;
                } elseif ($user->user_status == 'Pendding') {
                    return redirect()->back()->with('danger', 'This user\'s request is still pending, it must be accepted first');
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
