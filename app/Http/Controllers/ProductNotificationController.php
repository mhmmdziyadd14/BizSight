<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductNotification;

class ProductNotificationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'social_media' => 'nullable|string|max:255',
        ]);

        ProductNotification::create($request->all());

        return redirect()->back()->with('success', 'Terima kasih! Kami akan memberi tahu Anda saat produk diluncurkan.');
    }
}
