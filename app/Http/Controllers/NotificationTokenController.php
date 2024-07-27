<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationTokenRequest;
use App\Http\Resources\NotificationTokenResource;
use App\Models\NotificationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationTokenController extends Controller
{
    public function index(){
        return NotificationTokenResource::collection(NotificationToken::all());
    }

    public function store(NotificationTokenRequest $request){
        $validated = $request->validated();
        $notification = NotificationToken::query()->where('id_hash', $validated['id_hash'])->first();
        DB::transaction(function() use ($validated, &$notification)
        {
            if($notification==null){
                $notification=new NotificationToken();
            }
            $notification->fill($validated);
            $notification->save();
        });
        return new NotificationTokenResource($notification);
    }
}
