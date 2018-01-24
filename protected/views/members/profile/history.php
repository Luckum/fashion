<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
    'Client Area' => array('members/index'),
    'History Profile' => '',
);
?>

<!--ACCOUNT BLOCK-->
<div class="uk-block uk-block-large uk-margin-top">
    <div class="uk-container uk-container-center">
        <div class="uk-accordion account-wrapper" data-uk-accordion='{showfirst: true, animate: false}'>
            <div class="uk-grid">
                <div class="uk-width-large-7-10 uk-width-medium-7-10 uk-width-small-1-1">
                    <div class="uk-grid">
                        <!--PROFILE NAV-->
                        <?php $this->renderPartial('_profile_nav', array('showProfile' => (isset($showProfile) ? true : false))); ?>
                        <!--END PROFILE NAV-->
                        <!--HISTORY ITEMS-->
                        <div class="uk-width-1-1 uk-width-large-3-4 uk-width-medium-1-1 uk-width-small-1-1">
                            <div id="history_items">
                                <?php $this->renderPartial('_history_items', array('user'=>$user, 'items_sold' => $items_sold)); ?>
                            </div>
                        </div>
                        <!--END HISTORY ITEMS-->
                    </div>
                </div>
                <!--PROFILE INFO-->
                <div
                    class="uk-width-1-1 uk-width-large-3-10 uk-width-medium-3-10 uk-width-small-1-1 margin-top-small-screen">
                    <?php $this->renderPartial('_nav_info', array('user' => $user)); ?>
                </div>
                <!--END PROFILE INFO-->
            </div>
        </div>
    </div>
</div>
<!--END ACCOUNT BLOCK-->

<script type="text/javascript">
    $(document).on("click", '.table tbody tr.order_raw',function() {
        if ($(this).hasClass('active_raw')) {
            $(this).removeClass('active_raw');

            $(".item"+$(this).data('id')).each(function(indx, element){
                $(element).hide();
            });
        } else {
            $(".order_raw").each(function(indx, element){
                $(element).removeClass('active_raw');
            });

            $(".order_item").each(function(indx, element){
                $(element).hide();
            });

            $(this).addClass('active_raw');

            $(".item"+$(this).data('id')).each(function(indx, element){
                $(element).css('display', 'table-row');
            });
        };
    });
</script>

<script type="text/javascript">
    $('.review-link').on("click", function (e) {
        $('#review-div').innerHTML = '';
        e.preventDefault();
        $.ajax({
            type: "POST",
            cache: false,
            url: "<?=Yii::app()->request->getBaseUrl(false).'/members/profile/review' ?>",
            data: {id: $(this).data('id')},
            success: function (data) {
                $('#review-div').html(data);
            }
        });
    });

    $('.review a[href="#change-status"]').on('click', function() {
        var status = $(this).data('status');
        $('.set-received-status')
            .data('oid',    $(this).data('oid'))
            .data('pid',    $(this).data('pid'))
            .data('status', status);
        var select = $('#up-status');
        if (!select.find('option[value="' + status + '"]').length) {
            select.append(new Option(status, status));
        }
    });

    $(document).on("click", '.add_review',function() {
        var j$this = $(this);
        var form = j$this.parents('form');
        var url = form.attr('action');
        var data = form.serializeArray();

        $.ajax({
            type: 'POST',
            data: data,
            url: url,
            success: function(data) {
                if(data == 1) {
                    $(".review").find("[data-id='" + form.find('#product_id').val() + "']").hide();
                    $("#review-div").innerHTML = "";
                    $("#review-div").html('Thanks for your review');
                }
            }
        });
        return false;
    });

    /**
     * Устанавливает для продукта статус получено (received).
     */
    $('.set-received-status').on('click', function() {
        var dataContainer = $('.set-received-status');
        var url = '<?=Yii :: app() -> request -> getBaseUrl(false) . '/members/profile/setStatusForProduct' ?>';
        var data = {
            'status' : dataContainer.data('status'),
            'oid'    : dataContainer.data('oid'),
            'pid'    : dataContainer.data('pid')
        };
        $.post(url, data, function (response) {
            if (typeof response == 'string' && response.length) {
                var data = JSON.parse(response);
                if (data.result == 'ok') {
                    location.reload();
                }
            }
        });
    });
</script>