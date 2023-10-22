<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentWalletOrder;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class RequestedWalletOrders extends Controller
{
    public function index(Route $route, $status = 'pending')
    {
        try {
            $orders = PaymentWalletOrder::with(['customer', 'payment_wallet'])->where('status', $status)->get();
            return view('admin.wallet.Withdrawals.index', compact('orders', 'status'));
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


    public function pay(Route $route, Request $request, $id)
    {
        try {
            $order = PaymentWalletOrder::with(['customer'])->find($id);
            if (!$order) {
                return redirect()->back()->with('error', 'Order Not Found');
            }

            $wallet = $order->customer->wallet;
            if (!$wallet) {
                return redirect()->back()->with('error', 'Customer Wallet Not Found');
            }

            if ($wallet->ballance < $order->amount) {
                return redirect()->back()->with('error', 'Customer Wallet Ballance Is Less Than Order Amount');
            }

            $order->status = 'paid';
            $order->save();
            $wallet->update([
                'ballance' => $wallet->ballance - $order->amount,
                'requested_ballance' => 0,
                'amount_withdrawn' => $wallet->amount_withdrawn + $order->amount,
            ]);

            return redirect()->back()->with('success', 'Order Paid Successfully');
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


    public function reject(Route $route, Request $request, $id)
    {
        try {
            $order = PaymentWalletOrder::with(['customer'])->find($id);
            if (!$order) {
                return redirect()->back()->with('error', 'Order Not Found');
            }
            $order->status = 'rejected';
            $order->save();

            $order->customer->wallet->update([
                'requested_ballance' => 0,
            ]);

            return redirect()->back()->with('success', 'Order Rejected Successfully');
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
