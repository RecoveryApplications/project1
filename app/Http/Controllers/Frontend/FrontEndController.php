<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Review;
use App\Models\Product;
use App\Models\CartTemp;
use App\Models\Category;
use App\Models\MainSize;
use App\Models\MainColor;
use App\Models\Newsletter;
use App\Models\MainCategory;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\SuperCategory;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Models\ContactUsRequest;
use App\Traits\UploadImageTrait;
use App\Models\ProdSzeClrRelation;
use App\Http\Controllers\Controller;
use App\Models\SeoOperation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontEndController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    function showCart()
    {
        return view('front_end_inners.cart');
    }


    // getItemDetails for Modal
    function getItemDetails(Request $request)
    {
        $request->validate([
            'item_id' => 'required|numeric',
        ]);


        $product = Product::find($request->item_id);

        // return $product;
        if ($product) {

            $reviews = Review::where('product_id', $product->id)->where('status', 2)->get();

            $output_images = '';
            $output_prices = '';
            $output_colors = '';
            $output_sizes = '';
            $output_quantity = '';
            $output_details = '';
            $output_buttons = '';

            if ($product->sizes->count() > 0 || $product->colors->count() > 0) {

                if (isset($product->properties) && $product->properties->count() > 0) {
                    $property = $product->firstProperty;
                }

                $output_details .= '<h2>' . $product->name_en . '</h2>
                <div class="rating-section">';
                $rate = 0;
                if ($reviews) {
                    foreach ($reviews as $review) {
                        $rate += $review?->rate;
                    }
                }
                if ($reviews->count() != 0) {
                    $rate = $rate / $reviews->count();
                } else {
                    $rate = 0;
                }
                $output_details .= '<div class="rating">
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 0) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 1) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 2) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 3) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 4) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        </div>
                    <h6>' . $reviews->count() . ' ' . __('front_end.product_ratings') . '</h6>
                </div>
                <div class="part py-3">
                <p class="mb-1">' . \Illuminate\Support\Str::limit(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------', 200, $end = '...');
                if (\Illuminate\Support\Str::length(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------') > 200) {
                    $output_details .= '<span id="dots"><a href="' . route('productDetails', $product->id) . '">More</a></span>';
                }
                $output_details .= '</p>
                <input type="hidden" id="product_id_modal" value="' . $product->id . '">
                </div>';


                $output_buttons .= ' <a href="javascript:void(0)" id="cartEffect"
                class="add_to_cartbtn btn btn-solid hover-solid btn-animation" data-prop_type="1" data-property_id="' . $property->id . '" data-product_id="' . $product->id . '"><i
                    class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                ' . __('front_end.product_add_to_cart') . '</a>
                <a href="#" class="btn btn-solid"><i class="fa fa-bookmark fz-16 me-2"
                    aria-hidden="true"></i>' . __('front_end.product_wishlist') . '</a>';

                if ($property) {
                    // Property Images
                    if (isset($property->propertyImages) && $property->propertyImages->count() > 0) {
                        $output_images .= '<div class="product-slick">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div class="w-100" style="max-height: 500px;">';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif (isset($image->image_url) && $image->image_url != null) {
                                $output_images .= '<img src="' . $image->image_url . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                            alt="" class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div>';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif ($image->image_url) {
                                $output_images .= '<img src="' . asset($image->image_url) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                                    alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                            </div>
                        </div>';
                    } else {
                        $output_images .= '<div>';
                        if (isset($property->image) && file_exists($property->image)) {
                            $output_images .= '<img src="' . asset($property->image) . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } elseif (isset($property->image_url) && $property->image_url != null) {
                            $output_images .= '<img src="' . $property->image_url . '" alt=""
                                        class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } else {
                            $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        }
                        $output_images .= '</div>';
                    }

                    // Property Prices
                    if ($property->on_sale_price_status == 'Active') {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '
                            <span><del>$' . $property?->on_sale_price . '</del></span>
                        </h3>';
                    } else {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '</h3>';
                    }



                    $output_quantity .= '<h6 class="product-title">' . __('front_end.product_Quantity') . '</h6>
                                            <div class="qty-box">
                                                <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                                class="ti-angle-left"></i></button> </span>
                                                    <input type="text" name="quantity" min="1"
                                                        max="' . $property->quantity_available . '"
                                                        class="prod_quant_prop_' . $property->id . ' form-control input-number" value="1">
                                                    <span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                                class="ti-angle-right"></i></button></span>
                                                </div>
                                            </div>';


                    $available_colors = ProdSzeClrRelation::where([['product_id', $product->id], ['main_color_id', '!=', null]])->orderBy('id', 'desc')->get();

                    $available_sizes = ProdSzeClrRelation::where([['product_id', $product->id], ['main_size_id', '!=', null]])->orderBy('id', 'desc')->get();



                    // Start Color Section
                    if (isset($available_colors) && $available_colors->count() > 0) {
                        $output_colors .= '<ul class="color-variant" id="colors_modal">';

                        foreach ($available_colors->unique('main_color_id') as $key => $color) {
                            $class_color = "";
                            if (isset($property->active_colors)) {
                                if (!in_array($color->main_color_id, $property->active_colors)) {
                                    $class_color = "not-selected-color";
                                } else {
                                    $class_color = "";
                                }
                            } else {
                                $class_color = "not-selected-color";
                            }

                            $active_class = "";
                            if ($color->main_color_id == $property->main_color_id) {
                                $active_class = "active";
                            }



                            if (isset($color->color->image) && file_exists($color->color->image)) {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute_modal ' . $active_class . '" data-color_id_modal="' . $color->color->id . '"style="background-image:' . $color->color->image . '"></li>';
                            } else {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute_modal ' . $active_class . '" data-color_id_modal="' . $color->color->id . '"style="background-color:' . $color->color->color_code . '"></li>';
                            }
                        }

                        $output_colors .= '</ul>';
                    }
                    // End Color Section

                    // Start Size Section
                    if (isset($available_sizes) && $available_sizes->count() > 0) {
                        $output_sizes .= '<h6 class="product-title size-text">' . __('front_end.product_Select_Size') . '</h6>
                        <h6 class="error-message">please select size</h6>
                        <div class="size-box" id="sizes_modal"><ul>';
                        foreach ($available_sizes->unique('main_size_id') as $key => $size) {
                            $class_size = "";
                            if (isset($property->active_sizes)) {
                                if (!in_array($size->main_size_id, $property->active_sizes)) {
                                    $class_size = "not-selected-size";
                                }
                            } else {
                                $class_size = "not-selected-size";
                            }

                            $active_class_size = "";
                            if ($size->main_size_id == $property->main_size_id) {
                                $active_class_size = "active";
                            }

                            $output_sizes .= '<li class="' . $class_size . ' product_attribute_modal ' . $active_class_size . '"
                                    data-size_id_modal="' . $size->size->id . '">
                                    <a>' . $size->size->name_en . '</a>
                                </li>';
                        }
                        $output_sizes .= '</ul>
                        </div>';
                    }
                    // End Color Section



                    return response()->json([
                        'status' => true,
                        'output_images' => $output_images,
                        'output_prices' => $output_prices,
                        'output_colors' => $output_colors,
                        'output_sizes' => $output_sizes,
                        'output_quantity' => $output_quantity,
                        'output_details' => $output_details,
                        'output_buttons' => $output_buttons
                    ]);
                }
            } else {
                $output_details .= '<h2>' . $product->name_en . '</h2>
                <div class="rating-section">';
                $rate = 0;
                if ($reviews) {
                    foreach ($reviews as $review) {
                        $rate += $review?->rate;
                    }
                }
                if ($reviews->count() != 0) {
                    $rate = $rate / $reviews->count();
                } else {
                    $rate = 0;
                }
                $output_details .= '<div class="rating">
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 0) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 1) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 2) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 3) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 4) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        </div>
                    <h6>' . $reviews->count() . ' ' . __('front_end.product_ratings') . '</h6>
                </div>
                <div class="part py-3">
                <p class="mb-1">' . \Illuminate\Support\Str::limit(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------', 200, $end = '...');
                if (\Illuminate\Support\Str::length(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------') > 200) {
                    $output_details .= '<span id="dots"><a href="' . route('productDetails', $product->id) . '">More</a></span>';
                }
                $output_details .= '</p>
                <input type="hidden" id="product_id_modal" value="' . $product->id . '">
                </div>';


                $output_buttons .= ' <a href="javascript:void(0)" id="cartEffect"
                class="add_to_cartbtn btn btn-solid hover-solid btn-animation" data-prop_type="-1" data-property_id="2" data-product_id="' . $product->id . '"><i
                    class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                ' . __('front_end.product_add_to_cart') . '</a>
                <a href="#" class="btn btn-solid"><i class="fa fa-bookmark fz-16 me-2"
                    aria-hidden="true"></i>' . __('front_end.product_wishlist') . '</a>';


                // Product Images
                if (isset($product->productImages) && $product->productImages->count() > 0) {
                    $output_images .= '<div class="product-slick">';
                    foreach ($product->productImages as $image) {
                        $output_images .= '<div class="w-100" style="max-height: 500px;">';
                        if (isset($image->image) && file_exists($image->image)) {
                            $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        } elseif (isset($image->image_url) && $image->image_url != null) {
                            $output_images .= '<img src="' . $image->image_url . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        } else {
                            $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                            alt="" class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        }
                        $output_images .= '</div>';
                    }
                    $output_images .= '</div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">';
                    foreach ($product->productImages as $image) {
                        $output_images .= '<div>';
                        if (isset($image->image) && file_exists($image->image)) {
                            $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        } elseif ($image->image_url) {
                            $output_images .= '<img src="' . asset($image->image_url) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        } else {
                            $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                                    alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                        }
                        $output_images .= '</div>';
                    }
                    $output_images .= '</div>
                            </div>
                        </div>';
                } else {
                    $output_images .= '<div>';
                    if (isset($product->image) && file_exists($product->image)) {
                        $output_images .= '<img src="' . asset($product->image) . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $product->id . '">';
                    } elseif (isset($product->image_url) && $product->image_url != null) {
                        $output_images .= '<img src="' . $product->image_url . '" alt=""
                                        class="img-fluid blur-up lazyload image_zoom_cls-' . $product->id . '">';
                    } else {
                        $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $product->id . '">';
                    }
                    $output_images .= '</div>';
                }

                // Property Prices
                if ($product->on_sale_price_status == 'Active') {
                    $output_prices .= '<h3 class="price-detail">$' . $product?->sale_price . '
                            <span><del>$' . $product?->on_sale_price . '</del></span>
                        </h3>';
                } else {
                    $output_prices .= '<h3 class="price-detail">$' . $product?->sale_price . '</h3>';
                }



                $output_quantity .= '<h6 class="product-title">' . __('front_end.product_Quantity') . '</h6>
                                            <div class="qty-box">
                                                <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                                class="ti-angle-left"></i></button> </span>
                                                    <input type="text" name="quantity" min="1"
                                                        max="' . $product->quantity_available . '"
                                                        class="prod_quant_' . $product->id . ' form-control input-number" value="1">
                                                    <span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                                class="ti-angle-right"></i></button></span>
                                                </div>
                                            </div>';


                return response()->json([
                    'status' => true,
                    'output_images' => $output_images,
                    'output_prices' => $output_prices,
                    'output_colors' => $output_colors,
                    'output_sizes' => $output_sizes,
                    'output_quantity' => $output_quantity,
                    'output_details' => $output_details,
                    'output_buttons' => $output_buttons
                ]);
            }
        }
    }




    function productList(Route $route, $type = null, $id = null)
    {
        try {
            $lang=Config::get('app.locale');
            $active_brands = Brand::where('status', 1)->whereHas('mainCategory', function ($q) {
                $q->where('status', 1);
            })->orderBy('created_at', 'asc')->get();
            // return $active_brands;
            $weightArray = array_unique(Product::where('weight', '!=', null)->get()->pluck('weight')->toArray());

            $colors = MainColor::get();
            $sizes = MainSize::get();
            if ($type != null) {
                if ($type == "main") {
                    if ($id != null) {
                        $category = MainCategory::where('slug_'.$lang,$id)->get()->first();
                        if ($category) {
                            $products = Product::where([
                                'main_category_id' => $category->id,
                                'status' => 1
                            ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'category', 'type', 'active_brands', 'weightArray'));
                        } else {
                            $products = Product::where([
                                'status' => 1
                            ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_brands', 'weightArray'));
                        }
                    } else {
                        $products = Product::where([
                            'status' => 1
                        ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                        return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_brands', 'weightArray'));
                    }
                } else if ($type == "sub") {
                    if ($id != null) {
                        $category = Category::where('slug_'.$lang,$id)->get()->first();
                        if ($category) {
                            $products = Product::where([
                                'sub_category_id' => $category->id,
                                'status' => 1
                            ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'category', 'type', 'active_brands', 'weightArray'));
                        } else {
                            $products = Product::where([
                                'status' => 1
                            ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_brands', 'weightArray'));
                        }
                    } else {
                        $products = Product::where([
                            'status' => 1
                        ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);

                        return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type',  'active_brands', 'weightArray'));
                    }
                } else {
                    $products = Product::where([
                        'status' => 1
                    ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                    return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'active_brands', 'weightArray'));
                }
            } else {
                $products = Product::where([
                    'status' => 1
                ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                $seo_operation = SeoOperation::where('page_name', 'Shop')->get()->first();
                return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'active_brands', 'weightArray','seo_operation'));
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



    function productListColor(Route $route, $id, $type = null, $category_id = null)
    {
        try {

            $active_super_categories = SuperCategory::where('status', 1)->whereHas('products', function ($q) {
                $q->where('status', 1);
            })->orderBy('created_at', 'asc')->get();

            $colors = MainColor::get();
            $sizes = MainSize::get();
            if ($type != null) {
                if ($type == "super") {
                    if ($category_id != null) {
                        $category = SuperCategory::find($category_id);
                        if ($category) {
                            $products = Product::where([
                                ['super_category_id', $category->id],
                                ['status', 1]
                            ])->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();
                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'category', 'type', 'active_super_categories'));
                        } else {
                            $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                        }
                    } else {
                        $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                            $q->where([
                                ['main_color_id', $id],
                                ['status', 1]
                            ]);
                        })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                        return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                    }
                } else if ($type == "main") {
                    if ($category_id != null) {
                        $category = MainCategory::find($category_id);
                        if ($category) {
                            $products = Product::where([
                                ['main_category_id', $category->id],
                                ['status', 1]
                            ])->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'category', 'type', 'active_super_categories'));
                        } else {
                            $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                        }
                    } else {
                        $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                            $q->where([
                                ['main_color_id', $id],
                                ['status', 1]
                            ]);
                        })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                        return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                    }
                } else if ($type == "sub") {
                    if ($category_id != null) {
                        $category = Category::find($category_id);
                        if ($category) {
                            $products = Product::where([
                                ['sub_category_id', $category->id],
                                ['status', 1]
                            ])->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'category', 'type', 'active_super_categories'));
                        } else {
                            $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                                $q->where([
                                    ['main_color_id', $id],
                                    ['status', 1]
                                ]);
                            })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                        }
                    } else {
                        $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                            $q->where([
                                ['main_color_id', $id],
                                ['status', 1]
                            ]);
                        })->with('firstProperty')->orderBy('created_at', 'asc')->get();

                        return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'type', 'active_super_categories'));
                    }
                } else {
                    $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                        $q->where([
                            ['main_color_id', $id],
                            ['status', 1]
                        ]);
                    })->with('firstProperty')->orderBy('created_at', 'asc')->get();
                    return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'active_super_categories'));
                }
            } else {
                $products = Product::where('status', 1)->whereHas('properties', function ($q) use ($id) {
                    $q->where([
                        ['main_color_id', $id],
                        ['status', 1]
                    ]);
                })->with('firstProperty')->orderBy('created_at', 'asc')->get();
                return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'active_super_categories'));
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



    function productDetails($aliasname)
    {
        $lang=Config::get('app.locale');

        $product = Product::where('slug_'.$lang,$aliasname)->get()->first();

        // return $product;
        if ($product) {

            // return $product->firstProperty->active_colors;

            $properties = ProdSzeClrRelation::where('product_id', $product->product_id)->get();
            $related = Product::where('main_category_id', $product->main_category_id)->where('status', 1)->where('id', '!=', $product->id)->limit(12)->get();
            $reviews = Review::where('product_id', $aliasname)->where('status', 2)->get();

            $check_review_user = false;
            if (auth('customer')->user()) {
                $review_user = Review::where('product_id', $aliasname)->where('user_id', auth('customer')->user()?->id)->get();
                if ($review_user->count() > 0)
                    $check_review_user = false;
                else
                    $check_review_user = true;
            }

            return view('front_end_inners.product-detail', compact('product', 'properties', 'related', 'reviews', 'check_review_user'));
        } else {
            return redirect()->back()->with(trans('front_end.product_not_found'));
        }
    }


    function getProperties(Request $request)
    {
        $valid = [
            'product_id' => 'required',
            'property_type' => 'required',
            'get_type' => 'required'
        ];
        if ($request->get_type == 'color') {
            $valid['color_id'] = 'required';
        } else if ($request->get_type == 'size') {
            $valid['size_id'] = 'required';
        }
        $request->validate($valid);

        $color_out = '';
        $size_out = '';

        $output = '';

        if ($request->get_type == 'color') {
            $sizes = ProdSzeClrRelation::where('main_color_id', $request->color_id)->where('product_id', $request->product_id)->get();
            if ($sizes && $sizes->count() > 0) {
                $output .= '<li class="siz_class all_prop" data-property_type = "1" data-product_id = "' . $request->product_id . '"><span>All</span></li>';
                foreach ($sizes as $key => $property) {
                    $output .= '<li class="';
                    if ($key == 0) {
                        $output .= 'active';
                    }
                    $output .= ' size_click siz_class" data-property_type = "1" data-size_id = "' . $property->size->id . '" data-product_id = "' . $property->product_id . '" for="size' . $property->size->id . '"><input id="size' . $property->size->id . '" type="radio" name="size_id" value="' . $property->size->id . '" style="display: none;"';
                    if ($key == 0) {
                        $output .= 'checked';
                    }
                    $output .= '><label for="size' . $property->size->id . '">' . $property->size->name_en . '</label></li>';
                }
                return response()->json(['status' => true, 'output' => $output]);
            }
        } else if ($request->get_type == 'size') {
            $colors = ProdSzeClrRelation::where('main_size_id', $request->size_id)->where('product_id', $request->product_id)->get();
            if ($colors && $colors->count() > 0) {
                $output .= '<li class="col_class all_prop" data-property_type = "1" data-product_id = "' . $request->product_id . '"><span>All</span></li>';
                foreach ($colors as $key => $property) {
                    $output .= '<label>
                        <li class="';
                    if ($key == 0) {
                        $output .= 'active';
                    }
                    $output .= ' col_class color_click" data-property_type = "1" data-color_id = "' . $property->color->id . '" data-product_id = "' . $property->product_id . '" for="color' . $property->color->id . '">
                                <span for="color' . $property->color->id . '" style="background-color:' . $property->color->color_code . ';"></span>
                                <input id="color' . $property->color->id . '" type="radio" name="color_id"';
                    if ($key == 0) {
                        $output .= 'checked';
                    }
                    $output .= ' value="' . $property->color->id . '" style="display: none;">
                        </li>
                    </label>';
                }
                return response()->json(['status' => true, 'output' => $output]);
            }
        } else {
            $prop = ProdSzeClrRelation::where('product_id', $request->product_id)->get();


            if ($prop && $prop->count() > 0) {

                $size_out .= '<li class="siz_class all_prop" data-property_type = "1" data-product_id = "' . $request->product_id . '"><span>All</span></li>';
                foreach ($prop->unique('main_size_id') as $key => $property) {
                    $size_out .= '<li class="';
                    if ($key == 0) {
                        $size_out .= 'active';
                    }
                    $size_out .= ' size_click siz_class" data-property_type = "1" data-size_id = "' . $property->size->id . '" data-product_id = "' . $property->product_id . '" for="size' . $property->size->id . '"><input id="size' . $property->size->id . '" type="radio" name="size_id" value="' . $property->size->id . '" style="display: none;"';
                    if ($key == 0) {
                        $size_out .= 'checked';
                    }
                    $size_out .= '><label for="size' . $property->size->id . '">' . $property->size->name_en . '</label></li>';
                }

                $color_out .= '<li class="col_class all_prop" data-property_type = "1" data-product_id = "' . $request->product_id . '"><span>All</span></li>';
                foreach ($prop->unique('main_color_id') as $key => $property) {
                    $color_out .= '<label>
                            <li class="';
                    if ($key == 0) {
                        $color_out .= 'active';
                    }
                    $color_out .= ' col_class color_click" data-property_type = "1" data-color_id = "' . $property->color->id . '" data-product_id = "' . $property->product_id . '" for="color' . $property->color->id . '">
                                    <span for="color' . $property->color->id . '" style="background-color:' . $property->color->color_code . ';"></span>
                                    <input id="color' . $property->color->id . '" type="radio" name="color_id"';
                    if ($key == 0) {
                        $color_out .= 'checked';
                    }
                    $color_out .= ' value="' . $property->color->id . '" style="display: none;">
                            </li>
                        </label>';
                }

                return response()->json(['status' => true, 'color_out' => $color_out, 'size_out' => $size_out]);
            }
        }
    }

    public function contactUsRequest(Route $route, Request $request)
    {
        try {
            $request->validate([
                // 'firstname' => 'required',
                // 'email' => 'required|email:rfc,dns',
                // 'phonenumber' => 'required',
                // 'address' => 'required'
            ]);

            ContactUsRequest::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject ?? 0,
                'message' => $request->message,
            ]);

            return redirect()->back()->with('success', trans('sent_successfully'));
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


    function productListPost(Request $request, Route $route, $type = null, $id = null)
    {

        // $active_super_categories = SuperCategory::where('status', 1)->whereHas('products', function ($q) {
        //     $q->where('status', 1);
        // })->orderBy('created_at', 'asc')->get();
        $colors = MainColor::get();
        $sizes = MainSize::get();
        if ($type != null) {
            if ($type == "main") {
                if ($id != null) {
                    $category = MainCategory::find($id);
                    if ($category) {
                        $products = Product::where([
                            'main_category_id' => $category->id,
                            'status' => 1
                        ])->with('firstProperty');
                        $products = $this->fillter($request, $products);
                        $output = '';
                        foreach ($products as $product) {
                            $output .= $this->htmlProduct($product);
                        }
                        return response()->json(['status' => true, 'output' => $output]);
                    } else {
                        $products = Product::where([
                            'status' => 1
                        ])->with('firstProperty');
                        $products = $this->fillter($request, $products);

                        $output = '';
                        foreach ($products as $product) {
                            $output .= $this->htmlProduct($product);
                        }
                        return response()->json(['status' => true, 'output' => $output]);
                    }
                } else {
                    $products = Product::where([
                        'status' => 1
                    ])->with('firstProperty');
                    $products = $this->fillter($request, $products);

                    $output = '';
                    foreach ($products as $product) {
                        $output .= $this->htmlProduct($product);
                    }
                    return response()->json(['status' => true, 'output' => $output]);
                }
            } else if ($type == "sub") {
                if ($id != null) {
                    $category = Category::find($id);
                    if ($category) {
                        $products = Product::where([
                            'sub_category_id' => $category->id,
                            'status' => 1
                        ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                        $products = $this->fillter($request, $products);

                        $output = '';
                        foreach ($products as $product) {
                            $output .= $this->htmlProduct($product);
                        }
                        return response()->json(['status' => true, 'output' => $output]);
                    } else {
                        $products = Product::where([
                            'status' => 1
                        ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                        $products = $this->fillter($request, $products);

                        $output = '';
                        foreach ($products as $product) {
                            $output .= $this->htmlProduct($product);
                        }
                        return response()->json(['status' => true, 'output' => $output]);
                    }
                } else {
                    $products = Product::where([
                        'status' => 1
                    ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                    $products = $this->fillter($request, $products);
                    $output = '';
                    foreach ($products as $product) {
                        $output .= $this->htmlProduct($product);
                    }
                    return response()->json(['status' => true, 'output' => $output]);
                }
            }
             else {
                $products = Product::where([
                    'status' => 1
                ])->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
                $products = $this->fillter($request, $products);
                $output = '';
                foreach ($products as $product) {
                    $output .= $this->htmlProduct($product);
                }
                return response()->json(['status' => true, 'output' => $output]);
            }
        } else {

            $products = Product::where([
                'status' => 1
            ])->with('firstProperty');

            $products = $this->fillter($request, $products);
            $output = '';
            foreach ($products as $product) {
                $output .= $this->htmlProduct($product);
            }
            return response()->json(['status' => true, 'output' => $output]);
        }
    }

    public function fillter($request, $products)
    {
        $array_categories = array();
        if (isset($request->category)) {
            foreach (explode(',', $request->category) as $category) {
                array_push($array_categories, decrypt($category));
            }
        }

        $array_sizes = [];
        if (isset($request->size)) {
            foreach (explode(',', $request->size) as $size) {
                array_push($array_sizes, decrypt($size));
            }
        }

        $array_colors = [];
        if (isset($request->color)) {
            foreach (explode(',', $request->color) as $color) {
                array_push($array_colors, decrypt($color));
            }
        }

        $array_gender = [];
        if (isset($request->gender)) {
            foreach (explode(',', $request->gender) as $gender) {
                array_push($array_gender, $gender);
            }
        }

        $array_weight = [];
        if (isset($request->weight)) {
            foreach (explode(',', $request->weight) as $weight) {
                array_push($array_weight, decrypt($weight));
            }
        }

        $array_brands = [];
        if (isset($request->brand)) {
            foreach (explode(',', $request->brand) as $brand) {
                array_push($array_brands, decrypt($brand));
            }
        }


        $ec_select = null;
        if (isset($request->ec_select) && $request->ec_select != null) {
            $ec_select = $request->ec_select;
        }
        $max_price = null;
        if (isset($request->max_price)) {
            $max_price = $request->max_price;
        }
        $min_price = null;
        if (isset($request->min_price)) {
            $min_price = $request->min_price;
        }


        if (isset($request->search) && $request->search != null) {
            $products = $products->where('name_en', 'LIKE', '%' . $request->search . '%');
        }

        if (count($array_categories) > 0) {
            $products = $products->whereIn('super_category_id', $array_categories);
        }
        if (count($array_brands) > 0) {
            $products = $products->whereIn('brand_id', $array_brands);
        }

        if (count($array_weight) > 0) {
            $products = $products->whereIn('weight', $array_weight);
        }

        if (count($array_gender) > 0) {
            $products = $products->whereIn('gender', $array_gender);
        }

        if (count($array_sizes) > 0) {
            $products = $products->whereIn('size_id', $array_sizes)->orWhereHas('properties', function ($q) use ($array_sizes) {
                $q->whereIn('main_size_id', $array_sizes);
            });
        }

        if (count($array_colors) > 0) {
            $products = $products->whereIn('color_id', $array_colors)->orWhereHas('properties', function ($q) use ($array_colors) {
                $q->whereIn('main_color_id', $array_colors);
            });
        }

        if ($min_price) {
            $products = $products->where('sale_price', '>=', $min_price);
        }
        if ($max_price) {
            $products = $products->where('sale_price', '<=', $max_price);
        }



        if ($ec_select == 2) {
            $products = $products->orderBy('name_en', 'ASC')->paginate(50);
        } elseif ($ec_select == 3) {
            $products = $products->orderBy('name_en', 'DESC')->paginate(50);
        } elseif ($ec_select == 4) {
            $products = $products->orderBy('sale_price', 'ASC')->paginate(50);
        } elseif ($ec_select == 5) {
            $products = $products->orderBy('sale_price', 'DESC')->paginate(50);
        } else {
            $products = $products->orderBy('created_at', 'DESC')->paginate(50);
        }



        return $products;
    }

    public function htmlProduct($product)
    {

        $output = '
        <div class="col-xl-3 col-6 col-grid-box">
        <div class="product-box">
            <div class="img-wrapper">';


                    if (isset($product->image) && file_exists($product->image))
                         $output .= '
                            <div class="front">
                                <a href="' . route("productDetails", $product->id) . '">
                                <img src="' . asset($product->image) . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="' . asset($product->image) . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>';
                    elseif (isset($product->image_url) && $product->image_url != null)
                         $output .= '
                            <div class="front">
                                <a href="' . route("productDetails", $product->id) . '">
                                <img src="' . asset($product->image_url) . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>
                            <div class="back">
                                <a href="#"><img src="' . asset($product->image_url) . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>';
                    else{
                         $output .= '
                            <div class="front">
                                <a href="' . route("productDetails", $product->id) . '">
                                <img src="' . asset('front_end_style/assets/images/product-image/6_2.jpg') . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>
                            <div class="back">
                                <a href="' . route("productDetails", $product->id) . '"><img src="' . asset('front_end_style/assets/images/product-image/6_2.jpg') . '"
                                        class="img-fluid blur-up lazyload bg-img"
                                        alt=""></a>
                            </div>';
                            }
                            $output .= '<div class="cart-info cart-wrap">
                                <a class="add_on_cartbtn"
                                data-product_id="'.$product->id .'"';

                                if(isset($product->firstProperty) ){
                                    $output .= 'data-prop_type="'. 1 .'"';
                                }else{
                                    $output .= 'data-prop_type="'. 2 .'"';
                                }
                                if(isset($product->firstProperty)){
                                    $output .= 'data-property_id="'. $product->firstProperty->id .'"';
                                }else{
                                    $output .= 'data-property_id="'. 2 .'"';
                                }
                                // $output .= 'data-prop_type="'.isset($product->firstProperty) ? 1 : 2 .'"';
                                // $output .= 'data-property_id="'.isset($product->firstProperty) ? $product->firstProperty->id : 2 .'"';
                                $output .= 'data-bs-toggle="modal" data-bs-target="#addtocart" title="Add to cart">
                                <i class="ti-shopping-cart"></i> </a>';




                                if (auth('customer')->user()){
                                    $output .= ' <a class="wishlist wishlistV2" href="javascript:void(0)"  wishlist_id="'.encrypt($product->id) .'" title="Add to Wishlist">
                                        <i class="ti-heart" aria-hidden="true"></i>
                                    </a>';
                                }else{
                                }
                                $output .= '<a href="#" class="quickview" data-link-action="quickview"
                                                    data-bs-toggle="modal" data-bs-target="#quick-view"
                                                    data-id="'.$product->id.'"
                                                    title="Quick View"><i class="ti-search" aria-hidden="true"></i></a>';

                                $output .= '
                            </div>
            </div>';
            $output .= '  <div class="product-detail">
                <div class="rating"><i class="fa fa-star"></i> <i
                        class="fa fa-star"></i> <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                </div>
                <a href="product-page(no-sidebar).html">
                    <h6>'.$product->name.'</h6>
                </a>
                <p>'.$product->sub_description.'</p>
                <h4>';
                    if(isset($product->on_sale_price_status) && $product->on_sale_price_status == 'Active')
                    $output .= '<span class="new-price">$ '.$product->on_sale_price.'</span>
                    <span class="old-price">$'.$product->sale_price.'</span>';
                else
                $output .= ' <span class="new-price">$'.$product->sale_price.'</span>';

                $output .= ' </h4>
                <ul class="color-variant">
                    <li class="bg-light0"></li>
                    <li class="bg-light1"></li>
                    <li class="bg-light2"></li>
                </ul>
            </div>
        </div>
    </div>
        ';
        return $output;
    }
    // public function htmlProduct($product)
    // {

    //     $output = '
    //         <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
    //             <div class="ec-product-inner">
    //                 <div class="ec-pro-image-outer">
    //                     <div class="ec-pro-image" style="height:300px !important">
    //                         <a href="' . route("productDetails", $product->id) . '"
    //                             class="image" style="pointer-events: fill !important;">';


    //     if (isset($product->image) && file_exists($product->image))
    //         $output .= ' <img class="main-image" src="' . asset($product->image) . '"
    //                                     alt="Product" style="width: 318px;height: 353px;" />
    //                                 <img class="hover-image"
    //                                     src="' . asset($product->image) . '" alt="Product"
    //                                     style="width: 318px;height: 353px;" />';
    //     elseif (isset($product->image_url) && $product->image_url != null)
    //         $output .= '<img class="main-image" style="height:300px !important;width:100% !important;"  src="' . $product->image_url . '"
    //                                     alt="Product" />
    //                                 <img class="hover-image" style="height:300px !important;width:100% !important;" src="' . $product->image_url . '"
    //                                     alt="Product" />';
    //     else
    //         $output .= ' <img class="main-image"
    //                                     src="' . asset('front_end_style/assets/images/product-image/6_1.jpg') . '"
    //                                     alt="Product" />
    //                                 <img class="hover-image"
    //                                     src="' . asset('front_end_style/assets/images/product-image/6_2.jpg') . '"
    //                                     alt="Product" />';
    //     $output .= '</a>';

    //     $output .= '<a href="#" class="quickview" data-link-action="quickview"
    //                             title="Quick view" data-bs-toggle="modal"';
    //     if (isset($product->properties) && $product->properties->count() > 0)
    //         $output .= 'data-bs-target="#ec_quickview_modal" data-id="' . $product->firstProperty->id . '" data-prop-type="1"';
    //     else
    //         $output .= 'data-bs-target="#ec_quickview_modal" data-id="' . $product->id . '" data-prop-type="2">';
    //     $output .= '<img src="' . asset('front_end_style/assets/images/icons/quickview.svg') . '"
    //                                 class="svg_img pro_svg" alt="" />
    //                         </a>';

    //     $output .= '<form action="' . route('customer.add-to-cart') . '" method="POST"
    //     enctype="multipart/form-data">
    //     <input type="hidden" name="_token" value="' . csrf_token() . '" />

    //     <input type="hidden" name="cart_product_id"
    //         value="' . encrypt($product->id) . '">
    //         <input type="hidden" name="cart_product_quantity"
    //         value="1">
    //     <div class="ec-pro-actions">


    //                             <button title="Add To Cart" class="add-to-cart ec-btn-group wishlist"><img
    //                                     src="' . asset('front_end_style/assets/images/icons/cart.svg') . '"
    //                                     class="svg_img pro_svg" alt="" /> Add To
    //                                 Cart</button>
    //                             <a class="ec-btn-group wishlist wishlistV2" title="Wishlist" wishlist_id="' . encrypt($product->id) . '"><img
    //                                     src="' . asset('front_end_style/assets/images/icons/wishlist.svg') . '"
    //                                     class="svg_img pro_svg" alt="" /></a>';
    //     $output .= '</div>
    //     </form>
    //                     </div>
    //                 </div>';
    //     $output .= '<div class="ec-pro-content">
    //                     <h5 class="ec-pro-title"><a
    //                             href="' . route('productDetails', [$product->id, isset($product->firstProperty) ? $product->firstProperty->color_id : null, isset($product->firstProperty) ? $product->firstProperty->size_id : null]) . '">' . $product?->name_en . '</a>
    //                     </h5>';
    //     $reviews = Review::where('product_id', $product->id)->where('status', 2)->get();
    //     $rete = 0;
    //     if ($reviews) {
    //         foreach ($reviews as $review) {
    //             $rete += $review?->rate;
    //         }
    //     }

    //     if ($reviews->count() != 0) {
    //         $rete = $rete / $reviews->count();
    //     } else {
    //         $rete = 0;
    //     }

    //     $output .= '<div class="ec-t-review-rating">';
    //     $output .= '<i class="ecicon';
    //     if ($rete > 0)  $output .= 'eci-star fill';
    //     else $output .= 'eci-star-o';
    //     $output .= '"></i>';
    //     $output .= ' <i class="ecicon ';
    //     if ($rete > 1)  $output .= 'eci-star fill';
    //     else $output .= 'eci-star-o';
    //     $output .= '"></i>';
    //     $output .= '<i class="ecicon ';
    //     if ($rete > 2)  $output .= 'eci-star fill';
    //     else $output .= 'eci-star-o';
    //     $output .= '"></i>';
    //     $output .= '<i class="ecicon ';
    //     if ($rete > 3)  $output .= 'eci-star fill';
    //     else $output .= 'eci-star-o';
    //     $output .= '"></i>';
    //     $output .= ' <i class="ecicon ';
    //     if ($rete > 4)  $output .= 'eci-star fill';
    //     else $output .= 'eci-star-o';
    //     $output .= '"></i>
    //                 </div>

    //                     <span class="ec-price">';
    //     if ($product->on_sale_price_status == 'Active')
    //         $output .= '<span class="old-price">$' . $product?->sale_price . '</span>
    //                             <span
    //                                 class="new-price">$' . $product?->on_sale_price . '</span>';
    //     else
    //         $output .= '<span class="new-price">$' . $product?->sale_price . '</span>';

    //     $output .= '</span>';
    //     $output .= '<div class="ec-pro-option">';
    //     if (isset($product->properties) && $product->properties->count() > 0) {
    //         $output .= '<div class="ec-pro-color">
    //                                 <span class="ec-pro-opt-label">Color</span>
    //                                 <ul class="ec-opt-swatch ec-change-img">';
    //         $arr = [];
    //         foreach ($product->properties as $val => $prop) {
    //             if (!in_array($prop->color->id, $arr)) {
    //                 $output .= '<li class="';
    //                 if ($val == 0) $output .= 'active';
    //                 $output .= '">
    //                                                 <a href="#" class="ec-opt-clr-img"
    //                                                     data-src="' . asset($prop->image) . '"
    //                                                     data-src-hover="' . asset($prop->image) . '"
    //                                                     data-tooltip="' . $prop->color->name_en . '">
    //                                                     <span
    //                                                         style="background-color:' . $prop->color->color_code . ';"></span></a>
    //                                             </li>';
    //                 array_push($arr, $prop->color->id);
    //             }
    //         }
    //         $output .= '</ul>
    //                             </div>';
    //         $output .= '<div class="ec-pro-size">
    //                                 <span class="ec-pro-opt-label">Size</span>
    //                                 <ul class="ec-opt-size">';
    //         $arr2 = [];

    //         foreach ($product->properties as $key => $prop)
    //             if (!in_array($prop->size->id, $arr2)) {
    //                 $output .= '<li class="';
    //                 if ($key == 0) $output .= 'active';
    //                 $output .= '">
    //                                                 <a href="#" class="ec-opt-sz"
    //                                                     data-tooltip="' . $prop->size->name_en . '">
    //                                                     <span>' . $prop->size->name_en . '</span></a>
    //                                             </li>';
    //                 array_push($arr2, $prop->size->id);
    //             }

    //         $output .= '
    //                                 </ul>
    //                             </div>';
    //     }
    //     $output .= '</div>
    //                 </div>
    //             </div>
    //         </div>
    //     ';
    //     return $output;
    // }




    function search(Route $route, Request $request)
    {
        try {


            $active_super_categories = SuperCategory::where('status', 1)->whereHas('products', function ($q) {
                $q->where('status', 1);
            })->orderBy('created_at', 'asc')->get();
            $colors = MainColor::get();
            $sizes = MainSize::get();
            $search = $request->search;


            if ($request->search != null) {
                $products = Product::where([
                    'status' => 1,
                ])->where('name_en', 'LIKE', '%' . $request->search . '%')->with('firstProperty')->orderBy('created_at', 'asc')->paginate(50);
            } else {
                $products = Product::where([
                    'status' => 1,
                ])->with('firstProperty');
            }

            if ($request->brand_id != null) {
                $products = $products->where('brand_id', $request->brand_id);
            }
            $products = $products->orderBy('created_at', 'asc')->paginate(50);

            return view('front_end_inners.product_list', compact('products', 'colors', 'sizes', 'active_super_categories', 'search'))->with('search', $search);
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


    function Newsletter(Route $route, Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        try {

            $email = Newsletter::where('email', $request->email)->first();

            if (!$email) {
                Newsletter::create(['email' => $request->email]);
            }
            return redirect()->back()->with('success', trans('front_end.sent_successfully'));
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



    function getProductAttribute(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'selected_color' => 'required|numeric',
            'selected_size' => 'required|numeric'
        ]);

        $product = Product::find($request->product_id);

        // return $product;
        if ($product) {
            if ($product->sizes->count() > 0 || $product->colors->count() > 0) {

                if ($request->selected_size != -1 && $request->selected_color != -1) {
                    $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_size_id', $request->selected_size)->where('main_color_id', $request->selected_color)->get()->first();
                } else {
                    if ($request->selected_size != -1) {
                        $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_size_id', $request->selected_size)->get()->first();
                    } elseif ($request->selected_color != -1) {
                        $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_color_id', $request->selected_color)->get()->first();
                    } else {
                        return response()->json(['status' => false]);
                    }
                }


                $output_images = '';
                $output_prices = '';
                $output_colors = '';
                $output_sizes = '';
                $output_quantity = '';


                if ($property) {
                    // Property Images
                    if (isset($property->propertyImages) && $property->propertyImages->count() > 0) {
                        $output_images .= '<div class="product-slick">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div class="w-100" style="max-height: 500px;">';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif (isset($image->image_url) && $image->image_url != null) {
                                $output_images .= '<img src="' . $image->image_url . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                            alt="" class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div>';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif ($image->image_url) {
                                $output_images .= '<img src="' . asset($image->image_url) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                                    alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                            </div>
                        </div>';
                    } else {
                        $output_images .= '<div>';
                        if (isset($property->image) && file_exists($property->image)) {
                            $output_images .= '<img src="' . asset($property->image) . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } elseif (isset($property->image_url) && $property->image_url != null) {
                            $output_images .= '<img src="' . $property->image_url . '" alt=""
                                        class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } else {
                            $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        }
                        $output_images .= '</div>';
                    }

                    // Property Prices
                    if ($property->on_sale_price_status == 'Active') {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '
                            <span><del>$' . $property?->on_sale_price . '</del></span>
                        </h3>';
                    } else {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '</h3>';
                    }



                    $output_quantity .= '<h6 class="product-title">' . __('front_end.product_Quantity') . '</h6>
                                            <div class="qty-box">
                                                <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                                class="ti-angle-left"></i></button> </span>
                                                    <input type="text" name="quantity" min="1"
                                                        max="' . $property->quantity_available . '"
                                                        class="prod_quant_prop_' . $property->id . ' form-control input-number" value="1">
                                                    <span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                                class="ti-angle-right"></i></button></span>
                                                </div>
                                            </div>';


                    $available_colors = ProdSzeClrRelation::where([['product_id', $product->id], ['main_color_id', '!=', null]])->orderBy('id', 'desc')->get();

                    $available_sizes = ProdSzeClrRelation::where([['product_id', $product->id], ['main_size_id', '!=', null]])->orderBy('id', 'desc')->get();



                    // Start Color Section
                    if (isset($available_colors) && $available_colors->count() > 0) {
                        $output_colors .= '<ul class="color-variant" id="colors">';

                        foreach ($available_colors->unique('main_color_id') as $key => $color) {
                            $class_color = "";
                            if (isset($property->active_colors)) {
                                if (!in_array($color->main_color_id, $property->active_colors)) {
                                    $class_color = "not-selected-color";
                                } else {
                                    $class_color = "";
                                }
                            } else {
                                $class_color = "not-selected-color";
                            }

                            $active_class = "";
                            if ($color->main_color_id == $request->selected_color) {
                                $active_class = "active";
                            }



                            if (isset($color->color->image) && file_exists($color->color->image)) {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute ' . $active_class . '" data-color_id="' . $color->color->id . '"style="background-image:' . $color->color->image . '"></li>';
                            } else {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute ' . $active_class . '" data-color_id="' . $color->color->id . '"style="background-color:' . $color->color->color_code . '"></li>';
                            }
                        }

                        $output_colors .= '</ul>';
                    }
                    // End Color Section

                    // Start Size Section
                    if (isset($available_sizes) && $available_sizes->count() > 0) {
                        $output_sizes .= '<h6 class="product-title size-text">' . __('front_end.product_Select_Size') . '</h6>
                        <h6 class="error-message">please select size</h6>
                        <div class="size-box" id="sizes"><ul>';
                        foreach ($available_sizes->unique('main_size_id') as $key => $size) {
                            $class_size = "";
                            if (isset($property->active_sizes)) {
                                if (!in_array($size->main_size_id, $property->active_sizes)) {
                                    $class_size = "not-selected-size";
                                }
                            } else {
                                $class_size = "not-selected-size";
                            }

                            $active_class_size = "";
                            if ($size->main_size_id == $request->selected_size) {
                                $active_class_size = "active";
                            }

                            $output_sizes .= '<li class="' . $class_size . ' product_attribute ' . $active_class_size . '"
                                    data-size_id="' . $size->size->id . '">
                                    <a>' . $size->size->name_en . '</a>
                                </li>';
                        }
                        $output_sizes .= '</ul>
                        </div>';
                    }
                    // End Color Section



                    return response()->json([
                        'status' => true,
                        'output_images' => $output_images,
                        'output_prices' => $output_prices,
                        'output_colors' => $output_colors,
                        'output_sizes' => $output_sizes,
                        'output_quantity' => $output_quantity
                    ]);
                } else {
                    return response()->json(['status' => false]);
                }
            }
        }
    }




    function getProductAttributeModal(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'selected_color' => 'required|numeric',
            'selected_size' => 'required|numeric'
        ]);

        $product = Product::find($request->product_id);

        // return $product;
        if ($product) {

            $reviews = Review::where('product_id', $product->id)->where('status', 2)->get();

            if ($product->sizes->count() > 0 || $product->colors->count() > 0) {

                if ($request->selected_size != -1 && $request->selected_color != -1) {
                    $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_size_id', $request->selected_size)->where('main_color_id', $request->selected_color)->get()->first();
                } else {
                    if ($request->selected_size != -1) {
                        $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_size_id', $request->selected_size)->get()->first();
                    } elseif ($request->selected_color != -1) {
                        $property = ProdSzeClrRelation::where('product_id', $product->id)->where('main_color_id', $request->selected_color)->get()->first();
                    } else {
                        return response()->json(['status' => false]);
                    }
                }


                $output_images = '';
                $output_prices = '';
                $output_colors = '';
                $output_sizes = '';
                $output_quantity = '';
                $output_details = '';
                $output_buttons = '';


                $output_details .= '<h2>' . $product->name_en . '</h2>
                <div class="rating-section">';
                $rate = 0;
                if ($reviews) {
                    foreach ($reviews as $review) {
                        $rate += $review?->rate;
                    }
                }
                if ($reviews->count() != 0) {
                    $rate = $rate / $reviews->count();
                } else {
                    $rate = 0;
                }
                $output_details .= '<div class="rating">
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 0) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 1) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 2) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 3) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        <i class="fa fa-star"
                            style="color:';
                if ($rate >= 4) {
                    $output_details .= '#ffa200;';
                } else {
                    $output_details .= '#ddd';
                }
                $output_details .= '"></i>
                        </div>
                    <h6>' . $reviews->count() . ' ' . __('front_end.product_ratings') . '</h6>
                </div>
                <div class="part py-3">
                <p class="mb-1">' . \Illuminate\Support\Str::limit(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------', 200, $end = '...');
                if (\Illuminate\Support\Str::length(isset($product->main_description) ? str_replace('&nbsp;', ' ', $product->main_description) : '--------') > 200) {
                    $output_details .= '<span id="dots"><a href="' . route('productDetails', $product->id) . '">More</a></span>';
                }
                $output_details .= '</p>
                <input type="hidden" id="product_id_modal" value="' . $product->id . '">
                </div>';



                if ($property) {

                    $output_buttons .= ' <a href="javascript:void(0)" id="cartEffect"
                    class="add_to_cartbtn btn btn-solid hover-solid btn-animation" data-prop_type="1" data-property_id="' . $property->id . '" data-product_id="' . $product->id . '"><i
                        class="fa fa-shopping-cart me-1" aria-hidden="true"></i>
                    ' . __('front_end.product_add_to_cart') . '</a>
                    <a href="#" class="btn btn-solid"><i class="fa fa-bookmark fz-16 me-2"
                        aria-hidden="true"></i>' . __('front_end.product_wishlist') . '</a>';


                    // Property Images
                    if (isset($property->propertyImages) && $property->propertyImages->count() > 0) {
                        $output_images .= '<div class="product-slick">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div class="w-100" style="max-height: 500px;">';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif (isset($image->image_url) && $image->image_url != null) {
                                $output_images .= '<img src="' . $image->image_url . '" alt=""
                                            class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                            alt="" class="w-100 h-100 img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="slider-nav">';
                        foreach ($property->propertyImages as $image) {
                            $output_images .= '<div>';
                            if (isset($image->image) && file_exists($image->image)) {
                                $output_images .= '<img src="' . asset($image->image) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } elseif ($image->image_url) {
                                $output_images .= '<img src="' . asset($image->image_url) . '" alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            } else {
                                $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '"
                                                    alt=""
                                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $image->id . '">';
                            }
                            $output_images .= '</div>';
                        }
                        $output_images .= '</div>
                            </div>
                        </div>';
                    } else {
                        $output_images .= '<div>';
                        if (isset($property->image) && file_exists($property->image)) {
                            $output_images .= '<img src="' . asset($property->image) . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } elseif (isset($property->image_url) && $property->image_url != null) {
                            $output_images .= '<img src="' . $property->image_url . '" alt=""
                                        class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        } else {
                            $output_images .= '<img src="' . asset('front_end_style/assets/images/pro3/1.jpg') . '" alt=""
                                    class="img-fluid blur-up lazyload image_zoom_cls-' . $property->id . '">';
                        }
                        $output_images .= '</div>';
                    }

                    // Property Prices
                    if ($property->on_sale_price_status == 'Active') {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '
                            <span><del>$' . $property?->on_sale_price . '</del></span>
                        </h3>';
                    } else {
                        $output_prices .= '<h3 class="price-detail">$' . $property?->sale_price . '</h3>';
                    }



                    $output_quantity .= '<h6 class="product-title">' . __('front_end.product_Quantity') . '</h6>
                                            <div class="qty-box">
                                                <div class="input-group"><span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-left-minus" data-type="minus" data-field=""><i
                                                                class="ti-angle-left"></i></button> </span>
                                                    <input type="text" name="quantity" min="1"
                                                        max="' . $property->quantity_available . '"
                                                        class="prod_quant_prop_' . $property->id . ' form-control input-number" value="1">
                                                    <span class="input-group-prepend"><button type="button"
                                                            class="btn quantity-right-plus" data-type="plus" data-field=""><i
                                                                class="ti-angle-right"></i></button></span>
                                                </div>
                                            </div>';


                    $available_colors = ProdSzeClrRelation::where([['product_id', $product->id], ['main_color_id', '!=', null]])->orderBy('id', 'desc')->get();

                    $available_sizes = ProdSzeClrRelation::where([['product_id', $product->id], ['main_size_id', '!=', null]])->orderBy('id', 'desc')->get();



                    // Start Color Section
                    if (isset($available_colors) && $available_colors->count() > 0) {
                        $output_colors .= '<ul class="color-variant" id="colors_modal">';

                        foreach ($available_colors->unique('main_color_id') as $key => $color) {
                            $class_color = "";
                            if (isset($property->active_colors)) {
                                if (!in_array($color->main_color_id, $property->active_colors)) {
                                    $class_color = "not-selected-color";
                                } else {
                                    $class_color = "";
                                }
                            } else {
                                $class_color = "not-selected-color";
                            }

                            $active_class = "";
                            if ($color->main_color_id == $property->main_color_id) {
                                $active_class = "active";
                            }



                            if (isset($color->color->image) && file_exists($color->color->image)) {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute_modal ' . $active_class . '" data-color_id_modal="' . $color->color->id . '"style="background-image:' . $color->color->image . '"></li>';
                            } else {
                                $output_colors .= '<li class="' . $class_color . ' product_attribute_modal ' . $active_class . '" data-color_id_modal="' . $color->color->id . '"style="background-color:' . $color->color->color_code . '"></li>';
                            }
                        }

                        $output_colors .= '</ul>';
                    }
                    // End Color Section

                    // Start Size Section
                    if (isset($available_sizes) && $available_sizes->count() > 0) {
                        $output_sizes .= '<h6 class="product-title size-text">' . __('front_end.product_Select_Size') . '</h6>
                        <h6 class="error-message">please select size</h6>
                        <div class="size-box" id="sizes_modal"><ul>';
                        foreach ($available_sizes->unique('main_size_id') as $key => $size) {
                            $class_size = "";
                            if (isset($property->active_sizes)) {
                                if (!in_array($size->main_size_id, $property->active_sizes)) {
                                    $class_size = "not-selected-size";
                                }
                            } else {
                                $class_size = "not-selected-size";
                            }

                            $active_class_size = "";
                            if ($size->main_size_id == $property->main_size_id) {
                                $active_class_size = "active";
                            }

                            $output_sizes .= '<li class="' . $class_size . ' product_attribute_modal ' . $active_class_size . '"
                                    data-size_id_modal="' . $size->size->id . '">
                                    <a>' . $size->size->name_en . '</a>
                                </li>';
                        }
                        $output_sizes .= '</ul>
                        </div>';
                    }
                    // End Color Section



                    return response()->json([
                        'status' => true,
                        'output_images' => $output_images,
                        'output_prices' => $output_prices,
                        'output_colors' => $output_colors,
                        'output_sizes' => $output_sizes,
                        'output_quantity' => $output_quantity,
                        'output_details' => $output_details,
                        'output_buttons' => $output_buttons
                    ]);
                } else {
                    return response()->json(['status' => false]);
                }
            }
        }
    }




    function deleteItemToCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|numeric',
        ]);


        if (!Auth::guard('customer')->check()) {
            return response()->json(['status' => false]);
        }


        $carts = CartTemp::where('id', $request->cart_id)->delete();

        if ($carts) {


            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    function getCartPageAjax(Request $request)
    {


            $endTotal = 0;

            if (Auth::guard('customer')->check()) {
                $public_customer_carts = CartTemp::where(['user_id' => Auth::guard('customer')->user()->id, 'user_type' => 'Customer'])->get();
                $endTotal = 0;
                foreach ($public_customer_carts as $public_customer_cart) {
                    $sub_total = 0;

                    $public_customer_cart->cart_product = Product::find($public_customer_cart->product_id);

                    if(isset($public_customer_cart->cart_product->activeOffer)){
                        $offer = $public_customer_cart->cart_product->activeOffer;
                        $offer_price = $offer->price;
                        $offer_quantity = $offer->quantity_user;

                        if($public_customer_cart->quantity <= $offer_quantity){
                            $cart_total = $public_customer_cart->quantity * $offer_price;
                        }else{
                            $cart_total = ($offer_quantity * $offer_price) + (($public_customer_cart->quantity - $offer_quantity) * $public_customer_cart->cart_product->sale_price);
                        }
                        $endTotal += $cart_total;
                        $sub_total = $cart_total;

                    }else{
                        if($public_customer_cart->cart_product->on_sale_price_status == 'Active'){
                            $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                            $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                        }else{
                            $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                            $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                        }

                        // return $endTotal;
                    }

                    $public_customer_cart->sub_total = $sub_total;
                }
                $public_customer_carts->endTotal = $endTotal;
                $public_customer_carts_count = $public_customer_carts->count();

                $public_customer_carts_count = count($public_customer_carts ?? []);

                $output = '';

                foreach ($public_customer_carts as $public_customer_cart){
                    // return $endTotal;
                    $output .= ' <tr>
                        <td>
                            <a href="#">';
                                if (isset($public_customer_cart->cart_product->image) && file_exists($public_customer_cart->cart_product->image)){
                                    $output .= '<img src="'.asset($public_customer_cart->cart_product->image).'" alt="">';
                                }elseif(isset($public_customer_cart->cart_product->image_url)){
                                    $output .= '<img src="'.$public_customer_cart->cart_product->image_url.'" alt="">';
                                }else{
                                    $output .= '<img src="'.asset('front_end_style/assets/images/pro3/2.jpg').'" alt="">';
                                }
                                $output .= '</a>
                        </td>
                        <td>
                            <h4 class="td-color">'.$public_customer_cart->cart_product->name.'</h4>
                        </td>
                        <td>';
                            if($public_customer_cart->cart_product->on_sale_price_status == 'Active'){
                                $output .= '<h2>'.$public_customer_cart->cart_product->on_sale_price.'</h2>';
                            }else{
                                $output .= '<h2>'.$public_customer_cart->cart_product->sale_price.'</h2>';
                            }

                            $output .= '</td>
                        <td>
                            <div class="qty-box">
                                <div class="input-group"><span class="input-group-prepend"><button type="button"
                                            class="btn quantity-left-minus quantity_cart"
                                            data-product_id="'.$public_customer_cart->cart_product->id.'"
                                            data-prop_type="'.$public_customer_cart->property_type.'"';
                                            if(isset($public_customer_cart->cart_product->firstProperty)){

                                                $output .= ' data-property_id="'.$public_customer_cart->cart_product->firstProperty->id.'"';

                                            }else{
                                                $output .= ' data-property_id="'. 2 .'"';

                                            }
                                            $output .= '  data-type="minus" data-field=""><i
                                                class="ti-angle-left"></i></button> </span>
                                    <input type="text" name="quantity" min="0"
                                        max="'.$public_customer_cart->cart_product->quantity_available.'"
                                        class="form-control input-number" value="'.$public_customer_cart->quantity.'">';
                                        $output .= ' <span class="input-group-prepend"><button type="button"
                                            class="btn quantity-right-plus quantity_cart"
                                            data-product_id="'.$public_customer_cart->cart_product->id.'"
                                            data-prop_type="'.$public_customer_cart->property_type.'"';

                                            // $output .= ;
                                            if(isset($public_customer_cart->cart_product->firstProperty)){

                                                $output .= ' data-property_id="'.$public_customer_cart->cart_product->firstProperty->id.'"';

                                            }else{
                                                $output .= ' data-property_id="'. 2 .'"';

                                            }


                                            $output .= ' data-type="plus" data-field=""><i
                                                class="ti-angle-right"></i></button></span>
                                </div>
                            </div>
                        </td>
                        <td><a class="icon deleteCartItem" data-cart-id="'.$public_customer_cart->id.'"><i class="ti-close"></i></a></td>
                        <td>';
                        if($public_customer_cart->cart_product->on_sale_price_status == 'Active'){
                            $output .= '<h2 class="td-color">'.$public_customer_cart->cart_product->on_sale_price * $public_customer_cart->quantity.'</h2>';
                        }else{
                            $output .= '<h2 class="td-color">'.$public_customer_cart->cart_product->on_sale_price *$public_customer_cart->quantity.'</h2>';
                        }
                            $output .= '</td>
                    </tr>';
                }


                    return response()->json(['status' => true, 'output' => $output,'end_total'=>$endTotal]);
            }
    }

    function addToCartAjax(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'prop_type' => 'required|numeric',
            'property_id' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);


        if (!Auth::guard('customer')->check()) {
            return response()->json(['status' => false]);
        }

        $user = Auth::guard('customer')->user();

        $quantity = $request->quantity;

        $product = Product::find($request->product_id);
        // return $product;
        if ($product) {
            if ($product->properties->count() > 0) {
                if ($request->prop_type == 1) {
                    $property = ProdSzeClrRelation::where('id', $request->property_id)->where('product_id', $product->id)->get()->first();

                    if ($property) {
                        if ($property->quantity_available < $request->quantity) {
                            return response()->json(['status' => false]);
                        }

                        $old_cart = CartTemp::where([['user_id', $user->id], ['user_type', 'Customer'], ['property_type', 1], ['product_id', $request->property_id]])->get()->first();

                        if ($old_cart) {
                            $old_cart->update([
                                'quantity' => $quantity
                            ]);
                        } else {
                            if (isset($user->cartTemps) && $user->cartTemps->count() > 0) {
                                if ($user->cartTemps->count() > 20) {
                                    return response()->json(['status' => false]);
                                }
                            }


                            CartTemp::create([
                                'user_id' => $user->id,
                                'user_type' => 'Customer',
                                'product_id' => $property->id,
                                'property_type' => 1,
                                'quantity' => $quantity,
                            ]);
                        }
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false]);
                    }
                } else {
                    return response()->json(['status' => false]);
                }
            } else {

                if ($request->prop_type == 2) {

                    if ($product->quantity_available < $request->quantity) {
                        return response()->json(['status' => false]);
                    }

                    $old_cart = CartTemp::where([
                        ['user_id', $user->id],
                        ['product_id', $product->id],
                        ['user_type', 'Customer'],
                        ['property_type', 2]
                    ])->get()->first();

                    if ($old_cart) {
                        $old_cart->update([
                            'quantity' => $quantity
                        ]);
                    } else {

                        if (isset($user->cartTemps) && $user->cartTemps->count() >= 20) {
                            return response()->json(['status' => false]);
                        }

                        CartTemp::create([
                            'user_id' => $user->id,
                            'user_type' => 'Customer',
                            'product_id' => $product->id,
                            'property_type' => 2,
                            'quantity' => $quantity,
                        ]);
                    }

                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false]);
                }
            }
        } else {
            return response()->json(['status' => false]);
        }
    }






    function getCartAjax(Request $request)
    {


        $endTotal = 0;

        if (Auth::guard('customer')->check()) {
            $public_customer_carts = CartTemp::where(['user_id' => Auth::guard('customer')->user()->id, 'user_type' => 'Customer'])->get();
            $endTotal = 0;
            foreach ($public_customer_carts as $public_customer_cart) {
                $sub_total = 0;
                if ($public_customer_cart->property_type == 1) {
                    $public_customer_cart->cart_product = ProdSzeClrRelation::find($public_customer_cart->product_id);
                } else {
                    $public_customer_cart->cart_product = Product::find($public_customer_cart->product_id);
                }
                if ($public_customer_cart->cart_product->on_sale_price_status == 'Active') {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                } else {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                }
                $public_customer_cart->sub_total = $sub_total;
            }
            $public_customer_carts->endTotal = $endTotal;
            $public_customer_carts_count = $public_customer_carts->count();

            $public_customer_carts_count = count($public_customer_carts ?? []);

            $output = '';

            $output .= '
            <div class="minicart-header">
                <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                <h4 class="fs-6">';
            if (auth('customer')->user()) {
                if (isset($public_customer_carts) && $public_customer_carts->count() > 0) {
                    $output .= trans('front_end.home_YOUR_CART').'(' .  $public_customer_carts->count();
                }
            }
            $output .=  trans('front_end.home_ITEMS').' )</h4>
            </div>
            <div class="minicart-content">
                <ul class="clearfix">';
            if (auth('customer')->user()) {
                if ($public_customer_carts && $public_customer_carts->count() > 0) {
                    foreach ($public_customer_carts as $public_customer_cart) {
                        $output .= '<li id="cart_' . $public_customer_cart->id . '">
                                <li class="item d-flex justify-content-center align-items-center">
                                <a class="product-image" href="product-layout1.html">';
                        if (isset($public_customer_cart->cart_product->image) && file_exists($public_customer_cart->cart_product->image)) {
                            $output .= ' <img class="blur-up lazyload w-100" src="' . asset($public_customer_cart->cart_product->image) . '" data-src="' . asset($public_customer_cart->cart_product->image) . '" alt="image" title="">';
                        } elseif (isset($public_customer_cart->cart_product->image_url)) {
                            $output .= '<img alt="" class="blur-up lazyload w-100"src="' . $public_customer_cart->cart_product->image_url . '">';
                        } else {
                            $output .= '<img alt="" class="blur-up lazyload w-100"src="' . asset('front_end_style/assets/images/fashion/product/1.jpg') . '">';
                        }
                        $output .= '  </a> <div class="product-details">
                                          <a class="product-title" href="product-layout1.html">' .  $public_customer_cart->cart_product->name . '</a>';


                        $output .= '<div class="priceRow rlt_price">
                        <div class="product-price">';
                        if ($public_customer_cart->cart_product->on_sale_price_status == 'Active'){
                            $output .= '<span class="money">'. $public_customer_cart->quantity.'x ' ;
                            $output .= trans('front_end.home_SAR').'

                                '. $public_customer_cart->cart_product->on_sale_price .'</span>';
                        }else{
                            $output .= '<span class="money">'. $public_customer_cart->quantity.''.'x ';
                            $output .=   trans('front_end.home_SAR').'
                                '. $public_customer_cart->cart_product->sale_price .'</span>';
                        }
                        $output .= '


                                        </div>
                                    </div>
                                </div>
                                <div class="qtyDetail text-center">
                                            <a href="#" class="remove deleteCartItem" data-cart-id="'.$public_customer_cart->id.'"><i class="fa fa-close" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                                        </div>

                            </li>

                            </li>';
                    }
                    $output .= '</ul>

            <div class="minicart-bottom">

                <div class="subtotal">
                    <span>'.trans('front_end.home_TOTAL').'</span>
                    <span class="product-price">';
                    $output .=  $endTotal;
                    $output .= trans('front_end.home_SAR').'  </span>
                </div>
                <a href="' . route('customer.checkoutPage') . '" class="w-100 p-2 my-2 btn btn-outline proceed-to-checkout rounded">';
                $output .= trans('front_end.home_Proceed_to_Checkout').'</a>
                <a href="cart-style1.html" class="w-100 btn btn-solid btn-xs cart-btn rounded">';
                $output .=trans('front_end.home_view_cart').'</a>
            </div>';


                    return response()->json(['status' => true, 'output' => $output]);
                }
            }
        }
    }


    function getCartAjax_old(Request $request)
    {


        $endTotal = 0;

        if (Auth::guard('customer')->check()) {
            $public_customer_carts = CartTemp::where(['user_id' => Auth::guard('customer')->user()->id, 'user_type' => 'Customer'])->get();
            $endTotal = 0;
            foreach ($public_customer_carts as $public_customer_cart) {
                $sub_total = 0;
                if ($public_customer_cart->property_type == 1) {
                    $public_customer_cart->cart_product = ProdSzeClrRelation::find($public_customer_cart->product_id);
                } else {
                    $public_customer_cart->cart_product = Product::find($public_customer_cart->product_id);
                }
                if ($public_customer_cart->cart_product->on_sale_price_status == 'Active') {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->on_sale_price;
                } else {
                    $endTotal += $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                    $sub_total = $public_customer_cart->quantity * $public_customer_cart->cart_product->sale_price;
                }
                $public_customer_cart->sub_total = $sub_total;
            }
            $public_customer_carts->endTotal = $endTotal;
            $public_customer_carts_count = $public_customer_carts->count();

            $public_customer_carts_count = count($public_customer_carts ?? []);

            $output = '';

            $output .= '<div id="cart-drawer" class="block block-cart">
            <div class="minicart-header">
                <a href="javascript:void(0);" class="close-cart" data-bs-dismiss="modal" aria-label="Close"><i class="an an-times-r" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="left" title="Close"></i></a>
                <h4 class="fs-6">';
            if (auth('customer')->user()) {
                if (isset($public_customer_carts) && $public_customer_carts->count() > 0) {
                    $output .= 'Your cart (' .  $public_customer_carts->count();
                }
            }
            $output .= 'Items)</h4>
            </div>
            <div class="minicart-content">
                <ul class="clearfix">';
            if (auth('customer')->user()) {
                if ($public_customer_carts && $public_customer_carts->count() > 0) {
                    foreach ($public_customer_carts as $public_customer_cart) {
                        $output .= '<li id="cart_' . $public_customer_cart->id . '">
                                <li class="item d-flex justify-content-center align-items-center">
                                <a class="product-image" href="product-layout1.html">';
                        if (isset($public_customer_cart->cart_product->image) && file_exists($public_customer_cart->cart_product->image)) {
                            $output .= ' <img class="blur-up lazyload w-100" src="' . asset($public_customer_cart->cart_product->image) . '" data-src="' . asset($public_customer_cart->cart_product->image) . '" alt="image" title="">';
                        } elseif (isset($public_customer_cart->cart_product->image_url)) {
                            $output .= '<img alt="" class="blur-up lazyload w-100"src="' . $public_customer_cart->cart_product->image_url . '">';
                        } else {
                            $output .= '<img alt="" class="blur-up lazyload w-100"src="' . asset('front_end_style/assets/images/fashion/product/1.jpg') . '">';
                        }
                        $output .= '  </a> <div class="product-details">
                                          <a class="product-title" href="product-layout1.html">' .  $public_customer_cart->cart_product->name . '</a>';


                        $output .= '<div class="priceRow">
                                                <div class="product-price">
                                                     <span class="money">' . $public_customer_cart->quantity . ' X ' . $public_customer_cart->cart_product->sale_price . '</span>';


                        $output .= '
                                        </div>
                                    </div>
                                </div>
                                <div class="qtyDetail text-center">
                                            <a href="#" class="remove deleteCartItem" data-cart-id="'.$public_customer_cart->id.'"><i class="fa fa-close" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove"></i></a>
                                        </div>

                            </li>

                            </li>';
                    }
                    $output .= '</ul>
            </div>
            <div class="minicart-bottom">

                <div class="subtotal">
                    <span>Total:</span>
                    <span class="product-price">';
                    $output .=  $endTotal;
                    $output .= ' SAR </span>
                </div>
                <a href="' . route('customer.checkoutPage') . '" class="w-100 p-2 my-2 btn btn-outline proceed-to-checkout rounded">Proceed to Checkout</a>
                <a href="cart-style1.html" class="w-100 btn btn-solid btn-xs cart-btn rounded">View Cart</a>
            </div>';


                    return response()->json(['status' => true, 'output' => $output]);
                }
            }
        }
    }


}
