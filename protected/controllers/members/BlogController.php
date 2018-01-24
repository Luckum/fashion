<?php

class BlogController extends Controller
{
    public $title;
    public $pageSize = 10;
    public $commentsPageSize = 10;
    public $meta_description;

    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('page')) {
            Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        }

        $criteria = new CDbCriteria();
        $criteria->scopes = array('recently', 'published');
        $count = BlogPost::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = $this->pageSize;
        $pages->applyLimit($criteria);

        $criteria->with = array('publishedComments');
        $posts = BlogPost::model()->findAll($criteria);

        $this->title = Yii::t('base', 'Blog');
        $this->render(
            'index',
            array(
                'posts' => $posts,
                'pages' => $pages,
            )
        );
    }

    public function actionPost($id)
    {
        $post = $this->loadModel($id);
        if (!empty($post->seo_title)) {
            $this->title = $post->seo_title;
        }
        if (!empty($post->seo_description)) {
            $this->meta_description = $post->seo_description;
        }

        list($comments, $pages) = $this->getAllPublishedComments($id);

        if (isset($_GET['comments_only'])) {
            Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots');
            $this->renderPartial('_comments', array('comments' => $comments, 'pages' => $pages));
            die();
        }

        $this->render(
            'post',
            array(
                'post' => $post,
                'comments' => $comments,
                'pages' => $pages,
            )
        );
    }

    public function actionCategory($id)
    {
        if (Yii::app()->request->getQuery('page')) {
            Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        }

        $category = BlogCategory::model()->findByPk($id);
        if (!$category) {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        $count = count($category->posts(array(
            'select' => false,
            'scopes' => array('recently', 'published')
        )));

        $pages = new CPagination($count);
        $pages->pageSize = $this->pageSize;
        $posts = $category->posts(array(
            'limit' => $pages->getLimit(),
            'offset' => $pages->getOffset(),
            'scopes' => array('recently', 'published')
        ));

        $this->title = Yii::t('base', 'Blog posts by category');
        $this->render(
            'index',
            array(
                'posts' => $posts,
                'pages' => $pages,
            )
        );
    }

    public function actionTag($id)
    {
        if (Yii::app()->request->getQuery('page')) {
            Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        }

        $tag = BlogTag::model()->findByPk($id);
        if (!$tag) {
            throw new CHttpException(404,'The requested page does not exist.');
        }

        $count = count($tag->posts(array(
            'select' => false,
            'scopes' => array('recently', 'published')
        )));

        $pages = new CPagination($count);
        $pages->pageSize = $this->pageSize;
        $posts = $tag->posts(array(
            'limit' => $pages->getLimit(),
            'offset' => $pages->getOffset(),
            'scopes' => array('recently', 'published')
        ));

        $this->title = Yii::t('base', 'Blog posts by tag');
        $this->render(
            'index',
            array(
                'posts' => $posts,
                'pages' => $pages,
            )
        );
    }

    public function actionNewComment()
    {
        // Только Ajax-запрос.
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(403, 'Forbidden');
        }
        // Проверяем входные параметры.
        if (!isset($_POST['id'], $_POST['comment']) ||
            !is_numeric($_POST['id']) ||
            !strlen($_POST['comment'])
        ) {
            throw new CHttpException(400, 'Bad Request');
        }
        $post = BlogPost::model()->findByPk($_POST['id']);
        if (!$post || Yii::app()->member->isGuest || !$post->allow_add_comments) {
            throw new CHttpException(403, 'Forbidden');
        }
        // Добавляем новый комментарий.
        $comment = new BlogComment();
        $comment->post_id = $_POST['id'];
        $comment->author_id = Yii::app()->member->id;
        $comment->status = BlogComment::COMMENT_STATUS_PUBLISHED;
        $comment->content = $_POST['comment'];

        if ($comment->save()) {
            list($comments, $pages) = $this->getAllPublishedComments($comment->post_id);
            $html = $this->renderPartial('_comments', array('comments' => $comments, 'pages' => $pages), true);
            // Комментарий успешно добавлен.
            die(CJSON:: encode(array(
                'result' => 'ok',
                'html' => $this->renderPartial(
                    '_comments',
                    array(
                        'comments' => $comments,
                        'pages' => $pages
                    ),
                    true
                )
            )));
        } else {
            // Не удалось сохранить комментарий.
            die(CJSON:: encode(array(
                'result' => 'error'
            )));
        }
    }

    public function getAllPublishedComments($postId)
    {
        Yii::app()->clientScript->registerMetaTag('noindex,follow', 'robots');
        $criteria = new CDbCriteria();
        $criteria->scopes = array('recently', 'published');
        $criteria->condition = 'post_id = ' . intval($postId);
        $count = BlogComment::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = $this->commentsPageSize;
        $pages->applyLimit($criteria);
        $pages->route = 'members/blog/post';
        $pages->params = array(
            'id' => $postId,
            'comments_only' => 1
        );

        $comments = BlogComment::model()->findAll($criteria);

        return array($comments, $pages);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return BlogPost the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=BlogPost::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}