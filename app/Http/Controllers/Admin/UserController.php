<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        switch (true){
            case request()->offsetExists("verified") :
                $type = "verified";
                break;
            case request()->offsetExists("unverified") :
                $type = "unverified";
                break;
            default :
                $type = null;
        }
        return view('admin.users.index', [
            'type' => $type
        ]);
    }

    public function block(User $user)
    {
        $user->update(['active' => false]);
        return back()->with('success', 'User blocked successfully');
    }

    public function unBlock(User $user)
    {
        $user->update(['active' => true]);
        return back()->with('success', 'User unblocked successfully');
    }

    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    public function getUsersByAjax(Request $request)
    {
        //   Define all column names
        $columns = [
            'id', 'name', 'email', 'phone', 'id', 'id', 'created_at', 'id'
        ];

        if (request('type') == 'verified'){
            $users = User::query()->latest()->whereNotNull('email_verified_at');
        }elseif (request('type') == 'unverified'){
            $users = User::query()->latest()->whereNull('email_verified_at');
        }else{
            $users = User::query()->latest();
        }
        //   Set helper variables from request and DB
        $totalData = $totalFiltered = $users->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
        //  Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $users = $users->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $users = $users->where('code','LIKE',"%{$search}%")
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
            $totalFiltered = $users->count();
            $users = $users->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        //   Loop through all data and mutate data
        $data = [];
        $key = $start + 1;
        foreach ($users as $user)
        {
            $action = null;
            if ($user['active'] == 1){
                $action = '<button onclick="event.preventDefault(); confirmSubmission(\'actionForm'.$user['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-user-times mr-2"></i> <span class="">Block</span></button>
                <form method="POST" id="actionForm'.$user['id'].'" action="'. route('admin.users.block', $user) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'" />
                    <input type="hidden" name="_method" value="PUT" />
                </form>';
            }else {
                $action = '<button onclick="event.preventDefault(); confirmSubmission(\'actionForm'.$user['id'].'\')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-user-plus mr-2"></i> <span class="">Unblock</span></button>
                <form method="POST" id="actionForm'.$user['id'].'" action="'. route('admin.users.unblock', $user) .'">
                    <input type="hidden" name="_token" value="'. csrf_token() .'" />
                    <input type="hidden" name="_method" value="PUT" />
                </form>';
            }

            $datum['sn'] = $key;
            $datum['name'] = '<a href="'. route('admin.users.show', $user) .'">'. $user['name'] .'</a>';
            $datum['email'] = $user['email'];
            $datum['phone'] = $user['phone'];
            $datum['orders'] = 1;
            $datum['ver_status'] = $user['email_verified_at'] ? '<span class="badge badge-success-inverse">Verified</span>' : '<span class="badge badge-danger-inverse">Unverified</span>';
            $datum['status'] = $user['active'] == 1 ? '<span class="badge badge-success-inverse">Active</span>' : '<span class="badge badge-danger-inverse">Blocked</span>';
            $datum['joined_date'] = $user['created_at']->format('M d, Y');
            $datum['action'] = '<div class="dropdown">
                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                        <a class="dropdown-item d-flex align-items-center" href="'. route('admin.users.show', $user) .'"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>
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
