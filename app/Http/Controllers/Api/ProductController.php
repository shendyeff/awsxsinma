<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->query('search'); // Menggunakan query parameter untuk pencarian

        $products = Product::with('category', 'supplier')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(); // Gunakan paginate untuk hasil yang lebih teratur

        return response()->json([
            'success' => true,
            'message' => 'List Data Product',
            'data' => $products,
        ], 200);
    }
}