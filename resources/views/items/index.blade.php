@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-7">
        <nav class="panel panel-warning">
          <div class="panel-heading">ルーム</div>
          <div class="panel-body">
            <a href="{{ route('rooms.create') }}" class="btn btn-default btn-block">
              ルームを追加する
            </a>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>ルーム名</th>
              <th>サイズ</th>
              <th>状態</th>
              <th></th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              @foreach($rooms as $room)
                <tr class="table-room {{ $current_room_id === $room->id ? 'act' : '' }}">
                  <td><a href="{{ route('items.index', ['id' => $room->id]) }}">{{ $room->name }}</a></td>
                  <td>{{ $room->size }}</td>
                  <td>
                    <span class="label {{ $room->status_class }}">{{ $room->status_label }}</span>
                  </td>
                  <td><a href="{{ route('rooms.edit', ['id' => $room->id]) }}">編集</a></td>
                  <td><a href="#">削除</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </nav>
      </div>
      <div class="column col-md-5">
        <div class="panel panel-warning">
          <div class="panel-heading">アイテム</div>
          <div class="panel-body">
            <a href="{{ route('items.create', ['id' => $current_room_id]) }}" class="btn btn-default btn-block">
              アイテムを追加する
            </a>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>アイテム名</th>
              <th>サイズ</th>
              <th></th>
              <th></th>
            </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->size }}</td>
                  <td><a href="#">編集</a></td>
                  <td><a href="#">削除</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection