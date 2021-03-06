<div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-2 uk-flex uk-flex-space-between uk-flex-middle uk-margin-bottom sort-block">
    <div class="before-ready-hidden">
        <span class="uk-margin-right-mini uk-display-inline-block"><?php echo Yii::t('base', 'sort by'); ?>:</span>
        <?php
        echo CHtml::dropDownList('sort', (isset($_GET['sort'])) ? $_GET['sort'] : 'date_added',
            array('date_added' => 'new', 'asc' => 'price low - high', 'desc' => 'price high - low', 'sale' => 'sale'),
            array(
                'class' => 'js-select',
                'style' => 'width: 108px;')
        );
        echo CHtml::hiddenField('h_sort', (isset($_GET['sort']) ? $_GET['sort'] : ''));
        ?>
    </div>
    <div>
        <?php
        echo CHtml::ajaxLink(
            Yii::t('base', 'view all'),
            '',
            array(
                'data' => array(
                    'pageSize' => 'all',
                    'sort' => 'js:function() {
                                    if($("#h_sort").val()) {
                                        return $("#h_sort").val();
                                    } else {
                                        return "";
                                    }
                                }'
                ),
                'update' => '#products',
                'beforeSend' => 'function() {
                                    $("#content").addClass("loading");
                                }',
                'complete' => 'function() {
                                    $("#content").removeClass("loading");
                                    $(".ten").show();
                                    $(".all").hide();
                                    $("#h_pageSize").val("all");
                                    $("#sort [value=\'"+sort+"\']").attr("selected", "selected");
                                }',
            ),
            array(
                'class' => 'all pageSize uk-base-link',
                //'style' => ($pages->pageCount <= 1) ? 'display:none' : ''
            )
        );

        echo CHtml::ajaxLink(
            Yii::t('base', 'view') . ' ' . $this->pageSize . ' ' . Yii::t('base', 'items'),
            '',
            array(
                'data' => array(
                    'pageSize' => $this->pageSize,
                    'sort' => 'js:function() {
                        if($("#h_sort").val()) {
                            return $("#h_sort").val();
                        } else {
                            return "";
                        }
                    }'
                ),
                'update' => '#products',
                'beforeSend' => 'function() {
                        $("#content").addClass("loading");
                    }',
                'complete' => 'function() {
                        $("#content").removeClass("loading");
                        $(".all").show();
                        $(".ten").hide();
                        $("#h_pageSize").val("' . $this->pageSize . '");
                        $("#sort [value=\'"+sort+"\']").attr("selected", "selected");
                    }',
            ),
            array(
                'class' => 'ten pageSize',
                'style' => 'display:none'
            )
        );

        echo CHtml::hiddenField('h_pageSize', (isset($_GET['pageSize']) ? $_GET['pageSize'] : ''));
        ?>
    </div>
</div>
<div class="uk-width-1-1 uk-width-large-1-2 uk-width-medium-1-2 uk-width-small-1-1 pagination-block">
    <?php
    $this->widget('LinkPager', array(
        'pages' => $pages,
        'maxButtonCount' => 5,
        'firstPageLabel' => 1,
        'prevPageLabel' => '<i rel="prev" class="uk-icon-caret-left"></i>',
        'nextPageLabel' => '<i rel="next" class="uk-icon-caret-right"></i>',
        'lastPageLabel' => '<strong>' . $pages->pageCount . '</strong>',
        'htmlOptions' => array(
            'class' => 'uk-pagination uk-pagination-right'
        ),
        'selectedPageCssClass' => 'selected-page-item-class',
        'header' => ''
    ));
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // re-init js-select uikit element
        if(typeof select_init != 'undefined'){
            select_init();

            $('.before-ready-hidden').css('visibility', 'visible');
        }        
    });
</script>


