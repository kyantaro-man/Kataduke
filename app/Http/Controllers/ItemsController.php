<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Item;
use App\Http\Requests\CreateItem;
use App\Http\Requests\EditItem;
use Illuminate\Support\Facades\Auth;

class ItemsController extends Controller
{
    // アイテム一覧を表示する
    public function index(Room $room)
    {
        $rooms = Auth::user()->rooms()->get();

        $items = $room->items()->get();

        return view('items/index', [
            'rooms' => $rooms,
            'current_room_id' => $room->id,
            'items' => $items,
        ]);
    }

    // アイテム追加ページを表示する
    public function showCreateForm(Room $room) {
        return view('items/create', [
            'room_id' => $room->id,
        ]);
    }

    // アイテムを追加する
    public function create(Room $room, CreateItem $request) {
        $item = new Item();
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        $room->items()->save($item);

        return redirect()->route('items.index', [
            'room' => $room,
        ]);
    }

    // アイテム編集ページを表示する
    public function showEditForm(Room $room, Item $item) {
        $this->checkRelation($room, $item);

        return view('items/edit', [
            'item' => $item,
        ]);
    }

    // アイテムを編集する
    public function edit(Room $room, Item $item, EditItem $request) {
        $this->checkRelation($room, $item);
        
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        $item->save();

        return redirect()->route('items.index', [
            'room' => $item->room_id,
        ]);
    }

    private function checkRelation(Room $room, Item $item) {
        if ($room->id !== $item->room_id) {
            abort(404);
        }
    }
}
