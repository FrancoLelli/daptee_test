<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Helpers\Helpers;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->filled('search')) {
                $search = $request->query('search');
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereJsonContains('tags', $search);
            }

            $perPage = $request->query('per_page', 5);
            $products = $query->paginate($perPage);

            return response()->json([
                'message' => 'Productos obtenidos correctamente',
                'products' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'tags' => 'array',
            ]);

            if (isset($data['tags']) && is_array($data['tags'])) {
                $data['tags'] = array_filter($data['tags'], function ($tag) {
                    return !is_null($tag) && $tag !== false && $tag !== 0 && $tag !== 'undefined';
                });

                $data['tags'] = array_values($data['tags']);
            }

            $product = Product::create($data);

            return response()->json([
                'message' => 'Producto creado correctamente',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al validar los datos',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function show(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            return $product;
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'name' => 'string',
                'price' => 'numeric',
                'tags' => 'array',
            ]);

            if (isset($data['tags']) && is_array($data['tags'])) {
                $data['tags'] = array_filter($data['tags'], function ($tag) {
                    return !is_null($tag) && $tag !== false && $tag !== 0 && $tag !== 'undefined';
                });

                $data['tags'] = array_values($data['tags']);
            }

            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            $product->update($data);

            return response()->json([
                'message' => 'Producto actualizado correctamente',
                'product' =>  $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            $product->delete();

            return response()->json([
                'message' => 'Producto eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function totalStockValue(string $id, Request $request)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            $quantity = $request->query('quantity');

            if (!$quantity) {
                return response()->json([
                    'message' => 'Cantidad no ingresada'
                ], 422);
            }

            $totalValue = Helpers::multiply($product->price, $quantity);

            return response()->json([
                'productId' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
                'totalValue' => $totalValue,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el valor total del stock',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function highestPrice(Request $request)
    {
        try {
            $products = Product::all();

            $maxPrice = null;
            $highestPriceProduct = [];

            foreach ($products as $product) {
                if ($maxPrice === null || $product->price > $maxPrice) {
                    $maxPrice = $product->price;
                    $highestPriceProduct = [$product];
                } elseif ($product->price == $maxPrice) {
                    $highestPriceProduct[] = $product;
                }
            }

            return response()->json($highestPriceProduct);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener el producto con el precio más alto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function mostUsedTags(Request $request)
    {
        try {
            $products = Product::all();

            $tagsCount = [];
            $tagsProducts = [];

            foreach ($products as $product) {
                if (isset($product->tags) && is_array($product->tags)) {
                    foreach ($product->tags as $tag) {
                        if (isset($tagsCount[$tag])) {
                            $tagsCount[$tag]++;
                        } else {
                            $tagsCount[$tag] = 1;
                        }
                        $tagsProducts[$tag][] = $product;
                    }
                }
            }

            $mostUsedTag = array_keys($tagsCount, max($tagsCount))[0];

            return response()->json([
                'tag' => $mostUsedTag,
                'count' => $tagsCount[$mostUsedTag],
                'products' => $tagsProducts[$mostUsedTag],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las etiquetas más usadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
