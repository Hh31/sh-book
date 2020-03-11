<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * 各个分类下图书首页
     * @param Request $request
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: hefusheng 2020/3/11
     */
    public function category(Request $request, $categoryId)
    {
        $book = Book::query()
            ->where('book_status', true)
            ->where('category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(8);


        //模糊查询
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            $book->where(function ($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhere('author', 'like', $like);
            });
        }

        //未完成
//        if ($order = $request->input('order', '')) {
//            dd($book);
//            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
//                if (in_array($m[1], ['price'])) {
//                    // 根据传入的排序值来构造排序参数
//                    $book->orderBy($m[1], $m[2]);
//                }
//            }
//        }
//        dd($categoryId);

//        $books = $bookÞ->paginate(3);//还需更新

        return view('books.index', [
            'books' => $book,
            'cateId' => $categoryId,

            'filters' => [
////                'search' => $search,
////                'order' => $order,
                'cateId' => $categoryId,
            ],
        ]);
    }


}
