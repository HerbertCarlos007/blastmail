<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmailList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList)
    {
        $search = request()->search;

        return view('subscriber.index', [
            'emailList' => $emailList,
            'search' => $search,
            'subscribers' => $emailList
                ->subscribers()
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', '=', $search))
                ->paginate(5),

        ]);
    }
}
