@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-warning">
          <div class="panel-heading">アイテムを追加する</div>
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
            <form action="{{ route('rooms.create') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">アイテム名</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" />
              </div>
              <div class="form-group">
                <label for="title">サイズ</label>
                <input type="text" class="form-control" name="size" id="size" value="{{ old('size') }}" />
              </div>
              <div class="form-group">
                <label for="file">画像</label>
                <input type="file" name="image" id="image" value="{{ old('image') }}" />
              </div>
              <div class="form-group">
                <label for="memo">メモ</label>
                <textarea class="form-control" name="memo" id="memo" value="{{ old('memo') }}" ></textarea>
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">追加</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection