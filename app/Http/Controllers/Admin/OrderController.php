<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Variation;

class OrderController extends Controller
{
    public function index()
    {
        switch (true){
            case request()->offsetExists("pending") :
                $type = "pending";
                break;
            case request()->offsetExists("processing") :
                $type = "processing";
                break;
            case request()->offsetExists("delivered") :
                $type = "delivered";
                break;
            case request()->offsetExists("cancelled") :
                $type = "cancelled";
                break;
            default :
                $type = null;
        }
        return view('admin.orders.index', [
            'type' => $type
        ]);
    }

    public function update(Order $order)
    {
        $this->validate(request(), ['pickup_date' => 'required|date|after_or_equal:'.date('Y-m-d')]);
        $order->update(['pickup_date' => request('pickup_date')]);
        return back()->with('success', 'Order pickup date updated');
    }

    public function changeState(Order $order)
    {
        $this->validate(request(), [
            'state' => ['required', 'in:pending,processing,delivered,cancelled']
        ]);
        $order->update(['status' => request('state')]);
        switch (request('state')) {
            case 'pending':
                $type = 'Pending';
                $message = 'Your order is pending processing';
                break;
            case 'processing':
                $type = 'Processing';
                $message = 'Your order is being processed and will be delivered soon';
                break;
            case 'delivered':
                $type = 'Delivered';
                $message = 'Your order has been delivered to your shipping address';
                break;
            case 'cancelled':
                $type = 'Cancelled';
                $message = 'Your order has been cancelled, and a refund has/will be issued';
                break;
        }
        $activity = $order->activities()->create([
            'type' => 'Order '.$type,
            'message' => $message
        ]);
        $activity['type'] = $type;
        \App\Http\Controllers\NotificationController::sendOrderActivityNotification($order, $activity);
        $msg = 'Order marked as '.request('state').' successfully';
        return back()->with('success', $msg);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $order,
            'variations' => Variation::all()
        ]);
    }

    public function getOrdersByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'code', 'id', 'id', 'id', 'shipping', 'id', 'created_at', 'status', 'id'
        ];

        if (request('type')){
            $orders = Order::query()->latest()->where('status', request('type'));
        }else{
            $orders = Order::query()->latest();
        }
        //   Set helper variables from request and DB
        $totalData = $totalFiltered = $orders->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //  Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $orders = $orders->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $orders = $orders->where('code','LIKE',"%{$search}%")
                ->orWhereHas('items',function ($q) use ($search) {
                    $q->where('quantity', 'LIKE',"%{$search}%")
                        ->orWhere('price', 'LIKE',"%{$search}%");
                })
                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                ->orWhere('customer_email', 'LIKE',"%{$search}%")
                ->orWhere('customer_phone', 'LIKE',"%{$search}%")
                ->orWhere('customer_address', 'LIKE',"%{$search}%")
                ->orWhere('date', 'LIKE',"%{$search}%")
                ->orWhere('note', 'LIKE',"%{$search}%")
                ->orWhere('shipping_fee', 'LIKE',"%{$search}%")
                ->orWhere('additional_fee', 'LIKE',"%{$search}%");
            $totalFiltered = $orders->count();
            $orders = $orders->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        //   Loop through all data and mutate data
        $data = [];
        $key = $start + 1;
        foreach ($orders as $order)
        {
            $action = $status = null;
            $statuses = ['pending', 'processing', 'delivered', 'cancelled'];

            foreach ($statuses as $currentStatus) {
                if ($currentStatus != $order['status']) {
                    switch ($currentStatus) {
                        case 'pending' :
                            $icon = '<i style="font-size: 13px" class="text-secondary icon-sm mr-2 fa fa-ban"></i>';
                            break;
                        case 'processing' :
                            $icon = '<i style="font-size: 13px" class="text-secondary icon-sm mr-2 fa fa-hourglass-end"></i>';
                            break;
                        case 'delivered' :
                            $icon = '<i style="font-size: 13px" class="text-secondary icon-sm mr-2 fa fa-check"></i>';
                            break;
                        case 'cancelled' :
                            $icon = '<i style="font-size: 13px" class="text-secondary icon-sm mr-2 fa fa-times"></i>';
                            break;
                    }
                    if (auth()->user()->can('Process Orders')) {
                        $action .= '<button onclick="event.preventDefault(); confirmSubmission(\'actionForm'.$currentStatus.$order['id'].'\')" class="dropdown-item d-flex align-items-center">'.$icon.'<span class="">Mark '.$currentStatus.'</span></button>
                        <form method="POST" id="actionForm'.$currentStatus.$order['id'].'" action="'. route('admin.orders.state.change', $order) .'">
                            <input type="hidden" name="_token" value="'. csrf_token() .'" />
                            <input type="hidden" name="state" value="'.$currentStatus.'" />
                            <input type="hidden" name="_method" value="PUT" />
                        </form>';
                    }
                }
            }

            switch ($order['status']) {
                case 'pending' :
                    $status = '<span class="badge badge-warning-inverse">pending</span>';
                    break;
                case 'processing' :
                    $status = '<span class="badge badge-primary-inverse">processing</span>';
                    break;
                case 'delivered' :
                    $status = '<span class="badge badge-success-inverse">delivered</span>';
                    break;
                case 'cancelled' :
                    $status = '<span class="badge badge-danger-inverse">cancelled</span>';
                    break;
            }

            $datum['sn'] = $key;
            $datum['code'] = '<a href="'. route('admin.orders.show', $order) .'">'. $order['code'] .'</a>';
            $datum['customer'] = $order['name'];
            $datum['products'] = count($order['items']);
            $datum['subtotal'] = number_format($order->getSubTotal());
            $datum['shipping'] = number_format($order['shipping']);
            $datum['total'] = number_format($order->getTotal());
            $datum['date'] = $order['created_at']->format('M d, Y');
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.orders.show', $order) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>
                                        '.$action.'
                                    </div>
                                </div>';
            $data[] = $datum;
            $key++;
        }
        //   Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }
}
