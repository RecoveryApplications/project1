<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customer;
use App\Models\StateUsa;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\Frontend\ProfileAddressRequest;
use App\Http\Requests\Frontend\Customers\ProfileCustomerRequest;

class ProfileCustomerController extends Controller
{

    public function updateProfile(ProfileCustomerRequest $request)
    {
        $customer = Customer::find(auth('customer')->user()->id);
        $data = $request->except(['password', 'password_confirmation']);
        // if request have email return error message
        if ($request->has('email')) {
            return redirect()->back()->with('error', 'Email cannot be changed.');
        }
        if ($request->has('password') && $request->has('password_confirmation')) {
            if ($request->input('password') === $request->input('password_confirmation')) {
                $data['password'] = Hash::make($request->input('password'));
            } else {
                return redirect()->back()->with('error', 'Password and password confirmation do not match.');
            }
        }

        $customer->update($data);
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function address()
    {
        if (Auth::guard('customer')->check()) {
            $states = StateUsa::all();
            $user_addresses = auth('customer')->user()->locations;

            return view('front_end_inners.customer.user-address', compact('states', 'user_addresses'));
        } else {

            return view('front_end_inners.customer.login_register');
        }
    }
    public function createAddress(Request $request)
    {

        if (auth('customer')->user()) {
            $location = UserLocation::create([
                'user_id' => auth('customer')->user()->id,
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->name,
                'company' => $request->company,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
                'country' => $request->country,
                'more_info' => $request->more_info
            ]);
            if ($location)
                return redirect()->back()->with('success', 'Address created successfully');
            return redirect()->back()->with('danger', 'something went wrong');
        } else {
            return redirect()->back()->with('danger', 'Something went wrong');
            // if (Cookie::get('shopping_Address')) {
            //     $cookie_data = stripslashes(Cookie::get('shopping_Address'));
            //     $locations = json_decode($cookie_data, true);
            // } else {
            //     // if not exist create array to create cart
            //     $locations = array();
            // }
            // $locations[] = [
            //     'email' => $request->email,
            //     'phone' => $request->phone,
            //     'name' => $request->name,
            //     'company' => $request->company,
            //     'address' => $request->address,
            //     'apartment' => $request->apartment,
            //     'city' => $request->city,
            //     'state' => $request->state,
            //     'zipcode' => $request->zipcode,
            //     'country' => $request->country,
            //     'more_info' => $request->more_info
            // ];

            // $item_data = json_encode($locations, JSON_UNESCAPED_UNICODE);

            // $minutes = 43000;
            // // add array to cookies
            // Cookie::queue(Cookie::make('shopping_Address', $item_data, $minutes));
            // return redirect()->back()->with('success', 'created successfully');
        }


        return redirect()->back()->with('danger', 'something went wrong');
    }



    public function updateAddress($id, ProfileAddressRequest $request)
    {

        $user_address = UserLocation::find($id);
        $data = $request->all();

        if ($user_address) {

            if ($user_address->user_id === auth('customer')->user()->id) {
                $user_address->update($data);
                return redirect()->back()->with('success', 'updated Successfully');
            }
        }
        return redirect()->back()->with('danger', 'something went wrong');
    }



    public function deleteAddress($id)
    {

        $user_address = UserLocation::find($id);

        if ($user_address) {

            if ($user_address->user_id === auth('customer')->user()->id) {
                $user_address->delete();
                return redirect()->back()->with('success', 'delete Successfully');
            }
        }
        return redirect()->back()->with('danger', 'something went wrong');
    }
}
