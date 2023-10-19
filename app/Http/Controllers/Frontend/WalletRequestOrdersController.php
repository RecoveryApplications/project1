<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaymentWallet;
use App\Models\PaymentWalletOrder;
use App\Models\SupportTicket;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class WalletRequestOrdersController extends Controller
{
    public function store(Request $request, Route $route)
    {
        $request->validate([
            'payment_wallet_id' => 'required|exists:payment_wallets,id',
            'amount' => 'required|numeric|min:1',
            'phone' => 'required|numeric',
        ]);

        try {

            $customer = auth('customer')->user();
            $wallet = $customer->wallet;
            if (auth('customer')->check()) {
                $payment_wallet = PaymentWallet::find($request->payment_wallet_id);
                if (!$wallet) {
                    $new_wallet = Wallet::create([
                        'customer_id' => $customer->id,
                        'ballance' => 0,
                        'requested_ballance' => 0,
                    ]);
                    $wallet = $new_wallet;
                }
                if ($wallet->ballance >= $request->amount) {
                    if ($payment_wallet->status == 'active') {
                        if ($wallet->requested_ballance == 0) {
                            $new_payment_wallet_order = PaymentWalletOrder::create([
                                'customer_id' => $customer->id,
                                'payment_wallet_id' => $request->payment_wallet_id,
                                'amount' => $request->amount,
                                'phone' => $request->phone,
                                'status' => 'pending',
                            ]);
                            $wallet->update([
                                'requested_ballance' => $request->amount,
                            ]);
                            return redirect()->back()->with('success', 'Your Request Has Been Sent Successfully');
                        } else {
                            return redirect()->back()->with('error', 'You Have A Pending Request');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Sorry, This Payment Wallet Is Not Active');
                    }
                } else {
                    return redirect()->back()->with('error', 'Sorry, You Don\'t Have Enough Ballance');
                }
            } else {
                return redirect()->back()->with('error', 'Sorry, You Are Not Allowed To Do This Action');
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
