<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = $request->validate(Product::$rules);
        try {
            \DB::transaction(function () use ($request) {
                $model = Product::create($request->all());
                if ($request->newPictures){
                    foreach ($request->newPictures as $image) {
                        $file_name = 'prodIMG_'.uniqid() .'.png';  
                        $content = file_get_contents($image);
                        $file = Storage::disk('public')->put('productImages/'.$file_name, $content);

                        ProductImage::create([
                            'product_id' => $model->id,
                            'image' => $file_name,
                            'image_alt' => $model->name_en.'_img',
                        ]);
                    }   
                }
                if($request->categoryId){
                    $categories = Category::find($request->categoryId);
                    $model->categories()->attach($categories);
                }
                
            });
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => json_decode($e->getMessage()) ? : $e->getMessage(),
            ]);
        }
        return response()->json([
            'success' => true
        ], Response::HTTP_CREATED);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.pages.products.edit',[
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function productUpdate(Request $request, $id)
    {   
        $validator = $request->validate(Product::$rules);
        try {
            \DB::transaction(function () use ($request, $id) {
                $model = Product::find($id);
                $model->update($request->all());
                if ($request->newPictures){
                    foreach ($request->newPictures as $image) {
                        $file_name = 'prodIMG_'.uniqid() .'.png';  
                        $content = file_get_contents($image);
                        $file = Storage::disk('public')->put('productImages/'.$file_name, $content);

                        ProductImage::create([
                            'product_id' => $model->id,
                            'image' => $file_name,
                            'image_alt' => $model->name_en.'_img',
                        ]);
                    }   
                }
                if($request->categoryId){
                $model->categories()->sync($request->categoryId);
                }

            });   
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => json_decode($e->getMessage()) ? : $e->getMessage(),
            ]);
        }
        return response()->json([
            'success' => true
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->categories()->detach();
        $product->images()->delete();
        Storage::disk('public')->deleteDirectory('productImages/prod_'.$product->id.'/');
        $product->delete();
        return response()->json(['success' => 'success'], Response::HTTP_OK);
    }

    public function productsData(Request $request)
    {   
        $relations = [];
        $scopes = [];
        $builder = new \Builders\VGTBuilder(Product::class, $relations, json_decode($request->queryParams));
        $products = $builder->get($scopes);

        return response()->json($products['data'], $products['response']);
    }

    public function productData(Request $request, $id)
    {   
        $relations = ['images', 'categories'];
        $product = Product::with($relations)->find($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function deleteImg(Request $request, $id)
    {   
        
        $image = ProductImage::findOrFail($request->imageId);
        Storage::disk('public')->delete('productImages/'.$image->image);
        $image->delete();
        $images = Product::findOrFail($id)->images()->get();

        return response()->json($images, Response::HTTP_OK);

    }
}
