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

            $data['tags'] = Helpers::validateTags($data['tags']);

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

            $data['tags'] = Helpers::validateTags($data['tags']);

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
            $highestPriceProduct = Product::getProductsWithHighestPrice();

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
            $mostUsedTagsProducts = Product::getMostUsedTagsWithProducts();

            if (!$mostUsedTagsProducts) {
                return response()->json([
                    'message' => 'No se encontraron tags'
                ], 404);
            }

            return response()->json($mostUsedTagsProducts);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las etiquetas más usadas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
