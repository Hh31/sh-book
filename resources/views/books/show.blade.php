@extends('layouts.app')
@section('title', $book->name)

@section('content')
    <div class="row books-show-page">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body product-info">
                    <div class="row">
                        <div class="col-5">
                            <img class="cover" src="{{ $book->image_url }}" alt="">
                        </div>
                        <div class="col-7">
                            <div class="title">{{ $book->name }}</div>
                            <div class="price">
                                <label>价格</label><em>￥</em><span>{{ $book->price }}</span>
                            </div>
                            <div class="price iteminfo_mktpric">
                                <label>原价</label><em>￥</em><span>{{ $book->price }}</span>
                            </div>
                            <hr>
                            <div>
                                <label>作者：<span>{{ $book->author }}</span></label>
                            </div>
                            <div class="buttons">
                                @if($favored)
                                    <button class="btn btn-danger btn-disfavor">取消收藏</button>
                                @else
                                    <button class="btn btn-success btn-favor">❤ 收藏</button>
                                @endif
                            </div>
                            @can('update', $book)
                                <div class="operate">
                                    <hr>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                                        <i class="far fa-edit"></i> 编辑
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <div class="product-detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#product-detail-tab" aria-controls="product-detail-tab" role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#product-reviews-tab" aria-controls="product-reviews-tab" role="tab" data-toggle="tab" aria-selected="false">联系方式</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="product-detail-tab">
                                {!! $book->description !!}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="product-reviews-tab">
                                <div><label>邮箱</label><span>{{ $book->user->email }}</span></div>
                                <div><a href="{{route('users.show',$book->user_id)}}">联系他</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function () {
            // 监听收藏按钮的点击事件
            $('.btn-favor').click(function () {
                // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
                axios.post('{{ route('books.favor', ['book' => $book->id]) }}')
                    .then(function () { // 请求成功会执行这个回调
                        swal('操作成功', '', 'success');
                    }, function (error) { // 请求失败会执行这个回调
                        // 如果返回码是 401 代表没登录
                        if (error.response && error.response.status === 401) {
                            swal('请先登录', '', 'error');
                        } else if (error.response && (error.response.data.msg || error.response.data.message)) {
                            // 其他有 msg 或者 message 字段的情况，将 msg 提示给用户
                            swal(error.response.data.msg ? error.response.data.msg : error.response.data.message, '', 'error');
                        } else {
                            // 其他情况应该是系统挂了
                            swal('系统错误', '', 'error');
                        }
                    });
            });
        });
        $('.btn-disfavor').click(function () {
            axios.delete('{{ route('books.disfavor', ['book' => $book->id]) }}')
                .then(function () {
                    swal('操作成功', '', 'success')
                        .then(function () {
                            location.reload();
                        });
                });
        });

    </script>
@endsection
