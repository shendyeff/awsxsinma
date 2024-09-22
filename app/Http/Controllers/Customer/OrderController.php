<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Product;
use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Enums\OrderStatus;

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
        $orders = Order::with('user')->where('user_id', Auth::id())->paginate(10);

        $product = [];

        foreach($orders as $order){
            $product = Product::where('name', $order->name)->where('quantity', $order->quantity)->get();
        }

        return view('customer.order.index', compact('orders', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Generate kode konfirmasi
    $confirmationCode = Str::random(6); // Misalnya 6 karakter acak

    // Simpan permintaan barang dari customer dengan kode konfirmasi
    Order::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'quantity' => $request->quantity,
        'unit' => $request->unit,
        'image' => $this->uploadImage($request, 'public/orders/', 'image')->hashName(),
        'status' => OrderStatus::Pending,
        'confirmation_code' => $confirmationCode,
    ]);

    return back()->with('toast_success', 'Permintaan Barang Berhasil Dibuat. Kode Konfirmasi: ' . $confirmationCode);
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
        $image = $this->uploadImage($request, $path = 'public/orders/', $name = 'image');

        $order->update([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
        ]);

        if($request->file($name)){
            $this->updateImage(
                $path = 'public/orders/', $name = 'image', $data = $order, $url = $image->hashName()
            );
        }

        return back()->with('toast_success', 'Permintaan Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        Storage::disk('local')->delete('public/orders/'. basename($order->image));

        return back()->with('toast_success', 'Permintaan Barang Berhasil Dihapus');
    }
}