<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
        ]);

        if ($validation->fails()){

            return  response()->json(['errors' => $validation->errors()]);
        }
        return Product::create($request->all());
    }


    public function show($id)
    {
        try {
            return Product::findOrFail($id);
        }catch (ModelNotFoundException $exception){
            return  response()->json(['errors' => 'products not founded!']);
        }
    }


    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(),[
            'name' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'product_id' => [Rule::exists('products','id')]
        ]);

        if ($validation->fails()){

            return  response()->json(['errors' => $validation->errors()]);
        }

        try {

            return Product::findOrFail($id)->update($request->all());

        }catch (ModelNotFoundException $exception){

            return  response()->json(['errors' => 'products not founded!']);
        }


    }


    public function destroy($id)
    {
        try {

            return Product::findOrFail($id)->delete();

        }catch (ModelNotFoundException $exception){

            return  response()->json(['errors' => 'products not founded!']);
        }
    }
}
