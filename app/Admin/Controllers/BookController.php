<?php

namespace App\Admin\Controllers;

use App\Models\Book;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '书本';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Book);

        $grid->id('ID')->sortable();
        $grid->name('书本名称');
        $grid->author('作者');
        $grid->book_status('已上架')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->price('价格');

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Book::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('image', __('Image'));
        $show->field('author', __('Author'));
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('book_status', __('Book status'));
        $show->field('user_id', __('User id'));
        $show->field('category_id', __('Category id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Book);

        // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
        $form->text('name', '书本名称')->rules('required');

        $form->text('author', '作者')->rules('required');

        $form->text('price', '单价')->rules('required|numeric|min:0.01');

        $form->text('user_id', '用户id')->rules('required');

//        $form->text('category_id', '分类id')->rules('required');
        $form->select('category_id', '所属分类')->options( Category::all()->pluck('name', 'id')->toArray());
        // 创建一个选择图片的框
        $form->image('image', '封面图片')->rules('required|image');

        // 创建一个富文本编辑器
        $form->quill('description', '商品描述')->rules('required');



        // 创建一组单选框
        $form->radio('book_status', '上架')->options(['1' => '是', '0'=> '否'])->default('0');


        return $form;
    }
}
