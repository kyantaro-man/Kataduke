<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class ItemsController extends Controller
{
    // アイテム一覧を表示する
    public function index(int $id)
    {
        $rooms = Room::all();

        return view('items/index', [
            'rooms' => $rooms,
            'current_room_id' => $id,
        ]);
    }
}
