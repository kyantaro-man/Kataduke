<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Item;
use App\Http\Requests\CreateItem;

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

    // アイテム追加ページを表示する
    public function showCreateForm(int $id) {
        return view('items/create', [
            'room_id' => $id,
        ]);
    }

    // アイテムを追加する
    public function create(int $id, CreateItem $request) {
        $current_room = Room::find($id);

        $item = new Item();
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        $current_room->items()->save($item);

        return redirect()->route('items.index', [
            'id' => $current_room->id,
        ]);
    }
}
