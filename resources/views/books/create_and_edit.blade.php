@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if($book->id)
                            编辑图书
                        @else
                            上传图书
                        @endif
                    </h2>

                    <hr>

                    @if($book->id)
                        <form action="{{ route('books.update',$book->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form action="{{ route('books.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" value="{{ old('name', $book->name ) }}" placeholder="书名" required />
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="author" value="{{ old('author', $book->author ) }}" placeholder="作者" required />
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="price" value="{{ old('price', $book->price ) }}" placeholder="价格" required />
                                    </div>


                                    <div class="form-group">
                                        <select class="form-control" name="book_status" required>
                                            <option value="" hidden disabled selected {{ $book->id ? '' : 'selected' }}>是否上架</option>

                                            <option value="1">上架</option>
                                            <option value="0">下架</option>


                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled selected {{ $book->id ? '' : 'selected' }}>请选择分类</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}" {{ $book->category_id == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <textarea name="description" class="form-control" id="editor" rows="6" placeholder="请填入至少三个字符的描述。" required>{{ old('description', $book->description ) }}</textarea>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="" class="avatar-label">封面图片</label>
                                        <input type="file" name="image" class="form-control-file">

                                        @if($book->image)
                                            <br>
                                            <img class="thumbnail img-responsive" src="{{ $book->image }}" width="200" />
                                        @endif
                                    </div>

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection
