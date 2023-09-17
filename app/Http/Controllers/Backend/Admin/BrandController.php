<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Brands\BrandStoreFromRequest;
use App\Models\Brand;
use App\Models\MainCategory;
use App\Models\SuperCategory;
use App\Traits\GeneralTrait;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    use GeneralTrait;
    use UploadImageTrait;

    function index()
    {

        $brands = new Brand();
        // $x=$brands->mainCategory->
        // return $x;
        $brands = $brands->select('*')->orderBy('created_at', 'asc')->paginate(100);

        return view('admin.brands.index', compact('brands'));
    }



    function create()
    {
        $categories = MainCategory::get();

        return view('admin.brands.create', compact('categories'));
    }

    function store(BrandStoreFromRequest $request)
    {

        // return $request;
        $image = null;

        // Upload Image Section :
        if (isset($request->image)) {
            $orginal_image = $request->file('image');
            $upload_location = 'storage/brands/';
            $original_name = $orginal_image->getClientOriginalName();
            $image = $this->saveFileWithOriginalName('brands', 'image', $orginal_image, $original_name, $upload_location);
        } else {
            $image = null;
        }

        Brand::create([
            'name_en' => $request->name_en,
            'status' => $request->status,
            'image' => $image,
            'main_category_id' => $request->main_category_id
        ]);

        return redirect()->route('super_admin.brands-index')->with('success', 'Added Successfully');
    }



    function edit($id)
    {
        $categories = MainCategory::get();
        $brand = Brand::find($id);
        return view('admin.brands.edit', compact('brand', 'categories'));
    }


    function update($id, Request $request)
    {
        $brand = Brand::find($id);
        if ($brand) {
            // return $request;
            $image = null;

            // Upload Image Section :
            if (isset($request->image)) {
                $orginal_image = $request->file('image');
                $upload_location = 'storage/brands/';
                $original_name = $orginal_image->getClientOriginalName();
                $image = $this->saveFileWithOriginalName('brands', 'image', $orginal_image, $original_name, $upload_location);
            } else {
                $image = $brand->image;
            }


            $brand->update([
                'name_en' => $request->name_en,
                'status' => $request->status,
                'image' => $image,
                'main_category_id' => $request->main_category_id
            ]);


            return redirect()->route('super_admin.brands-index')->with('success', 'Updated Successfully');
        } else {
            return redirect()->back()->with('danger', "The Record Not Found !!!!");
        }
    }




    function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand) {

            File::delete($brand->image);
            $brand->delete();

            return redirect()->route('super_admin.brands-index')->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('danger', "The Record Not Found !!!!");
        }
    }

    public function searchBrand(Request $request)
    {

        $brands = Brand::select('*');


        $search = $request->search;
        if ($search) {
            $brands = $brands->where('name_en', 'LIKE', '%' . $search . '%');
        }
        $brands = $brands->get();


        $html = '';
        foreach ($brands as $index => $brand) {
            $html .=  $this->htmlSearchBrand($brand, $index);
        }
        return response()->json(['status' => true, 'products' => $html]);
    }


    public function htmlSearchBrand($item, $index)
    {

        $html = '';
        $html .= '<tr role="row" class="even">';
        $html .= '<td class="sorting_1">' . $index . '</td>';
        $html .= '<td><span style="color:';

        $html .= $item?->superCategory?->name != null ?'' : 'red' ;
        $html .=';">';
        $html .= $item?->superCategory?->name != null ? $item?->superCategory?->name  : 'Undefined';
        $html .= ' </span></td>';
        $html .= '<td>' . $item->name_en . '</td>';
        $html .= '<td> <img src="' . $item->image . '" width="70" height="50"> </td>';
        $html .= '<td> <span style="color:';
        $html .= $item->status == 1 ? 'green' : 'red';
        $html .= ';">';
        $html .= $item->status == 1 ? 'Active' : 'InActive';
        $html .= '</span> </td> <td>';
        $html .= '<a href="';
        $html .= route('super_admin.brands-edit', $item->id);
        $html .= '" title="Edit" class="mb-1 btn btn-sm btn-primary"><i class="mdi mdi-playlist-edit"></i></a>';
        $html .= '<a href="';
        $html .= route('super_admin.brands-destroy', $item->id);
        $html .= '" title="Archive" class="confirm mb-1 btn btn-sm btn-danger"><i class="mdi mdi-close"></i></a>';
        $html .= '</td> </tr>';
        return $html;
    }
}
