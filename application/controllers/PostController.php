<?php

namespace application\controllers;

use application\components\IpApi;
use application\components\Messages;
use application\models\ArticleModel;
use core\auth\Auth;
use core\controllers\BaseController;

class PostController extends BaseController
{
    /**
     * action for all posts
     * @return \core\View
     */
    public function index()
    {
        $posts = (new ArticleModel())->orderBy('id', 'desc')->all();
        return $this->view('index', [
            'posts' => $posts,
        ]);
    }

    /**
     * action for form for create post
     * @return \core\View
     */
    public function create()
    {
        return $this->view('create');
    }

    public function edit($id)
    {
        $this->checkIfAuthenticated();

        $post = (new ArticleModel())->find($id);
        $this->checkMembersPost($post);

        return $this->view('edit', [
            'post' => $post,
        ]);
    }

    public function update($id)
    {
        $this->checkIfPost();
        $this->checkMembersPost($id);
        $data = $_POST;
        if ($this->validatePost($data, $id)) {
            (new ArticleModel())->update([
                'title' => $data['title'],
                'content' => $data['content'],
            ], $id);
            Messages::success(['Post successfully updated.']);
        }
        return $this->redirect('post/edit', ['id' => $id]);
    }

    protected function checkMembersPost($post)
    {
        if (!$post instanceof ArticleModel) {
            $post = (new ArticleModel())->find($post);
        }
        if ($post === null || $post->result['member_id'] !== Auth::getUserId()) {
            Messages::error(['You don\'t have permissions']);
            return $this->redirect('/');
        }
    }

    /**
     * action for create post
     */
    public function store()
    {
        $this->checkIfPost();
        $this->checkIfAuthenticated();
        $data = $_POST;
        if ($this->validatePost($data)) {
            (new ArticleModel())->create([
                'title' => $data['title'],
                'content' => $data['content'],
                'member_id' => Auth::user()->result['id'],
                'country_code' => Auth::getCountryCode()
            ]);
            Messages::success(['Article successfully created.']);
            return $this->redirect('/');
        }
        return $this->redirect('post/create');
    }

    /**
     * action for validate date for post
     * @param $request
     * @return bool
     */
    protected function validatePost($request, $except = false)
    {
        if (!isset($request['title']) || strlen($request['title']) < 2) {
            Messages::error(['Invalid title field.']);
            return false;
        }

        if (!isset($request['content']) || strlen($request['content']) < 2) {
            Messages::error(['Invalid content field.']);
            return false;
        }
        $article = (new ArticleModel())->where('title', $request['title']);
        if ($except !== false) {
            $article->where('id', '!=', $except);
        }
        $article = $article->all();

        if (!empty($article)) {
            Messages::error(['Title already exist.']);
            return false;
        }

        return true;
    }
}