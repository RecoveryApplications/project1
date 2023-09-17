<?php

namespace App\Http\Controllers\Backend\Admin;

use Exception;
use App\Models\Product;
use App\Models\CartSale;
use App\Models\Category;
use App\Models\MainSize;
use App\Models\MainColor;
use App\Models\ProductImage;
use App\Traits\SharedMethod;
use Illuminate\Http\Request;
use App\Models\CartOperation;
use App\Models\PropertyImage;
use App\Models\SuperCategory;
use App\Models\SupportTicket;
use Illuminate\Routing\Route;
use App\Traits\UploadImageTrait;
use App\Models\ProdSzeClrRelation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\Backend\Products\StoreProductFormRequest;
use App\Http\Requests\Backend\Products\UpdateProductFormRequest;
use App\Http\Requests\Backend\Products\StoreImageProductFormRequest;
use App\Http\Requests\Backend\Products\ProductPropertiesStorFromRequest;
use App\Http\Requests\Backend\Products\ProductPropertiesUpdateFromRequest;
use App\Http\Requests\Backend\ProprtyImages\StoreImagePropertyFormRequest;
use App\Models\Brand;
use App\Models\MainCategory;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    use UploadImageTrait;
    use SharedMethod;

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function index(Request $request, Route $route)
    {
        try {
            if (request()->isMethod('post')) {
                // Handle the form submission by triggering the update process
                return $this->updateItems();
            }
            $products = Product::select('*')->orderBy('created_at', 'desc')->paginate(100);
            return view('admin.products.index', compact('products'));
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
            $categories = MainCategory::get();
            $colors = MainColor::get();
            $sizes = MainSize::get();
            return view('admin.products.create', compact('categories', 'colors', 'sizes'));
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
    // ======================= import Xlsx Function ===================
    // ================================================================
    public  $Mistakes = '';
    public $Successfully = '';
    public function importXlsx(Route $route)
    {
        try {


            return view('admin.products.importXlsx')->with('Successfully', '')->with('Mistakes', '');
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
    // ======================= import Xlsx Store Function =============
    // ================================================================

    public $count = 0;
    public function importXlsxStore(Request $request, Route $route)
    {
        $request->validate([
            'file_xlsx' => 'required'
        ]);

        try {

            $Product = (new FastExcel)->import($request->file_xlsx, function ($line) {
                $this->count += 1;
                try {
                    $created_data = [
                        'super_category_id' => asset($line['super_category_id']) ? $line['super_category_id'] : 1,
                        'main_category_id' => asset($line['main_category_id']) ? $line['main_category_id'] : 1,
                        'sub_category_id' => asset($line['sub_category_id']) ? $line['sub_category_id'] : null,
                        'name_en' => asset($line['name_en']) ? $line['name_en'] : null,
                        'name_ar' => asset($line['name_ar']) ? $line['name_ar'] : null,
                        'main_description_en' => asset($line['main_description_en']) ? $line['main_description_en'] : null,
                        'main_description_ar' => asset($line['main_description_ar']) ? $line['main_description_ar'] : null,
                        'sub_description_en' => asset($line['sub_description_en']) ? $line['sub_description_en'] : null,
                        'sub_description_ar' => asset($line['sub_description_ar']) ? $line['sub_description_ar'] : null,
                        'sale_price' => asset($line['sale_price']) ? $line['sale_price'] : null,
                        'on_sale_price_status' => asset($line['on_sale_price_status']) ? $line['on_sale_price_status'] : null,
                        'on_sale_price' => asset($line['on_sale_price']) ? $line['on_sale_price'] : null,
                        'quantity_available' => asset($line['quantity_available']) ? $line['quantity_available'] : null,
                        'image_url' => asset($line['image_url']) ? $line['image_url'] : null,
                        'status' => asset($line['status']) ? $line['status'] : null,
                        'updated_by' => 1,
                        'brand_id' => asset($line['brand_id']) ? $line['brand_id'] : null,
                        'size_id' => asset($line['size_id']) ? $line['size_id'] : null,
                        'color_id' => asset($line['color_id']) ? $line['color_id'] : null,
                        'private_info' => asset($line['private_info']) ? $line['private_info'] : null,
                    ];
                    $this->Successfully .= 'The product has been added : ' . isset($line['name_en']) && $line['name_en'] ? $line['name_en'] . '                      ' : '';

                    Product::create($created_data);
                } catch (Exception $e) {
                    $this->Mistakes .= isset($line['name_en']) && $line['name_en'] ? $line['name_en'] . '                                   ' : 'Unknown line error(' . $this->count . ')';
                }
            });
            return view('admin.products.importXlsx')->with('Successfully', $this->Successfully)->with('Mistakes', $this->Mistakes);
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
    public function store(StoreProductFormRequest $request, Route $route)
    {
        try {
            // Upload Image Section :
            if (isset($request->image)) {
                $orginal_image = $request->file('image');
                $upload_location = 'storage/products/';
                $original_name = $orginal_image->getClientOriginalName();
                $last_image = $this->saveFileWithOriginalName('products', 'image', $orginal_image, $original_name, $upload_location);
            } else {
                $last_image = null;
            }

            $created_data = [
                'main_category_id' => $request->main_category_id,
                'sub_category_id' => $request->sub_category_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'main_description_en' => $request->main_description_en,
                'main_description_ar' => $request->main_description_ar,
                'sub_description_en' => $request->sub_description_en,
                'sub_description_ar' => $request->sub_description_ar,
                'sale_price' => $request->sale_price,
                'on_sale_price_status' => $request->on_sale_price_status,
                'on_sale_price' => $request->on_sale_price,
                'quantity_available' => $request->quantity_available,
                'image' => $last_image,
                'image_url' => $request->image_url,
                'status' => $request->status,
                'updated_by' => auth()->user()->id,
                'brand_id' => $request->brand_id,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
                'private_info' => $request->private_info,
                'featured_flag' => $request->featured_flag,
                'weight' => $request->weight,
                'gender' => $request->gender,
                'slug_ar' => $this->generateSlugAr($request->name_ar),
                'slug_en' => $this->generateSlugEn($request->name_en),
                'seo_title_ar'=> $request->seo_title_ar,
                'seo_title_en'=> $request->seo_title_en,
                'keywords_ar'=> $request->keywords_ar,
                'keywords_en'=> $request->keywords_en,
                'meta_desc_ar' => $request->meta_desc_ar,
                'meta_desc_en' => $request->meta_desc_en,
                'tags' => $request->tags
            ];

            DB::transaction(function () use ($created_data) {
                Product::create($created_data);
            });

            return redirect()->route('super_admin.products-index')->with('success', 'The data has been successfully updated');
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
            $product = Product::find($id);
            $penddingOrders = CartOperation::where('product_id', $id)->orderBy('created_at', 'desc')->get(); // 1 => Pendding
            foreach ($penddingOrders as $key => $penddingOrder) {
                if ($penddingOrder->cartSale->status != 'Pendding') {
                    $penddingOrders->forget($key);
                }
            }
            $acceptedOrders = CartOperation::where('product_id', $id)->orderBy('created_at', 'desc')->get(); // 1 => Pendding
            foreach ($acceptedOrders as $key => $acceptedOrder) {
                if ($acceptedOrder->cartSale->status != 'Accepted') {
                    $acceptedOrders->forget($key);
                }
            }

            $deliveryOrders = CartOperation::where('product_id', $id)->orderBy('created_at', 'desc')->get(); // 1 => Pendding
            foreach ($deliveryOrders as $key => $deliveryOrder) {
                if ($deliveryOrder->cartSale->delivery_status != 'Pendding' && $deliveryOrder->cartSale->delivery_status != 'In Progress') {
                    $deliveryOrders->forget($key);
                }
            }
            $rates = $product->review;
            if ($product) {
                return view('admin.products.show', compact('product', 'penddingOrders', 'acceptedOrders', 'deliveryOrders', 'rates'));
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
    // ======================== Edit Function =========================
    // ================================================================
    public function edit($product_id, Route $route)
    {
        try {
            // $categories = SuperCategory::get();
            $product = Product::find($product_id);
            $colors = MainColor::get();
            $sizes = MainSize::get();
            if ($product) {
                return view('admin.products.edit', compact('product', 'sizes', 'colors'));
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
    // ======================= Update Function ========================
    // ================================================================
    public function update($product_id, UpdateProductFormRequest $request, Route $route)
    {
        try {
            $product = Product::find($product_id);
            if ($product) {
                // Standard Updated Data :
                // $update_data['super_category_id'] = $request->super_category_id;
                $update_data['main_category_id'] = $request->main_category_id;
                $update_data['sub_category_id'] = $request->sub_category_id;
                $update_data['name_en'] = $request->name_en;
                $update_data['name_ar'] = $request->name_ar;
                $update_data['main_description_en'] = $request->main_description_en;
                $update_data['main_description_ar'] = $request->main_description_ar;
                $update_data['sub_description_en'] = $request->sub_description_en;
                $update_data['sub_description_ar'] = $request->sub_description_ar;
                // $update_data['weight'] = $request->weight;
                $update_data['sale_price'] = $request->sale_price;
                $update_data['on_sale_price_status'] = $request->on_sale_price_status;
                $update_data['on_sale_price'] = $request->on_sale_price;
                $update_data['quantity_available'] = $request->quantity_available;
                // $update_data['quantity_limit'] = $request->quantity_limit;
                $update_data['status'] = $request->status;
                $update_data['featured_flag'] = $request->featured_flag;
                $update_data['weight'] = $request->weight;
                $update_data['gender'] = $request->gender;

                // Added After Migrate :
                // $update_data['weight_unit'] = $request->weight_unit;
                // $update_data['ingredient_en'] = $request->ingredient_en;
                // $update_data['benefit_en'] = $request->benefit_en;
                $update_data['brand_id'] = $request->brand_id;
                $update_data['size_id'] = $request->size_id;
                $update_data['color_id'] = $request->color_id;
                $update_data['image_url'] = $request->image_url;
                $update_data['private_info'] = $request->private_info;
                $update_data['slug_ar'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->name_ar);
                $update_data['slug_en'] = str_replace(array(' ','"','>','<','#','%','|','/'),'-',$request->name_en);
                $update_data['seo_title_ar'] = $request->seo_title_ar;
                $update_data['seo_title_en'] = $request->seo_title_en;
                $update_data['keywords_ar'] = $request->keywords_ar;
                $update_data['keywords_en'] = $request->keywords_en;
                $update_data['meta_desc_ar'] = $request->meta_desc_ar;
                $update_data['meta_desc_en'] = $request->meta_desc_en;
                // Upload Image Section :
                if (isset($request->image)) {
                    $orginal_image = $request->file('image');
                    $upload_location = 'storage/products/';
                    $original_name = $orginal_image->getClientOriginalName();
                    $update_data['image'] = $this->saveFileWithOriginalName('products', 'image', $orginal_image, $original_name, $upload_location);
                    File::delete($product->image);
                }

                DB::table('products')->where('id', $product_id)->update($update_data);

                return redirect()->route('super_admin.products-index')->with('success', 'The data has been successfully updated');
            } else {
                return redirect()->route('super_admin.products-index')->with('danger', 'This record does not exist in the records');
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
    // ================== Active/Inactive Single ======================
    // ================================================================
    public function activeInactiveSingle($product_id, Route $route)
    {
        try {
            $product = Product::find($product_id);
            if ($product) {
                if ($product->status == 'Active') {
                    $product->status = 2;  // 2 => Inactive
                    $product->save();
                } elseif ($product->status == 'Inactive') {
                    $product->status = 1;  // 1 => Active
                    $product->save();
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

    // ================================================================
    // ===================== Soft Delete Function =====================
    // ================================================================
    public function softDelete($id, Route $route)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                DB::transaction(function () use ($product) {
                    $product->delete();
                });
                return redirect()->route('super_admin.products-index')->with('success', 'The deletion process has been successful');
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
    // ====================== Show Soft Delete ========================
    // ================================================================
    public function showSoftDelete(Request $request, Route $route)
    {
        try {
            $products = new Product();
            $products = $products->onlyTrashed()->select('*')->orderBy('created_at', 'asc')->get();
            return view('admin.products.trashed', compact('products'));
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
            $product = Product::onlyTrashed()->find($id);
            if ($product) {
                $product->restore();
                return redirect()->route('super_admin.products-index')->with('success', 'Restore Completed Successfully');
            } else {
                return redirect()->route('super_admin.products-index')->with('danger', 'This section does not exist in the records');
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

    // ========================================================================
    // ========================== Destroy Function ============================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    public function destroy($category_id, Route $route)
    {
        try {
            $product = Product::where('id', $category_id)->withTrashed()->get()->first();
            if ($product) {
                File::delete($product->image);
                $product->forceDelete();
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

    // ========================================================================
    // ====================== Add Other Images Function =======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    public function AddImages(StoreImageProductFormRequest $request, $id, Route $route)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                // Upload Image :
                if (isset($request->product_other_images)) {
                    $request_data = [
                        'product_id' => $id,
                    ];
                    foreach ($request->product_other_images as $key => $value) {
                        $orginal_image = $value;
                        $upload_location = 'storage/products/product_other_images/';
                        $original_name = $orginal_image->getClientOriginalName();
                        $request_data['image'] = $this->saveFileWithOriginalName('product_images', 'image', $orginal_image, $original_name, $upload_location);
                        DB::transaction(function () use ($request_data) {
                            ProductImage::create($request_data);
                        });
                    }
                } else {
                    return redirect()->back()->with('danger', 'You must add an ImageS');
                }
                return redirect()->back()->with('success', 'The data has been successfully Added');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ========================================================================
    // ==================== Delete Other Images Function ======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    public function deleteImages($id, Route $route)
    {
        try {
            // check if id exists and deleted it :
            $image = ProductImage::findOrFail($id);
            if ($image) {
                DB::transaction(function () use ($image) {
                    $image->delete();
                    File::delete($image->image);
                });
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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



    // ========================================================================
    // ==================== get Sub Categories Function =======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    function getSubCategories(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required',
        ]);

        $subCategories = Category::where('main_category_id', $request->main_category_id)->get();

        if ($subCategories && $subCategories->count() > 0) {
            return response()->json(['status' => true, 'subCategories' => $subCategories]);
        } else {

            return response()->json(['status' => true, 'subCategories' => []]);
        }
    }
    // ========================================================================
    // ==================== get Brands Function =======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    function getBrand(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required',
        ]);

        $brands = Brand::where('main_category_id', $request->main_category_id)->get();

        if ($brands && $brands->count() > 0) {
            return response()->json(['status' => true, 'brands' => $brands]);
        } else {

            return response()->json(['status' => true, 'brands' => []]);
        }
    }


    // ========================================================================
    // ==================== Get Product Properties Function ===================
    // ===================== Created By : Mohammed Salah ======================
    // ========================================================================
    function properties($id, Route $route)
    {

        try {

            $product = Product::find($id);

            if ($product) {
                return view('admin.products.properties', compact('product'));
            } else {
                return redirect()->back()->with('danger', 'The Record Not Found');
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



    function propertiesCreate($id)
    {

        $product = Product::find($id);

        if ($product) {

            $sizes = MainSize::get();
            $colors = MainColor::get();

            return view('admin.products.create_property', compact('product', 'sizes', 'colors'));
        } else {
            return redirect()->back()->with('danger', 'The Record Not Found');
        }
    }



    function propertiesStore(ProductPropertiesStorFromRequest $request, $id, Route $route)
    {


        if (isset($request->image)) {
            $orginal_image = $request->file('image');
            $upload_location = 'storage/properties/';
            $original_name = $orginal_image->getClientOriginalName();
            $last_image = $this->saveFileWithOriginalName('prod_sze_clr_relations', 'image', $orginal_image, $original_name, $upload_location);
        } else {
            $last_image = null;
        }

        ProdSzeClrRelation::create([
            'main_size_id' => $request->main_size_id,
            'main_color_id' => $request->main_color_id,
            'product_id' => $request->product_id,
            'status' => $request->status,
            // 'weight' => $request->weight,
            'sale_price' => $request->sale_price,
            'on_sale_price_status' => $request->on_sale_price_status,
            'on_sale_price' => $request->on_sale_price,
            'quantity_available' => $request->quantity_available,
            // 'quantity_limit' => $request->quantity_limit,
            'image' => $last_image,
            'image_url' => $request->image_url,
            'status' => $request->status,
            'updated_by' => auth()->user()->id,
            // 'weight_unit' => $request->weight_unit
        ]);


        return redirect()->route('super_admin.products-properties', $id)->with('success', 'Added Successfully');
    }


    function propertyEdit($id)
    {

        $property = ProdSzeClrRelation::find($id);

        if ($property) {

            $sizes = MainSize::get();
            $colors = MainColor::get();

            return view('admin.products.edit_property', compact('property', 'sizes', 'colors'));
        } else {
            return redirect()->back()->with('danger', 'The Record Not Found');
        }
    }



    function propertyUpdate(ProductPropertiesUpdateFromRequest $request, $id)
    {

        $property = ProdSzeClrRelation::find($id);

        if ($property) {

            if (isset($request->image)) {
                File::delete($property->image);
                $orginal_image = $request->file('image');
                $upload_location = 'storage/properties/';
                $original_name = $orginal_image->getClientOriginalName();
                $last_image = $this->saveFileWithOriginalName('prod_sze_clr_relations', 'image', $orginal_image, $original_name, $upload_location);
            } else {
                $last_image = $property->image;
            }

            $property->update([
                'main_size_id' => $request->main_size_id,
                'main_color_id' => $request->main_color_id,
                'status' => $request->status,
                // 'weight' => $request->weight,
                'sale_price' => $request->sale_price,
                'on_sale_price_status' => $request->on_sale_price_status,
                'on_sale_price' => $request->on_sale_price,
                'quantity_available' => $request->quantity_available,
                // 'quantity_limit' => $request->quantity_limit,
                'image' => $last_image,
                'image_url' => $request->image_url,
                'status' => $request->status,
                'updated_by' => auth()->user()->id,
                // 'weight_unit' => $request->weight_unit
            ]);
            return redirect()->route('super_admin.products-properties', $property->product_id)->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('danger', 'Property Not Found In Records');
        }
    }



    function propertyShow($id, Route $route)
    {
        try {
            $property = ProdSzeClrRelation::find($id);

            if ($property) {
                $product = $property->product;
                return view('admin.products.show_property', compact('property', 'product'));
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


    // ========================================================================
    // ====================== Add Other Images Function =======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    public function propertyAddImages(StoreImagePropertyFormRequest $request, $id, Route $route)
    {
        try {
            $property = ProdSzeClrRelation::find($id);
            if ($property) {
                // Upload Image :
                if (isset($request->property_other_images)) {
                    $request_data = [
                        'property_id' => $id,
                    ];
                    foreach ($request->property_other_images as $key => $value) {
                        $orginal_image = $value;
                        $upload_location = 'storage/property/property_other_images/';
                        $original_name = $orginal_image->getClientOriginalName();
                        $request_data['image'] = $this->saveFileWithOriginalName('property_images', 'image', $orginal_image, $original_name, $upload_location);
                        DB::transaction(function () use ($request_data) {
                            PropertyImage::create($request_data);
                        });
                    }
                } else {
                    return redirect()->back()->with('danger', 'You must add an ImageS');
                }
                return redirect()->back()->with('success', 'The data has been successfully Added');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    // ========================================================================
    // ==================== Delete Other Images Function ======================
    // ==================== Created By : Mohammed Salah ======================
    // ========================================================================
    public function propertyDeleteImages($id, Route $route)
    {
        try {
            // check if id exists and deleted it :
            $image = PropertyImage::findOrFail($id);
            if ($image) {
                DB::transaction(function () use ($image) {
                    $image->delete();
                    File::delete($image->image);
                });
                return redirect()->back()->with('success', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('danger', 'This record does not exist in the records');
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
    public function searchProduct(Request $request)
    {

        $products = Product::select('*');


        $search = $request->search;
        if ($search) {
            $products = $products->where('name_en', 'LIKE', '%' . $search . '%');
        }
        $products = $products->get();


        $html = '';
        foreach ($products as $index => $product) {
            $html .=  $this->htmlSearchProduct($product, $index);
        }
        return response()->json(['status' => true, 'products' => $html]);
    }


    public function htmlSearchProduct($item, $index)
    {

        $html = '';
        $html .= '<tr>';
        $html .= '<td>' . $item->id . '</td>';
        $html .= '<td>' . $item->name_en . '</td>';
        $html .= '<td>' . $item->sale_price . '</td>';
        $html .= '<td>' . $item->on_sale_price . '</td>';
        $html .= '<td>';
        $html .= '<img src="' . $item->image . '" width="70" height="50">';
        $html .= '</td><td>';
        if ($item->status == 'Active')
            $html .= '<span style="color: green;">Active</span>';
        else
            $html .= '<span style="color: red;">Inactive</span>';
        $html .= '</td>';

        if ($item?->superCategory?->id)
            $html .= '<td><a href="' . route('super_admin.superCategories-show', [$item->superCategory->id]) . '">' . $item->superCategory?->name_en . '</a></td>';
        else
            $html .= '<td><a href="' . route('super_admin.superCategories-index') . '">' . $item->superCategory?->name_en . '</a></td>';

        if ($item?->mainCategory?->id)
            $html .= '<td><a href="' . route('super_admin.mainCategories-show', [$item->mainCategory->id]) . '">' . $item->mainCategory?->name_en . '</a></td>';
        else
            $html .= '<td><a href="' . route('super_admin.mainCategories-index') . '">' . $item->mainCategory?->name_en . '</a></td>';

        if ($item?->subCategory?->id)
            $html .= '<td><a href="' . route('super_admin.subCategories-show', [$item->subCategory->id]) . '">' . $item->subCategory?->name_en . '</a></td>';
        else
            $html .= '<td><a href="' . route('super_admin.subCategories-index') . '">' . $item->subCategory?->name_en . '</a></td>';

        $html .= '<a href="' . route('super_admin.products-show', [$item->id]) . '" title="Show" class="mb-1 btn btn-sm btn-info"><i class="mdi mdi-eye"></i></a>';
        $html .= '<a href="' . route('super_admin.products-edit', [$item->id]) . '" title="Edit" class="mb-1 btn btn-sm btn-primary"><i class="mdi mdi-playlist-edit"></i></a>';
        $html .= '<a href="' . route('super_admin.products-activeInactiveSingle', [$item->id]) . '" title="Active / Inactive" class="process mb-1 btn btn-sm btn-warning"><i class="mdi mdi-stop"></i></a>';
        $html .= '<a href="' . route('super_admin.products-softDelete', [$item->id]) . '" title="Archive" class="confirm mb-1 btn btn-sm btn-danger"><i class="mdi mdi-close"></i></a>';
        $html .= '<a href="' . route('super_admin.products-properties', [$item->id]) . '" class="mb-1 btn btn-sm btn-secondary">Properties</a>';
        $html .= ' </td> </tr>';
        return $html;
    }

    // ================================================================
    // ======================== index Function ========================
    // ================================================================
    public function productsExport(Request $request, Route $route)
    {
        try {
            $products = Product::select('*');
            $products = $products->orderBy('created_at', 'desc')->get();
            $prod_arr = new Collection();
            foreach ($products as $product) {
                $prod_arr->push([
                    'super_category_id' => $product->super_category_id,
                    'super_category' => $product->superCategory->name_en,
                    'main_category_id' => $product->main_category_id,
                    'main_category' => $product->mainCategory->name_en,
                    'sub_category_id' => $product->sub_category_id,
                    'sub_category' => $product->subCategory->name_en,
                    'name_en' => isset($product->name_en) ? $product->name_en : 'Undefined',
                    'name_ar' => isset($product->name_ar) ? $product->name_ar : 'Undefined',
                    'main_description_en' => isset($product->main_description_en) ? $product->main_description_en : 'Undefined',
                    'main_description_ar' => isset($product->main_description_ar) ? $product->main_description_ar : 'Undefined',
                    'sub_description_en' => $product->sub_description_en,
                    'sub_description_ar' => $product->sub_description_ar,
                    'weight' => $product->weight,
                    'sale_price' => $product->sale_price,
                    'on_sale_price_status' => $product->on_sale_price_status,
                    'on_sale_price' => $product->on_sale_price,
                    'quantity_available' => isset($product->quantity_available) ? $product->quantity_available : 'Undefined',
                    'quantity_limit' => $product->quantity_limit,
                    'image' => $product->image,
                    'image_url' => $product->image_url,
                    'status' => $product->status,
                    'updated_by' => $product->updated_by,
                    'weight_unit' => $product->weight_unit,
                    'featured_flag' => $product->featured_flag,
                    'brand_id' => $product->brand_id,
                    'brand' => isset($product->brand) ? $product->brand->name_en : 'Undefined',
                    'color_id' => $product->color_id,
                    'color' => isset($product->productColor) ? $product->productColor->name_en : 'Undefined',
                    'size_id' => $product->size_id,
                    'size' => isset($product->productSize) ? $product->productSize->name_en : 'Undefined',
                    'private_info' => $product->private_info,
                    'weight' => $product->weight,
                    'gender' => $product->gender,
                ]);
            }
            return (new FastExcel($prod_arr))->download("products.xlsx");
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

     // Generate Slugs
     private function generateSlugAr($name)
     {
         $slug = str_replace(array(' ', '"', '>', '<', '#', '%', '|', '/'), '-',$name);

         $count = 0;
         $old = Product::where('slug_ar','like', '%' . $slug . '%')->first();
         if($old){
             $max = Product::where('slug_ar','like', '%' . $slug . '%')->count();
             if (isset($max) && is_numeric($max)) {
                 $count = $max + 1;
             }
         }
         if($count == 0){
             return $slug;
         }else{
             return $slug.'-'.$count;
         }
     }

     private function generateSlugEn($name)
     {
         $slug = str_replace(array(' ', '"', '>', '<', '#', '%', '|', '/'), '-',$name);
         $count = 0;

         $old = Product::where('slug_en','like', '%' . $slug . '%')->first();
         if($old){
             $max =  Product::where('slug_en','like', '%' . $slug . '%')->count();
             if (isset($max) && is_numeric($max)) {
                 $count = $max + 1;
             }
         }

         if($count == 0){
             return $slug;
         }else{
             return $slug.'-'.$count;
         }
     }
     public function updateItems()
     {
         // Retrieve all items from the database
         $products = Product::get();

         // Perform updates on each item
         foreach ($products as $product) {

              $product->update([
                'slug_ar'=>str_replace(array(' ','"','>','<','#','%','|','/'),'-',$product->name_ar),
                'slug_en'=>str_replace(array(' ','"','>','<','#','%','|','/'),'-',$product->name_en)
            ]);

         }
        //  return( $products);
         // Redirect back or return a response
         return redirect()->back()->with('success', 'Items updated successfully.');
     }
}
