@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="card ">
                <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                <div class="card-body">
                    <h5><strong>个人简介</strong></h5>
                    <p>{{ $user->introduction }}</p>
                    <hr>
                    <h5><strong>注册于</strong></h5>
                    <p>{{ $user->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card ">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} </h1>
                </div>
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;"><small>{{ $user->email }}</small></h1>
                </div>
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;"><small>{{ $user->qq }}</small></h1>
                </div>
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;"><small>{{ $user->school }}</small></h1>
                </div>
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;"><small>{{ $user->phone }}</small></h1>
                </div>
            </div>
            <hr>

        </div>
        <div class="row books-index-page">
            <div class="col-lg-11 offset-lg-1">
                <div class="card">
                    <div class="card-body">
                        <!-- 筛选组件开始 -->
                        <div class="row books-list">
                            @foreach($books as $book)
                                <div class="col-3 books-item">
                                    <div class="books-content">
                                        <div class="top">
                                            <div class="img">
                                                <a href="{{ route('books.show', ['book' => $book->id]) }}">
                                                    <img src="{{ $book->image_url }}" height="240" alt="">
                                                </a>
                                            </div>
                                            <div class="price"><b>￥</b>{{ $book->price }}</div>
                                            <div class="title">
                                                <a href="{{ route('books.show', ['book' => $book->id]) }}">
                                                    {{ $book->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <div class="review_count">作者 <span>{{ $book->author }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{--                    分页--}}
                        <div class="float-right">{{ $books->render() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
