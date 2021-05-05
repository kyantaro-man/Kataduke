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
            'id' => $room->id,
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
        $room->name = $request->name;
        $room->size = $request->size;

        $room->save();

        return redirect()->route('items.index', [
            'room' => $room,
        ]);
    }
}
