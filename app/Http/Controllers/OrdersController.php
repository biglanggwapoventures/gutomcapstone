<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderLine;
use Auth;
use Validator;
use Illuminate\Validation\Rule;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $items = $user->orders()->with(['restaurant', 'items.details']);
        if($request->has('status')){
            switch($request->status){
                case Order::STATUS_APPROVED: 
                     $items->approved();
                     $items->markAsRead();
                     break;
                case Order::STATUS_CANCELLED:  
                    $items->cancelled();
                    $items->markAsRead();
                    break;
                default:  
                    $items->pending();
                    break;
            }
        }else{
             $items->pending();
        }
        $items->orderBy('id', 'DESC');
        $unread = $user->getOrdersNotificationCount();
        return view('orders', [
            'items' => $items->get(),
            'approvedUnreadCount' => isset($unread[Order::STATUS_APPROVED]) ? $unread[Order::STATUS_APPROVED] : 0,
            'cancelledApprovedCount' =>  isset($unread[Order::STATUS_CANCELLED]) ? $unread[Order::STATUS_CANCELLED] : 0,
        ]);
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
    public function store(OrderRequest $request)
    {   
        $data = $request->only([
            'restaurant_id',
            'order_type',
            'payment_type',
            'name',
            'contact_number',
            'order_date',
        ]);

        if($request->order_type === Order::TYPE_DINE_IN){
            $data += [
                'guest_count' => $request->guest_count,
                // 'cook_time' => date_create_from_format('g:i A', $request->cook_time)->format('H:i:s')
            ];
        }

        $data['order_time'] = date_create_from_format('g:i A', $request->order_time)->format('H:i:s');

        \DB::transaction(function () USE ($data) {

            $user = Auth::user();

            $order = $user->orders()->save(new Order($data));
            $items = $user->cartContents($data['restaurant_id']);
            
            $ids = [];
            
            $order->items()->saveMany(
                $items->map(function ($item) USE (&$ids) {
                    $ids[] = $item['id'];
                    return new OrderLine([
                        'menu_id' => $item['menu_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['item']['price']
                    ]);
                })
            );

            \App\Cart::destroy($ids);

        });

        return redirect()->route('orders.index')->with('notification', 'Order has been successfully placed!');
        
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
    public function update(Request $request, $id)
    {
        $rules = [
            'menu_id' => ['required', Rule::exists('order_lines')->where(function ($query) USE ($id) {
                $query->where('order_id', $id);
            })],
            'quantity' => 'required|integer|min:1'
        ];

        $v = Validator::make($request->all(), $rules);
        
        if($v->fails()){
            return response()->json([
                'result' => false,
                'errors' => $v->errors()->all()
            ]);
        }

        OrderLine::where('order_id', $id)
            ->where('menu_id', $request->menu_id)
            ->update([
                'quantity' => $request->quantity
            ]);

        return response()->json(['result' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {   
        $rules = [
            'menu_id' => ['required', Rule::exists('order_lines')->where(function ($query) USE ($id) {
                $query->where('order_id', $id);
            })],
        ];

        $v = Validator::make($request->all(), $rules);
        
        if($v->fails()){
            return response()->json([
                'result' => false,
                'errors' => $v->errors()->all()
            ]);
        }

        OrderLine::where('order_id', $id)
            ->where('menu_id', $request->menu_id)
            ->delete();

        return response()->json(['result' => true]);
    }
}
