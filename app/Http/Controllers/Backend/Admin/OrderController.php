<?php

namespace App\Http\Controllers\Backend\Admin;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\CartSale;
use App\Mail\OrderCartSale;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\CartOperation;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\DB;
use LaravelShipStation\ShipStation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use LaravelShipStation\Models\Order;
use LaravelShipStation\Models\Address;
use LaravelShipStation\Models\OrderItem;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Database\Eloquent\Collection;

class OrderController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {

        try {

            $orders = CartSale::orderBy('created_at', 'desc')->paginate(50);

            foreach ($orders as $order) {
                if ($order->orderId) {
                    $orderShipStation = $orders->get(['orderNumber' => $order->orderNumber]);

                    // $fulfillments= $shipStation->fulfillments->get(['orderNumber' => $order->orderNumber]); // returns integer

                    // if(isset($fulfillments->fulfillments[0]->trackingNumber)){
                    //     $order->track_number=$fulfillments->fulfillments[0]->trackingNumber;
                    //     $order->save();
                    // }
                    if (count($orderShipStation->orders) > 0)
                        $order->statusShipStation = $orderShipStation->orders[0]->orderStatus;
                    else
                        $order->statusShipStation = 'awaiting_shipment';
                } else
                    $order->statusShipStation = 'awaiting_shipment';
            }
            return view('admin.orders.index', compact('orders'));
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
    public function show($id, Route $route)
    {
        try {
            $cartSale = CartSale::find($id);
            if ($cartSale) {


                $payment = $cartSale->payment;

                return view('admin.orders.show', compact('cartSale', 'payment'));
            } else {
                return redirect()->route('super_admin.products-index')->with('danger', 'This record is not in the records');
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
    // ======================== Show Function =========================
    // ================================================================
    public function sendToDelivery($id, Route $route)
    {
        try {
            $cartSale = CartSale::find($id);
            if ($cartSale) {
                if ($cartSale->status == 'Pendding' && $cartSale->payment_status == 'Accepted' && $cartSale->delivery_status == null) {




                    $weight_sum = 0;
                    $operations = CartOperation::where('cart_sale_id', $cartSale->id)->get();

                    foreach ($operations as $operation) {
                        $weight_sum += $operation->product->weight;
                    }


                    $refNo = now()->format('Ymd') . $cartSale->id;
                    $sentDate = now('UTC');



                    $api_data = [
                        "passkey" => "McE@6257",
                        "refno" => $refNo,
                        "sentDate" => $sentDate,
                        "idNo" => "0000000000",
                        "cName" => $cartSale->customer->username,
                        "cntry" => $cartSale->location->country,
                        "cCity" => $cartSale->location->city,
                        "cZip" => "00000",
                        "prefDelvDate" => "0000000000000",
                        "cMobile" => $cartSale->location->phone,
                        "cTel1" => isset($cartSale->location->phone_extra) ? $cartSale->location->phone_extra : "0000000000",
                        "cTel2" => $cartSale->customer->phone,
                        "cAddr1" => $cartSale->location->retail,
                        "cAddr2" => $cartSale->location->address_2,
                        "shipType" => "DLV",
                        "PCs" => $cartSale->cartOperations->count(),
                        "cEmail" => $cartSale?->customer?->email ?? $cartSale->email,
                        "carrValue" => "0",
                        "carrCurr" => "0",
                        "codAmt" => "0",
                        "weight" => $weight_sum,
                        "itemDesc" => "none",
                        "custVal" => "0",
                        "custCurr" => "000",
                        "insrAmt" => "0",
                        "insrCurr" => "0",
                        "sName" => "Juman DeadSea",
                        "sContact" => "Juman DeadSea",
                        "sAddr1" => "KSA",
                        "sAddr2" => "KSA",
                        "sCity" => "Riyadh",
                        "sPhone" => "+966 66 666 6666",
                        "sCntry" => "SAudi Arabia",
                        "gpsPoints" => "0",
                        "cPOBox" => "00000000",
                        "gpsPoints" => "0"
                    ];


                    $request_api = Http::post('https://track.smsaexpress.com/SecomRestWebApi/api/addship', $api_data);


                    if ($request_api->getStatusCode() != 200) {

                        return redirect()->back()->with('danger', 'An Error Occured ... Please Try Again !!!');
                    }



                    $awbNo = $request_api;


                    // Update Products Quantity :
                    foreach ($cartSale->cartOperations as $key => $cartOperation) {
                        $product = Product::find($cartOperation->product_id);
                        if ($product) {
                            $product->quantity_available = $product->quantity_available - $cartOperation->quantity;
                            $product->save();
                        }
                    }

                    // Update Order Status & Delivery Status :
                    $cartSale->status = 2;  // 2 => Accepted
                    $cartSale->delivery_status = 1;  // 1 => Pendding
                    $cartSale->refNo = str_replace('"', '', $awbNo);
                    $cartSale->save();
                    return redirect()->back()->with('success', 'The process has successfully');
                } else {
                    return redirect()->back()->with('danger', 'This order was previously sent to the delivery company');
                }
            } else {
                return redirect()->route('super_admin.products-index')->with('danger', 'This record is not in the records');
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
    // ======================== Show Function =========================
    // ================================================================
    public function addTrackNumber(Route $route, Request $request)
    {
        try {

            $request->validate([
                'track_number' => 'required',
                'sale_id' => 'required'
            ]);

            $cart_sale = CartSale::find($request->sale_id);
            if ($cart_sale) {
                $cart_sale->update([
                    'track_number' => $request->track_number,
                    'delivery_status' => 2,
                    'status' => 2
                ]);


                return redirect()->back()->with('success', 'Successfully Added ...');
            } else {
                return 'Access Denied !!!!';
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


    public function shipstation(Route $route, Request $request)
    {
        try {

            $request->validate([
                'sale_id' => 'required'
            ]);

            $cart_sale = CartSale::find($request->sale_id);
            if ($cart_sale) {
                $shipStation = new ShipStation('42b21befe369478c910ef2b1666bea5e', 'c074d78f698e4cd8b1cc4139f287885b', 'https://ssapi.shipstation.com');

                $address = new Address();
                $address->name = $cart_sale?->location?->name ?? $cart_sale->name;
                $address->street1 = $cart_sale?->location?->address ?? $cart_sale->address;
                $address->city = $cart_sale?->location?->city ?? $cart_sale->city;
                $address->state = $cart_sale?->location?->state ?? $cart_sale->state;
                $address->postalCode = $cart_sale?->location?->zipcode ?? $cart_sale->zipcode;
                $address->country = 'US';
                $address->phone = $cart_sale?->location?->phone ?? $cart_sale->phone;


                $orderItem = [];
                foreach ($cart_sale->cartOperations as $cartOperation) {
                    $item = new OrderItem();
                    $item->lineItemKey = $cartOperation->id;
                    $item->sku = $cartOperation->product_id;
                    $item->name = $cartOperation->product->name_en;
                    $item->quantity = $cartOperation->quantity;
                    $item->unitPrice  = $cartOperation->sub_total;
                    $item->warehouseLocation = 'Warehouse A';
                    array_push($orderItem, $item);
                }


                $order = new Order();

                $order->orderNumber = $cart_sale->id . time();
                $order->orderDate = Carbon::parse($cart_sale->created_at)->format('Y-m-d');
                $order->orderStatus = 'awaiting_shipment';
                $order->amountPaid = $cart_sale->total;
                $order->taxAmount = '0.00';
                $order->shippingAmount = '0.00';
                $order->internalNotes = 'nothing';
                $order->billTo = $address;
                $order->shipTo = $address;
                $order->items[] = $orderItem;

                $orderJson = [
                    'orderNumber' => $order->orderNumber,
                    'orderDate' => $order->orderDate,
                    'orderStatus' => 'awaiting_shipment',
                    'amountPaid' => $cart_sale->total,
                    'taxAmount' => '0.00',
                    'shippingAmount' => '0.00',
                    'internalNotes' => 'nothing',
                    'billTo' => $address,
                    'shipTo' => $address,
                    'items' => $orderItem,
                ];



                $shipStationData = $shipStation->orders->post($orderJson, 'createorder');
                // return $shipStationData;
                $cart_sale->update([
                    'orderId' => $shipStationData->orderId,
                    'track_number' => $shipStationData->orderId,
                    'orderNumber' => $shipStationData->orderNumber,
                    'orderKey' => $shipStationData->orderKey,
                    'delivery_status' => 2,
                    'status' => 2
                ]);
                //

                Mail::to(auth()->user()->email)->send(new OrderCartSale($cart_sale));
                Mail::to($cart_sale?->customer?->email ?? $cart_sale->email)->send(new OrderCartSale($cart_sale));
                return redirect()->back()->with('success', 'Successfully Added ...');
            } else {
                return 'Access Denied !!!!';
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
    // ======================== index Function ========================
    // ================================================================
    public function ordersExport(Request $request, Route $route)
    {
        try {
            $cartSales = CartSale::select('*');
            $cartSales = $cartSales->orderBy('created_at', 'desc')->get();
            $prod_arr = new Collection();

            foreach ($cartSales as $cartSale) {
                $prod_arr->push([
                    'user_id' => $cartSale->user_id,
                    'user' => $cartSale->customer->name_en,
                    'location_id' => $cartSale->location_id,
                    'user_type' => $cartSale->user_type,
                    'product_count' => $cartSale->product_count,
                    'discount' => isset($cartSale->discount) ? $cartSale->discount : 'Undefined',
                    'promo_code_id' => isset($cartSale->promo_code_id) ? $cartSale->promo_code_id : 'Undefined',
                    'promo_code' =>  $cartSale->promoCode->promo_code,
                    'promo_value' =>  $cartSale->promoCode->promo_value,
                    'sub_total' => $cartSale->sub_total,
                    'total' => $cartSale->total,
                    'status' => $cartSale->status,
                    'payment_status' => $cartSale->payment_status,
                    'orderId' => $cartSale->orderId,
                    'orderNumber' => isset($cartSale->orderNumber) ? $cartSale->orderNumber : 'Undefined',
                    'payment_method' => $cartSale->payment_method,
                    'delivery_status' => $cartSale->delivery_status,
                    'track_number' => $cartSale->track_number,
                    'email' => $cartSale->email ? $cartSale->email : $cartSale->location->email,
                    'phone' => $cartSale->phone ? $cartSale->phone : $cartSale->location->phone,
                    'name' => $cartSale->name ? $cartSale->name : $cartSale->location->name,
                    'company' => $cartSale->company ? $cartSale->company : $cartSale->location->company,
                    'address' => $cartSale->address ? $cartSale->address : $cartSale->location->address,
                    'apartment' => $cartSale->apartment ? $cartSale->apartment : $cartSale->location->apartment,
                    'city' => $cartSale->city ? $cartSale->city : $cartSale->location->city,
                    'state' => $cartSale->state ? $cartSale->state : $cartSale->location->state,
                    'zipcode' => $cartSale->zipcode ? $cartSale->zipcode : $cartSale->location->zipcode,
                    'country' => $cartSale->country ? $cartSale->country : $cartSale->location->country,
                    'more_info' => $cartSale->more_info ? $cartSale->more_info : $cartSale->location->email,
                ]);
            }
            return (new FastExcel($prod_arr))->download("orders.xlsx");
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
