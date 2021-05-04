<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Kataduke</title>
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
  <nav class="my-navbar">
    <a class="my-navbar-brand" href="/">Kataduke</a>
  </nav>
</header>
<main>
  <div class="container">
    <div class="row">
      <div class="col col-md-7">
        <nav class="panel panel-warning">
          <div class="panel-heading">ルーム</div>
          <div class="panel-body">
            <a href="#" class="btn btn-default btn-block">
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
                  <td><a href="#">編集</a></td>
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
            <a href="#" class="btn btn-default btn-block">
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
</main>
</body>
</html>