@extends('layouts.app')
@section('title', '书本列表')

@section('content')
    <div class="row books-index-page">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body">
                    <!-- 筛选组件开始 -->
                    <form action="{{ route('books.index') }}" class="search-form">
                        <div class="form-row">
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col-auto"><input type="text" class="form-control form-control-sm" name="search" placeholder="书名或作者"></div>
                                    <div class="col-auto"><button class="btn btn-primary btn-sm">搜索</button></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="order" class="form-control form-control-sm float-right">
                                    <option value="">排序方式</option>
                                    <option value="price_asc">价格从低到高</option>
                                    <option value="price_desc">价格从高到低</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <!-- 筛选组件结束 -->
                    <div class="row books-list">
                        @foreach($books as $book)
                            <div class="col-3 books-item">
                                <div class="books-content">
                                    <div class="top">
                                        <div class="img">
                                            <a href="{{ route('books.show', ['book' => $book->id]) }}">
                                                <img src="{{ $book->image_url }}" alt="">
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
@endsection

@section('scriptsAfterJs')
    <script>
        var filters = {!! json_encode($filters) !!};
        $(document).ready(function () {
            $('.search-form input[name=search]').val(filters.search);
            $('.search-form select[name=order]').val(filters.order);
        })
    </script>
@endsection



