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

    /**
     * action for create post
     */
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
    protected function validatePost($request)
    {
        if (!isset($request['title']) || strlen($request['title']) < 2) {
            Messages::error(['Invalid title field.']);
            return false;
        }

        if (!isset($request['content']) || strlen($request['content']) < 2) {
            Messages::error(['Invalid content field.']);
            return false;
        }
        $article = (new ArticleModel())->where('title', $request['title'])->all();

        if (!empty($article)) {
            Messages::error(['Title already exist.']);
            return false;
        }

        return true;
    }
}