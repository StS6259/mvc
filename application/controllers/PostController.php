<?php

namespace application\controllers;

use application\components\IpApi;
use application\models\ArticleModel;
use core\auth\Auth;
use core\controllers\BaseController;

class PostController extends BaseController
{
    public function index()
    {
        $posts = (new ArticleModel())->orderBy('id', 'desc')->all();

        return $this->view('index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        dd(IpApi::getGeo());
        return $this->view('create');
    }

    public function store()
    {
        $this->checkForPost();
        $this->checkIfAuthenticated();
        $data = $_POST;
        if ($this->validatePost($data)) {
            (new ArticleModel())->create([
                'title' => $data['title'],
                'content' => $data['content'],
                'member_id' => Auth::user()->result['id'],
            ]);

            return $this->redirect('/');
        }
        return $this->redirect('post/create');
    }

    protected function validatePost($request)
    {
        if (!isset($request['title']) || strlen($request['title']) < 2) {
            return false;
        }

        if (!isset($request['content']) || strlen($request['content']) < 2) {
            return false;
        }
        $article = (new ArticleModel())->where('title', $request['title'])->all();

        if (!empty($article)) {
            return false;
        }

        return true;
    }
}