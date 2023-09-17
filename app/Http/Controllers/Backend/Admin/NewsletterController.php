<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Faq;
use App\Mail\NewsLetterEmail;
use App\Models\Customer;
use App\Models\Newsletter;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Backend\Faqs\StoreFaqFormRequest;
use App\Http\Requests\Backend\Faqs\UpdateFaqFormRequest;

class NewsletterController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {

            $customers = Customer::select('*')->orderBy('created_at', 'asc')->get();

            return view('admin.news_letter.create', compact('customers'));
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
    // ======================== sendEmail Function ========================
    // ================================================================
    public function sendEmail(Request $request, Route $route)
    {
        $request->validate([
            'title'=>'required',
            'body'=>'required',
            'customer_id'=>'required',
        ]);
        try {

            $newsLetters=NewsLetter::whereIn('id',explode(',',$request->customer_id))->get();

            foreach($newsLetters as $newsLetter){
                $newsLetter->title=$request->title;
                $newsLetter->body=$request->body;
                Mail::to($newsLetter->email)->send(new NewsLetterEmail($newsLetter));

            }
            return redirect()->back()->with('success', 'Send Email Successfully');

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
