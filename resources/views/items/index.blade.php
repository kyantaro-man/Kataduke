@extends('layout')

@section('content')
  @if (session('flash_message'))
    <div class="alert alert-danger">
        {{ session('flash_message') }}
    </div>
  @endif
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
                  <td><a href="{{ route('items.index', ['room' => $room->id]) }}">{{ $room->name }}</a></td>
                  <td>{{ $room->size }}</td>
                  <td>
                    <span class="label {{ $room->status_class }}">{{ $room->status_label }}</span>
                  </td>
                  <td><a class='btn btn-primary btn-xs' href="{{ route('rooms.edit', ['room' => $room->id]) }}">編集</a></td>
                  <td>
                    <form action="{{ route('rooms.destroy', ['room' => $room->id]) }}" method="POST">
                      @csrf
                      <input type='submit' value='削除' class='btn btn-danger btn-xs'>
                    </form>
                  </td>
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
            <a href="{{ route('items.create', ['room' => $current_room_id]) }}" class="btn btn-default btn-block">
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
              @if(count($items) === 0)
                <tr>
                  <td colspan="4" class="text-danger text-center font-weight-bol">上のボタンを押して、アイテムを追加しよう！</td>
                </tr>
              @endif
              @foreach($items as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->size }}</td>
                  <td><a class='btn btn-primary btn-xs' href="{{ route('items.edit', ['room' => $item->room_id, 'item' => $item->id]) }}">編集</a></td>
                  <td>
                    <form action="{{ route('items.destroy', ['room' => $room->id, 'item' => $item->id]) }}" method="POST">
                      @csrf
                      <input type='submit' value='削除' class='btn btn-danger btn-xs'>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection