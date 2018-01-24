<?php if (count($comments)) : ?>
    <?php foreach ($comments as $comment) : ?>
        <?php
            $this->renderPartial('_comment', array('comment' => $comment, false, true));
        ?>
    <?php endforeach; ?>
        <hr/>
        <?php
        $this->widget('LinkPager', array(
            'pages' => $pages,
            'maxButtonCount' => 5,
            'firstPageLabel' => 1,
            'prevPageLabel' => '<i class="uk-icon-caret-left"></i>',
            'nextPageLabel' => '<i class="uk-icon-caret-right"></i>',
            'lastPageLabel' => '<strong>' . $pages->pageCount . '</strong>',
            'htmlOptions' => array(
                'class' => 'uk-pagination uk-pagination-right'
            ),
            'selectedPageCssClass' => 'selected-page-item-class',
            'header' => ''
        ));
        ?>
<?php else : ?>
    <span id="no_comments">
        <i><?= Yii::t('base', 'No comments') ?></i>
        <br/><br/>
    </span>
<?php endif; ?>