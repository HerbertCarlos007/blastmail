<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmailList;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubscriberController extends Controller
{
    public function index(EmailList $emailList)
    {
        $search = request()->search;
        $showTrash = request()->get('showTrash', false);

        return view('subscriber.index', [
            'emailList' => $emailList,
            'search' => $search,
            'showTrash' => $showTrash,
            'subscribers' => $emailList
                ->subscribers()
                ->when($showTrash, fn(Builder $query) => $query->withTrashed())
                ->when($search, fn(Builder $query) => $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', '=', $search))
                ->paginate(5),

        ]);
    }

    public function create(EmailList $emailList)
    {
        return view('subscriber.create', compact('emailList'));
    }

    public function store(EmailList $emailList)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('subscribers')->where('email_list_id', $emailList->id)],
        ]);

        $emailList->subscribers()->create($data);

        return to_route('subscribers.index', $emailList)
            ->with('message', __('Subscriber created.'));
    }

    public function destroy(mixed $emailList, Subscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('message', __('Subscriber successfully deleted'));
    }
}
