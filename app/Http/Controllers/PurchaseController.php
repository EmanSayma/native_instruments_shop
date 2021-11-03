<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchaseRepository;
    protected $productRepository;
  
    public function __construct(
        PurchaseRepository $purchaseRepository,
        ProductRepository $productRepository
    ) {
        $this->purchaseRepository = $purchaseRepository;
        $this->productRepository = $productRepository;
    }

    public function getPurchases(Request $request)
    {
        $user = $request->user();
        $product_skus = $user->purchases()->pluck('product_sku')->toArray();
        $products = [];

        foreach($product_skus as $sku) {
            $products[] = $this->productRepository->findProductBySku($sku);
        }

        return ProductResource::collection(collect($products));
    }

    public function addPurchase(Request $request)
    {
        $user = $request->user();

        $product_sku = $request['product_sku'];

        $product = $this->productRepository->findProductBySku($product_sku);

        if (!$product) {
            return response([
                'message' => 'Product not found'

            ], 401);
        }

        $this->purchaseRepository->store([
                'user_id' => $user->id,
                'product_sku' => $product->sku,
        ]);

        return response(new ProductResource($product), 201);
    }

    public function deletePurchase(Request $request, $sku)
    {
        $user = $request->user();

        $product = $this->productRepository->findProductBySku($sku);

        if (!$product) {
            return response([
                'message' => 'Product not found'

            ], 404);
        }

        $purchases = $this->purchaseRepository
                         ->findByUserAndProductSku($user->id, $product->sku)
                         ->pluck('id')->toArray();

        if (!$purchases) {
            return response([
                'message' => 'User do not have this product in his purchases'

            ], 404);
        }

        $this->purchaseRepository->deleteAll($purchases);

        return [
            'message' => 'Product removed from user purchases'
        ];
    }
}
