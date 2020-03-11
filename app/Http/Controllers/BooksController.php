<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth', ['except' => ['index', 'show','edit']]);
    }


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
//            ->orderBy('created_at','desc');

        $cateId = $request->input('cateId', '');
        //模糊查询
        if ($search = $request->input('search', '')) {

            $like = '%'.$search.'%';
            if(!$cateId){
                $book->where(function ($query) use ($like){
                    $query->where('name', 'like', $like)
                        ->orWhere('author', 'like', $like);
                });
            }
            else{
                $book->where(function ($query) use ($like){
                    $query->where('name', 'like', $like)
                        ->orWhere('author', 'like', $like);
                })->where('category_id',$cateId);
            }

        }
        //未完成
        if ($order = $request->input('order', '')){


            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if(!$cateId&&in_array($m[1], ['price'])){
                    //none cateId
                    $book->orderBy($m[1], $m[2]);
                }
                else if (in_array($m[1], ['price'])) {
                    // 根据传入的排序值来构造排序参数
                    $book->where('category_id',$cateId)->orderBy($m[1], $m[2]);
                }
            }
        }

        $books = $book->paginate(8);

        return view('books.index', [
            'books' => $books,
            'cateId'  => $cateId,
            'filters'  => [
                'search' => $search,
                'order'  => $order,
                'cateId'  => $cateId,
            ],
        ]);
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

        $favored = false;
        // 用户未登录时返回的是 null，已登录时返回的是对应的用户对象
        if($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索 id 为当前商品 id 的商品
            // boolval() 函数用于把值转为布尔值
            $favored = boolval($user->favoriteBooks()->find($book->id));
        }

        return view('books.show', ['book' => $book, 'favored' => $favored]);
    }

    /**
     * 添加图书
     * @param Book $book
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: hefusheng 2020/3/11
     */
    public function create(Book $book,User $user)
    {
        $categories = Category::all();
        return view('books.create_and_edit', [
            'user' => $user,
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    /**
     * 编辑图书
     * @param Book $book
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @author: hefusheng 2020/3/11
     */
    public function edit(Book $book,User $user)
    {
        $categories = Category::all();
        return view('books.create_and_edit', [
            'user' => $user,
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    public function update(BookRequest $request,Book $book){
        $this->authorize('update', $book);
        $book->update($request->all());

        return redirect()->route('books.show', $book->id)->with('success', '更新成功！');
    }

    /**
     * 保存图书
     * @param BookRequest $request
     * @param Book $book
     * @param ImageUploadHandler $uploader
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @author: hefusheng 2020/3/11
     */
    public function store(BookRequest $request, Book $book,ImageUploadHandler $uploader, User $user)
    {
        $book->fill($request->all());
        $book->user_id = Auth::id();

        if ($request->image) {
            $result = $uploader->save($request->image, 'books', $user->id);
            if ($result) {
                $book['image'] = $result['path'];
            }
        }
        $book->save();

        return redirect()->route('books.show', $book->id)->with('success', '新建图书成功！');
    }

    //未完成
    public function favor(Book $book, Request $request)
    {
        $user = $request->user();
        if ($user->favoriteBooks()->find($book->id)) {
            return [];
        }

        $user->favoriteBooks()->attach($book);

        return [];
    }

    public function disfavor(Book $book, Request $request)
    {

        $user = $request->user();
        $user->favoriteProducts()->detach($book);

        return [];

    }
}
