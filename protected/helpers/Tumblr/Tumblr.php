<?php
/**
 * Класс для работы с Tumblr.
 * Tumblr — служба микроблогов, включающая в себя множество картинок, статей, видео и gif-изображений
 * по разным тематикам и позволяющий пользователям публиковать посты в их тамблелог.
 */
class Tumblr
{
    public $client;
    public $blogName;

    /**
     * Конструктор класса.
     */
    public function __construct()
    {
        // Инициализируем автозагрузку необходимых классов.
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'vendor' .
                               DIRECTORY_SEPARATOR . 'autoload.php');

        // Авторизация в системе Tumblr с последующим доступом к API через $this -> client.
        $this -> client = new Tumblr\API\Client(
            'msNktoEvaVlF4dBW29rkGF0XHY4aTQ2Q3duiQdhaxbSkA20xB5',
            'x4od5gaoCdDGGOndZgMUZidwEOLsIthwfEQmwgUMGldaR0T33V',
            'kesozjVDNUT5kmiXKIFW16wNZboo4GJ3x3eaCgg0poRT49Vp9G',
            'l2TxCj7L7HOjSc295xY5SHLkq0fqZoNXyAVKPpvssR23cSIIeQ'
        );

        // Имя блога.
        $this -> blogName = Yii::app() -> params['misc']['blog_url'];
    }

    /**
     * Добавление нового поста в Tumblr.
     */
    public function addNewPost()
    {
    }

    public function getPosts($limit, $offset)
    {
        $posts = array();
        $limit = min($limit, 20);

        $posts_tmp = $this->client->getBlogPosts($this -> blogName, array(
            'type' => 'photo',
            'limit' => $limit,
            'offset' => $offset,
            'notes_info' => true
        ));
        // echo '<pre>';
        // print_r($posts_tmp);die();
        if (isset($posts_tmp->posts)) {
            foreach ($posts_tmp->posts as $post) {
                $new_post = array();

                $new_post['photo'] = '';
                $new_post['url'] = $post->post_url;
                $new_post['summary'] = $post->summary;
                $new_post['photo_caption'] = '';
                $new_post['tags'] = $post->tags;
                if (!empty($post->photos)) {
                    $photo = array_shift($post->photos);
                    $new_post['photo'] = $photo->original_size->url;
                    $new_post['photo_caption'] = $photo->caption;
                }
                $new_post['date'] = date('d.m.Y', $post->timestamp);

                $posts[] = $new_post;
            }
        }

        return array($posts, $posts_tmp->total_posts);
    }
}