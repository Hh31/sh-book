<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * 首页预取书本数据
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: hefusheng 2020/1/16
     */
    public function index(Request $request)
    {
        $book = Book::query()
            ->where('book_status', true);


        //模糊查询
        if ($search = $request->input('search', '')) {
            $like = '%'.$search.'%';
            $book->where(function ($query) use ($like){
                $query->where('name', 'like', $like)
                    ->orWhere('author', 'like', $like);
            });
        }

        //未完成
        if ($order = $request->input('order', '')){
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price'])) {
                    // 根据传入的排序值来构造排序参数
                    $book->orderBy($m[1], $m[2]);
                }
            }
        }

        $books = $book->paginate(8);

        return view('books.index', [
            'books' => $books,
            'filters'  => [
                'search' => $search,
                'order'  => $order,
            ],
        ]);
    }

    public function category(){
        $categoryId = 1;
        $books = Book::query()
            ->where('book_status',true)
            ->where('category_id',$categoryId)
            ->orderBy('created_at','desc')
            ->paginate(8);

        return view('books.index', ['books' => $books]);
    }

    /**
     * 书本详情
     * @param Book $book
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @author: hefusheng 2020/1/16
     */
    public function show(Book $book, Request $request)
    {
        // 判断商品是否已经上架，如果没有上架则抛出异常。
        if (!$book->book_status) {
            throw new InvalidRequestException('商品未上架');
        }

        return view('books.show', [
            'book' => $book,
        ]);
    }
}
