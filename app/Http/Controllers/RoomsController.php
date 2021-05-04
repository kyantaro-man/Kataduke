<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Http\Requests\CreateRoom;

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

        $room->save();

        return redirect()->route('items.index', [
            'id' => $room->id,
        ]);
    }
}
