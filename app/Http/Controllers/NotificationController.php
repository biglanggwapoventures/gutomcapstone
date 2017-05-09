<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;

class NotificationController extends Controller
{
    public function clear($status)
    {
        $orders = Auth::user()->orders();
        
        // if(!$orders->exists()) return;

        if($status === Order::STATUS_APPROVED){
            $orders->approved();
        }elseif($status === Order::STATUS_CANCELLED){
            $orders->cancelled();
        }else{
            return;
        }

       $orders->unreadByUser()->markAsRead();
       
       return response()->json([
           'result' => true
       ]);
    }
}
