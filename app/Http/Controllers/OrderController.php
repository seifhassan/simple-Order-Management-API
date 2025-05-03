<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'in:pending,shipped',
        ]);

        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    public function index(Request $request)
    {
        $query = \App\Models\Order::query();

        // Optional filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('product_name')) {
            $query->where('product_name', 'LIKE', '%' . $request->product_name . '%');
        }

        return response()->json($query->get());
    }


    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:pending,shipped',
        ]);
        $order->update($validated);
        return response()->json($order);
    }

    public function stats()
    {
        $stats = [
            'total_revenue' => Order::sum(\DB::raw('price * quantity')),
            'orders_per_status' => Order::select('status', \DB::raw('count(*) as count'))
                ->groupBy('status')->get(),
        ];
        return response()->json($stats);
    }
}

