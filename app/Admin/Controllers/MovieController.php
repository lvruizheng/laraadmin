<?php

namespace App\Admin\Controllers;

use App\Models\Movie;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MovieController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Movie::class, function (Grid $grid) {
            // 第一列显示id字段，并将这一列设置为可排序列
            $grid->id('ID')->sortable();
            
            // 第二列显示title字段，由于title字段名和Grid对象的title方法冲突，所以用Grid的column()方法代替
            $grid->column('title','标题');
            
            // 第三列显示director字段，通过display($callback)方法设置这一列的显示内容为users表中对应的用户名
            $grid->director('作者')->display(function($userId) {
                return User::find($userId)->name;
            });
            
            // 第四列显示为describe字段
            $grid->describe('描述');
            
            // 第五列显示为rate字段
            $grid->rate('价格');
            
            // 第六列显示released字段，通过display($callback)方法来格式化显示输出
            $grid->released('上映?')->display(function ($released) {
                return $released ? '是' : '否';
            });

            // 下面为三个时间字段的列显示
            $grid->release_at('发布时间');
            $grid->created_at('创建时间');
            $grid->updated_at('上次修改');
            
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('created_at', '创建时间')->datetime();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Movie::class, function (Form $form) {

            $form->display('id', 'ID');
            
            $form->text('title', '标题');
            $form->editor('describe', '描述');
            
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
