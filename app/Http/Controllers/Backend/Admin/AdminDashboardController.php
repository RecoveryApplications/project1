<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartSale;
use App\Models\Company;
use App\Models\ContactUsRequest;
use App\Models\Customer;
use App\Models\GeneralInstruction;
use App\Models\Individual;
use App\Models\JobInterviewTip;
use App\Models\JobSection;
use App\Models\NewsBlog;
use App\Models\Product;
use App\Models\Profession;
use App\Models\ProjectIdea;
use App\Models\PublicServiceSection;
use App\Models\Specialty;
use App\Models\User;


class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        $stopedCustomers = Customer::where('user_status', 3)->orderBy('created_at', 'asc')->get(); // 3 => Stop
        $CartSales = CartSale::orderBy('created_at', 'desc')->get();
        $penddingCartSales = CartSale::where('status', 1)->orderBy('created_at', 'desc')->get(); // 1 => Pendding
        $deliveryCartSales = CartSale::whereIn('delivery_status', [1, 2])->orderBy('created_at', 'desc')->get(); // 1 => Pendding || 2 => In Progress
        $completeCartSales = CartSale::where(['status' => 2, 'delivery_status' => 3, 'payment_status' => 2])->orderBy('created_at', 'desc')->get(); // 2 => Accepted || 3 => Received || 2 => Accepted


        $newCustomers = Customer::orderBy('created_at', 'desc')->take(10)->get();
        $newCartSales = CartSale::orderBy('created_at', 'desc')->take(10)->get();

        $productUnderLimit = Product::whereRaw('quantity_available <= quantity_limit')->get();

        return view('admin.index', compact(
            'customers',
            'stopedCustomers',
            'CartSales',
            'penddingCartSales',
            'deliveryCartSales',
            'completeCartSales',

            'newCustomers',
            'newCartSales',

            'productUnderLimit',
        ));
    }
   
}
