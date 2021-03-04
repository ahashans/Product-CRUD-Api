<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * The validation logic that will be applied to validate user input.
     *
     * @var array
     */
    private $insert_validation_rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image'
    ];
    private $update_validation_rules = [
        'title' => 'string',
        'description' => 'string',
        'price' => 'numeric',
        'image' => 'image'
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
         $this->middleware('auth');
    }

    /**
     * Returns all products from database.
     *
     * @return void
     */
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    /**
     * Returns a product from database.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            return response()->json($product);
        }
        catch (QueryException $exception){
            return response()->json($exception,400);
        }
        catch (Exception $exception){
            return response()->json($exception,400);
        }
    }


    /**
     * Creates a new products in database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $this->validate($request,$this->insert_validation_rules);
            $product = new Product;

            $product->title= $request->title;
            $product->description= $request->description;
            $product->price = $request->price;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                //
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)."-".time().".".$file->getClientOriginalExtension();
                $file->move("images/product",$fileName);
                $file->getPath();
                $product->image= '/images/product/'.$fileName;
            }
            $product->save();
            return response()->json($product,201);
        }
        catch (ValidationException $exception){
            return response()->json($exception->errors(),400);
        }
        catch (QueryException $exception){
            return response()->json($exception,400);
        }
        catch (FileException $exception){
            return response()->json($exception,425);
        }
        catch (Exception $exception){
            return response()->json($exception,400);
        }

    }

    /**
     * Updates a products in database.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $product= Product::find($id);
            $this->validate($request,$this->update_validation_rules);
            $product->title= $request->title;
            $product->description= $request->description;
            $product->price = $request->price;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                //
                $file = $request->file('image');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)."-".time().".".$file->getClientOriginalExtension();
                $file->move("images/product",$fileName);
                $file->getPath();
                $product->image= '/images/product/'.$fileName;
            }
            $product->save();
            return response()->json($product);
        }
        catch (ValidationException $exception){
            return response()->json($exception->errors(),400);
        }
        catch (QueryException $exception){
            return response()->json($exception,400);
        }
        catch (FileException $exception){
            return response()->json($exception,425);
        }
        catch (Exception $exception){
            return response()->json($exception,400);
        }
    }


    /**
     * Removes a product from database.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $product = Product::find($id);
            if(!$product){
                throw new Exception("invalid query");
            }
            $product->delete();
            return response()->json("product deleted successfully",200);
        }
        catch (QueryException $exception){
            return response()->json($exception,400);
        }
        catch (Exception $exception){
            return response()->json($exception,400);
        }
    }
}
