<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TopicController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model = Topic::with(['category', 'user']);

        return Grid::make($model, function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('user.name', admin_trans_field('user'));
            $grid->column('category.name', admin_trans_field('category'));
            $grid->column('reply_count');
            $grid->column('view_count');
            $grid->column('last_reply_user_id');
            $grid->column('order');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $model = Topic::with(['category', 'user']);

        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('body')->unescape();
            $show->field('user.name', admin_trans_field('user'));
            $show->field('category.name', admin_trans_field('category'));
            $show->field('reply_count');
            $show->field('view_count');
            $show->field('last_reply_user_id');
            $show->field('order');
            $show->field('excerpt');
            $show->field('slug');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Topic(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->select('user_id', admin_trans_field('user'))->options(User::orderBy('id', 'desc')
                ->pluck('name', 'id'));
            $form->radio('category_id', admin_trans_field('category'))->options(Category::orderBy('id', 'desc')
                ->pluck('name', 'id'));
            $form->editor('body');
            $form->text('order');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
