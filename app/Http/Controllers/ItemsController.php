<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Item;

class ItemsController extends Controller
{
    // アイテム一覧を表示する
    public function index(int $id)
    {
        $rooms = Room::all();

        $current_room = Room::find($id);

        $items = $current_room->items()->get();

        return view('items/index', [
            'rooms' => $rooms,
            'current_room_id' => $current_room->id,
            'items' => $items,
        ]);
    }
}
