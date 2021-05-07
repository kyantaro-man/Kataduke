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
        $current_items_size = [];
        $items = $room->items()->get();
        foreach ($items as $item) {
            $current_items_size[] = $item->size;
        }
        $current_items_size_sum = array_sum($current_items_size);

        $item = new Item();
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        $items_size_sum = $current_items_size_sum + $item->size;

        if ($items_size_sum > $room->size) {
            return redirect()->route('items.create', [
                'room' => $room,
            ])->with('flash_message', 'アイテムの合計サイズがルームのサイズを超えています。');
        } else {
            $room->items()->save($item);
            return redirect()->route('items.index', [
                'room' => $room,
            ]);
        }
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

        $current_items_size = [];
        $items = $room->items()->get();
        foreach ($items as $item) {
            $current_items_size[] = $item->size;
        }
        $current_items_size_sum = array_sum($current_items_size);
        
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        $items_size_sum = $current_items_size_sum + $item->size;

        if ($items_size_sum > $room->size) {
            return redirect()->route('items.create', [
                'room' => $room,
            ])->with('flash_message', 'アイテムの合計サイズがルームのサイズを超えています。');
        } else {
            $item->save();
            return redirect()->route('items.index', [
                'room' => $room,
            ]);
        }
    }

    // アイテムの削除をする
    public function destroy(Room $room, Item $item) {
        $item->delete();

        return redirect()->route('items.index', [
            'room' => $room->id,
        ])->with('success', '削除完了');
    }

    private function checkRelation(Room $room, Item $item) {
        if ($room->id !== $item->room_id) {
            abort(404);
        }
    }
}
