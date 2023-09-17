<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Routing\Route;


class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Route $route)
    {
        try {

            $reviews = Review::get();
            return view('admin.reviews.index')->with('reviews',$reviews);

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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id,Request $request)
    {

        // $request->validate([
        //     'your_commemt' => 'required',
        //     'rate'=>'required|numeric'
        // ]);

        $product = Product::find($id);

        if ($product) {
            $review=Review::where('user_id',auth('customer')?->user()?->id)->where('product_id',$id)?->first();
            if($review){
                if($review->status !=2)
                    return redirect()->back()->with(trans('danger','front_end.Your_comment_is_already_under_review'));
                return redirect()->back()->with(trans('danger','front_end.I_commented_before'));
            }

           $x= ProductReview::create([
                'user_id'=>auth('customer')?->user()?->id,
                'product_id'=>$id,
                'review_note'=>$request->review_note,
                'review_value'=>$request->review_value ?? 2,
                'status'=>1,//pending
                'user_type'=>'customer',//pending
            ]);
            // return $x;

            return redirect()->back()->with('success', trans('front_end.message_sent_successfully'));

        } else {
            return redirect()->back()->with(trans('danger', 'front_end.product_not_found'));
        }
    }


    /**
     * update the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $review = Review::find($id);

        if ($review) {
            if($review->status==1)
                $review->status=2;
            else if($review->status==2){
                $review->status=3;
            }
            else if($review->status==3){
                $review->status=2;
            }
            $review->save();

            return redirect()->back()->with(trans('front_end.sent_successfully'));

        } else {
            return redirect()->back()->with(trans('front_end.product_not_found'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review=Review::find($id);

        if ($review) {

            $review->delete();
            return redirect()->back()->with(trans('front_end.sent_successfully'));

        } else {
            return redirect()->back()->with(trans('front_end.Rating_not_available'));
        }

    }
}
