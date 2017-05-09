<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Order;

class UserCancelOrderController extends Controller
{
    public function __invoke($orderId)
    {
        Order::whereUserId(Auth::id())
            ->whereOrderStatus(Order::STATUS_PENDING)
            ->whereId($orderId)
            ->update([
                'order_status' => Order::STATUS_CANCELLED,
                'seen_by_user' => 1
            ]);
        
        return redirect()
            ->route('orders.index', ['status' => Order::STATUS_PENDING])
            ->with('notification', "Order # {$orderId} has been successfully cancelled!");
    }
}
