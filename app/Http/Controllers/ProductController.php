<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->product_name) {
    		$query = Product::byInquire($request->product_name);
    		if ($request->category) {
    			$query->byCategory($request->category);
    		}
    		$products = $query->paginate(9);
    		return view('pages.products.index', compact('products'));
    	}
        $categories = Category::all();
    	$products = Product::paginate(9);
        return view('pages.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $product = Product::findOrFail($id);
      $categories = Category::all();
      return view('pages.products.show')
            ->with('product',$product)
            ->with('categories',$categories);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
		$query = Product::byInquire($request->product_name);
		if ($request->category) {
			$query->byCategory($request->category);
		}
		$products = $query->paginate(9);
        $categories = Category::all();
        return view('pages.products.index', compact('products', 'categories'));
		// return view('pages.products.search', compact('products'));
    }

    public function list(Request $request)
    {
      $products = Product::paginate(9);
      $categories = Category::all();
      return view('pages.products.index', compact('products', 'categories'));
    }

    /**
     * Provides with product image by product id
     */
    public function getProductImage($imageId)
    {
        $image = \App\Models\ProductImage::findOrFail($imageId);
        $filepath = "productImages/{$image->image}";
        $file = \Illuminate\Support\Facades\Storage::disk('public')->path($filepath);
        return response()->download($file);
    }
    
    /**
     * Store order 
     */
    public function addOrder(Request $request)
    {
        $order = new \App\Models\Order($request->all());
        $order->save();
        $message = [
            'type' => 'success',
            'message' =>'Заявка оставлена',
        ];
        return redirect()->back()->with(compact('message'));
    }
}
