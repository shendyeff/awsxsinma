<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Traits\HasImage;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    use HasImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user')->paginate(10);

        $categories = Category::get();

        $suppliers = Supplier::get();

        return view('admin.order.index', compact('orders', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // Jika status masih Pending, lakukan konfirmasi dengan kode
        if ($order->status == OrderStatus::Pending) {
            // Periksa apakah kode konfirmasi sesuai
            if ($request->confirmation_code == $order->confirmation_code) {
                // Ubah status menjadi Verified
                $order->update([
                    'status' => OrderStatus::Verified,
                ]);
                
                return back()->with('toast_success', 'Permintaan Barang Berhasil Dikonfirmasi');
            } else {
                return back()->with('toast_error', 'Kode Konfirmasi Tidak Sesuai');
            }
        }
    
        // Jika status sudah Verified, tambahkan produk tanpa memeriksa kode lagi
        if ($order->status == OrderStatus::Verified) {
            $image = $this->uploadImage($request, $path = 'public/products/', $name = 'image');
            Product::create([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'name' => $request->name,
                'image' => $image->hashName(),
                'unit' => $request->unit,
                'description' => $request->description,
                'quantity' => $request->quantity,
            ]);
    
            // Ubah status menjadi Success setelah produk ditambahkan
            $order->update([
                'status' => OrderStatus::Success,
            ]);
    
            return back()->with('toast_success', 'Produk berhasil ditambahkan');
        }
    
        // Jika status selain Pending atau Verified, tidak lakukan apa-apa
        return back()->with('toast_error', 'Permintaan tidak valid.');
    }
    

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
