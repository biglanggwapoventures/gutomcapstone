<?php

namespace App\Http\Controllers\MyRestaurant;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\OrderLine;
use App\Order;
use Validator;
use Auth;
use DB;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurant = Auth::user()->restaurant();

        $restaurant->with(['orders' => function($q) USE ($request){
            $q->with(['customer', 'items.details']);
            if($request->has('status')){
                switch($request->status){
                    case Order::STATUS_APPROVED: 
                        $q->approved();
                        break;
                    case Order::STATUS_CANCELLED:  
                        $q->cancelled();
                        break;
                    default: 
                        $q->pending();
                        break;
                }
            }else{
                $q->pending();
            }
            $q->orderBy('id', 'DESC');
        }]);
        

       
        return view('manage-restaurant.orders', [
            'restaurant' => $restaurant->first()
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
    public function store(Request $request)
    {
        
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
        $v = Validator::make($request->all(), [
            'available.*.order_line_id' => [
                'required_with:available.*.available',
                Rule::exists('order_lines', 'id')->where(function ($query) USE ($id) {
                    $query->where('order_id', $id);
                })
            ],
            'available.*.available' => [
                'required_with:available.*.order_line_id',
                'boolean'
            ],
            'remarks' => 'present',
            'order_status' => 'required|in:CANCELLED,APPROVED'
        ]);

        if($v->fails()){
            return response()->json([
                'result' => false,
                'errors' => $v->errors()->all()
            ]);
        }
        

        $updatedFields = $request->only(['remarks', 'order_status' ]);
        $orderLine = array_column($request->available, 'available', 'order_line_id');

        DB::transaction(function () USE ($id, $updatedFields, $orderLine) {
             Order::whereId($id)
                ->whereOrderStatus(Order::STATUS_PENDING)
                ->update($updatedFields);

            OrderLine::whereIn('id', array_keys($orderLine))
                ->get()
                ->each(function ($line) USE ($orderLine){
                    if(isset($orderLine[$line->id]) && !$orderLine[$line->id]){
                        $line->available = false;
                        $line->save();
                    }
                });
        }, 5);

        return response()->json([
            'result' => true,
            'next' => route('food-orders.index', [
                'status' => $request->order_status
            ])
        ]);

        
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
