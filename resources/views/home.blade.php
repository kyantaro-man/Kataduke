@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-warning">
          <div class="panel-heading">
            ようこそ！まずはルームを作成しましょう！
          </div>
          <div class="panel-body">
            <div class="text-center">
              <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                ルーム作成ページへ
              </a>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
