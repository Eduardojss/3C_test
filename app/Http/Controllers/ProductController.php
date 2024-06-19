<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 12);

        $products = Product::orderByDesc('created_at')->paginate($perPage);

        return response()->json([
            'products' => $products->items(),
            'meta' => [
                'itemsPerPage' => $products->perPage(),
                'actualPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'total' => $products->total(),
                'nextPage' => $products->nextPageUrl()
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'required|sometimes|max:500',
            'price' => 'required|numeric',
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            $newProduct = Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'price' => $validatedData['price'],
                'user_id' => $user->id
            ]);

            DB::commit();

            return response()->json([
                'createdProduct' => $newProduct,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function show(string $id)
    {
        if(!$id){
            return response()->json([
                'message' => 'Identifier not found',
                'success' => false
            ], 400);
        }

        try{
            $product = Product::where('id', $id)->first();

            if(!$product || empty($product)){
                return response()->json([
                    'success' => false
                ], 204);
            }

            return response()->json([
                'productDetails' => $product
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|sometimes|string|max:120',
            'description' => 'required|sometimes|max:500',
            'price' => 'required|sometimes|numeric',
        ]);

        if (!$id) {
            return response()->json([
                'message' => 'Identifier not found',
                'success' => false
            ], 400);
        }

        $user = Auth::user();

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->where('user_id', $user->id)->first();

            if (!$product || empty($product)) {
                return response()->json([
                    'success' => false
                ], 204);
            }

            $product->update($validatedData);
            $product->save();

            DB::commit();
            return response()->json([
                'updatedProduct' => $product
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        if (!$id) {
            return response()->json([
                'message' => 'Identifier not found',
                'success' => false
            ], 400);
        }

        $user = Auth::user();

        try {
            DB::beginTransaction();
            $product = Product::where('id', $id)->where('user_id', $user->id)->first();

            if (!$product || empty($product)) {
                return response()->json([
                    'success' => false
                ], 204);
            }

            $product->delete();
            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function search(Request $request){
        $validatedData = $request->validate([
            'searchTerm' => 'required|string'
        ]);
        try {
            $products = Product::where('name', 'like', '%'.$validatedData['searchTerm'].'%')->orWhere('description', 'like', '%' . $validatedData['searchTerm'] . '%')->get();
            return response()->json([
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}
