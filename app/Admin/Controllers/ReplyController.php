<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ReplyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model = Reply::with(['topic', 'user']);

        return Grid::make($model, function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('topic.title', admin_trans_field('topic'));
            $grid->column('user.name', admin_trans_field('user'));
            $grid->column('content');
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
        $model = Reply::with(['topic', 'user']);

        return Show::make($id, $model, function (Show $show) {
            $show->field('id');
            $show->field('topic.title', admin_trans_field('topic'));
            $show->field('user.name', admin_trans_field('user'));
            $show->field('content');
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
        return Form::make(new Reply(), function (Form $form) {
            $form->display('id');
            $form->select('topic_id', admin_trans_field('topic'))->options(Topic::orderBy('id', 'desc')
                ->pluck('title', 'id'));
            $form->select('user_id', admin_trans_field('user'))->options(User::orderBy('id', 'desc')
                ->pluck('name', 'id'));
            $form->text('content');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
