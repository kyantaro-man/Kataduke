@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-warning">
          <div class="panel-heading">ルームを編集する</div>
          <div class="panel-body">
            @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $message)
                    <li>{{ $message }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if (session('flash_message'))
              <div class="alert alert-danger">
                  {{ session('flash_message') }}
              </div>
            @endif
            <form action="{{ route('rooms.edit', ['room' => $room->id]) }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">ルーム名</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?? $room->name }}" />
              </div>
              <div class="form-group">
                <label for="title">サイズ</label>
                <input type="text" class="form-control" name="size" id="size" value="{{ old('size') ?? $room->size }}" />
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">更新</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection