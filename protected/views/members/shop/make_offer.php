<div class="row-fluid">
    <div class="offset2 span8 prod_details_info">
        <div class="row-fluid">
            <div class="offset4 span5 pull-left">
                <h3 class="text-left"><?=Yii::t('base', 'make an offer')?></h3>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class='product_img'>
                    <?=CHtml::image(Yii::app()->request->getBaseUrl(true). ShopConst::IMAGE_THUMBNAIL_DIR .$product->image1, $product->title )?>
                </div>    
            </div>
            <div class="span7" style="margin-left:10%">
                <p class="margin-bottom-0"><strong><?=Brand::getFormatedTitle(CHtml::encode($product->brand->name))?></strong></p>
                <p><?=CHtml::encode($product->description)?></p>
                <p class="margin-bottom-0"><?=Yii::t('base', 'Original price')?>:</p>
                <p><strong>&euro;&nbsp;<?=CHtml::encode($product->price)?></strong></p>

                <div class="custom-form" style="margin-top:30px">
                    <div class="row-fluid">
                        <div class="span6">
                            <?=CHtml::label(Yii::t('base', 'Your offer'), 'offer_price', array('style'=>'text-align:center')); ?>
                            <div class="pull-left" style="font-size:1.5em">&euro;&nbsp;&nbsp;</div><?=CHtml::textField('offer_price', '', array('class'=>'span9'))?>
                        </div>
                    </div>
                    <div class="row-fluid" style="margin-top:10px">
                        <div class="span5">
                            <div class="pull-right">
                                <?php echo CHtml::link(Yii::t('base', 'submit'),'', array('class'=>'button', 'id'=>'submit_offer')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="span12" style="margin-top:15px"><?=Yii::t('base', 'You will get an email once the seller accepts or denies your offer.')?></div>
    </div>
</div>

<script type="text/javascript">
    $('#offer_price').keyup(function(e) {
        this.value = this.value.replace(/^\.|[^\d\.]|\.(?=.*\.)|^0+(?=\d)/g, '');
    });
</script>