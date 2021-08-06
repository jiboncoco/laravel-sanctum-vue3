<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get data from table products
        $products = Product::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data'    => $products  
        ], 200);

    }
    
     /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find product by ID
        $product = Product::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Product',
            'data'    => $product 
        ], 200);

    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'category' => 'required',
            'description'   => 'required',
            'image' => 'required',
            'color'   => 'required',
            'size' => 'required',
            'price' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $product = Product::create([
            'name'     => $request->name,
            'category'   => $request->category,
            'description'     => $request->description,
            'image'   => $request->image,
            'color'     => $request->color,
            'size'   => $request->size,
            'price'   => $request->price,
        ]);

        //success save to database
        if($product) {

            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data'    => $product  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Product Failed to Save',
        ], 409);

    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function update(Request $request, Product $product)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'category' => 'required',
            'description'   => 'required',
            'image' => 'required',
            'color'   => 'required',
            'size' => 'required',
            'price' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find product by ID
        $product = Product::findOrFail($product->id);

        if($product) {

            //update product
            $product->update([
                'name'     => $request->name,
                'category'   => $request->category,
                'description'     => $request->description,
                'image'   => $request->image,
                'color'     => $request->color,
                'size'   => $request->size,
                'price'   => $request->price,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product Updated',
                'data'    => $product  
            ], 200);

        }

        //data product not found
        return response()->json([
            'success' => false,
            'message' => 'Product Not Found',
        ], 404);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find product by ID
        $product = Product::findOrfail($id);

        if($product) {

            //delete product
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product Deleted',
            ], 200);

        }

        //data product not found
        return response()->json([
            'success' => false,
            'message' => 'Product Not Found',
        ], 404);
    }
}
