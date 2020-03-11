@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        管理员电话: 15971436290      QQ群: 999999999
                        <hr>
                        <p class="font-weight-bold">问：如何使用本系统进行购买？</p>
                        <p class="font-weight-normal">答：请先使用本人的手机号码注册，然后点击开始购物->加入购物车->提交订单->立即付款 即可。</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
