<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Requests\CreateRoom;
use App\Http\Requests\EditRoom;
use Illuminate\Support\Facades\Auth;

class RoomsController extends Controller
{
    // ルームの登録フォームを表示する
    public function showCreateForm() {
        return view('rooms/create');
    }

    // ルームを登録する
    public function create(CreateRoom $request) {
        $room = new Room();

        $room->name = $request->name;
        $room->size = $request->size;

        Auth::user()->rooms()->save($room);

        return redirect()->route('items.index', [
            'room' => $room->id,
        ]);
    }

    // ルームの編集フォームを表示する
    public function showEditForm(Room $room) {

        return view('rooms/edit', [
            'room' => $room,
        ]);
    }

    // ルームの編集をする
    public function edit(Room $room, EditRoom $request) {

        // アイテムのサイズ合計を取得する
        $items_size_sum = [];
        $items_size_sum = $this->getItemsSizeSum($room);

        // ルームの編集をする
        $room->name = $request->name;
        $room->size = $request->size;

        // ルーム編集後のサイズによって、ルームの状態を変更する
        $this->changeRoomStatusWithItemsSizeSum($items_size_sum, $room);

        // ルーム編集後のサイズによって、更新するかしないかを判断する
        if ($items_size_sum > $room->size) {
            return redirect()->route('rooms.edit', [
                'room' => $room,
            ])->with('flash_message', 'アイテムの合計サイズがルームのサイズを超えています。');
        } else {
            $room->save();
            return redirect()->route('items.index', [
                'room' => $room,
            ]);
        }
    }

    // ルームの削除をする
    public function destroy(Room $room) {
        $room->items()->each(function ($item) {
            $item->delete();
        });
        $room->delete();

        return redirect()->route('items.index', [
            'room' => Auth::user()->rooms()->first(),
        ])->with('flash_message', '削除完了');
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
