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
        // 現在のアイテムのサイズ合計を取得する
        $current_items_size_sum = [];
        $current_items_size_sum = $this->getItemsSizeSum($room);

        // アイテムを追加する
        $item = new Item();
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        // 現在のアイテムのサイズ合計に追加予定アイテムのサイズを足す
        $items_size_sum = $current_items_size_sum + $item->size;

        // アイテム追加後のサイズ合計によって、ルームの状態を変更する
        $this->changeRoomStatusWithItemsSizeSum($items_size_sum, $room);

        // アイテム追加後のサイズ合計によって、保存するかしないかを判断する
        if ($items_size_sum > $room->size) {
            return redirect()->route('items.create', [
                'room' => $room,
            ])->with('flash_message', 'アイテムの合計サイズがルームのサイズを超えています。');
        } else {
            $room->save();
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

        // 現在のアイテムのサイズ合計を取得する
        $current_items_size_sum = [];
        $current_items_size_sum = $this->getItemsSizeSum($room);

        // 現在のアイテムのサイズ合計から更新前アイテムのサイズを引く
        $current_items_size_sum -= $item->size;

        // アイテムを更新する
        $item->name = $request->name;
        $item->size = $request->size;
        $item->image = $request->image;
        $item->memo = $request->memo;

        // 現在のアイテムのサイズ合計に更新予定アイテムのサイズを足す
        $items_size_sum = $current_items_size_sum + $item->size;

        // アイテム追加後のサイズ合計によって、ルームの状態を変更する
        $this->changeRoomStatusWithItemsSizeSum($items_size_sum, $room);

        // アイテム追加後のサイズ合計によって、更新するかしないかを判断する
        if ($items_size_sum > $room->size) {
            return redirect()->route('items.edit', [
                'room' => $room,
                'item' => $item,
            ])->with('flash_message', 'アイテムの合計サイズがルームのサイズを超えています。');
        } else {
            $room->save();
            $item->save();
            return redirect()->route('items.index', [
                'room' => $room,
            ]);
        }
    }

    // アイテムの削除をする
    public function destroy(Room $room, Item $item) {
        $item->delete();

        // 削除後のアイテムのサイズ合計を取得する
        $items_size_sum = [];
        $items_size_sum = $this->getItemsSizeSum($room);

        // アイテム追加後のサイズ合計によって、ルームの状態を変更する
        $this->changeRoomStatusWithItemsSizeSum($items_size_sum, $room);

        // ルームの状態を保存する
        $room->save();

        return redirect()->route('items.index', [
            'room' => $room->id,
        ])->with('flash_message', '削除完了');
    }

    private function checkRelation(Room $room, Item $item) {
        if ($room->id !== $item->room_id) {
            abort(404);
        }
    }

    private function getItemsSizeSum(Room $room) {
        $items_size = [];
        $items = $room->items()->get();
        foreach ($items as $item) {
            $items_size[] = $item->size;
        }
        $items_size_sum = array_sum($items_size);
        return $items_size_sum;
    }

    private function changeRoomStatusWithItemsSizeSum(int $items_size_sum, Room $room) {
        if ($items_size_sum < ($room->size * 0.5)) {
            $room->status = 1;
        } elseif ($items_size_sum >= ($room->size * 0.8)) {
            $room->status = 3;
        } else {
            $room->status = 2;
        }
        return $room;
    }
}
