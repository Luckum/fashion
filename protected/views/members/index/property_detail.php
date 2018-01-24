<!-- content -->
<div id="content" style="<?php echo (!empty($disableLeftModule)) ? 'margin:0; width:768px' : ''?>">
    <div id="item_box" style="<?php echo (!empty($disableLeftModule)) ? 'width:710px' : ''?>">
<a href="javascript:window.history.back()" class="return_link">[ <?php echo lang('Back') ?> ]</a>
        <h2>
<?php if (!empty($property['island'])) : ?>
<?php echo lang('Island') ?> &nbsp;<?php echo $property['island'] ?>,
<?php elseif (!empty($property['city'])) : ?>
<?php echo lang('City') ?> &nbsp;<?php echo $property['city'] ?>,
<?php endif ?>
&nbsp;<?php echo lang('Croatia') .(empty($property['special_note']) ? '' : (', '.$property['special_note'])) ?>,
<?php $propertyTitle = empty($property['title_'.$this->session->userdata('language')])
    ? $property['title_'.Language::EN]
    : $property['title_'.$this->session->userdata('language')] ?>
<?php echo (isset($property['location'])) ? mb_convert_encoding($property['location'] . ' - ', 'HTML-ENTITIES') : '' ?>    
<?php echo mb_convert_encoding($propertyTitle, 'HTML-ENTITIES') ?>
        </h2>
        <?php
                $br=0;
                $type_val ='';
                foreach($property['types'] as $type){
                    if($br==0){
                        $type_val.= $type;
                    }else{
                    $type_val.= '/'.$type;
                    }
                    $br++;
                }
                $st_br = 1;
                $st_num = count($property['statuses']);
                $statuses='';
            foreach($property['statuses'] as $st){
                if($st_num==1){
                    $statuses = $st;
                }else{
                    if($st_br==($st_num-1)){
                    $statuses.= $st.' '.lang('and').' ';    
                    }elseif($st_br<$st_num){            
                    $statuses.= $st.', ';
                    }else{
                        $statuses.= $st;
                    }
                }
                $st_br++;
            }
        ?>
        <div class="ref"><?php echo lang('Ref') ?> : <?php echo $property['reference_no'] ?>,
            <?php
            /*$lang_sep = lang('for');*/
            $lang_sold = lang('Sold');
            if($statuses==$lang_sold){
                $lang_sep = lang('is');
            }
            echo mb_convert_encoding($type_val, 'HTML-ENTITIES').' '.mb_convert_encoding($statuses, 'HTML-ENTITIES'); ?>
			<!--echo mb_convert_encoding($type_val, 'HTML-ENTITIES').' '.mb_convert_encoding($lang_sep, 'HTML-ENTITIES').' '.mb_convert_encoding($statuses, 'HTML-ENTITIES'); ?>-->
        </div>
        <a href="<?php echo base_url("create_property_pdf/{$property['property_id']}")?>" id="buttons">
            <img alt="PDF Create" src="<?php echo base_url() ?>/assets/images/pdf_button.png" />
        </a>
        <?php $imageUrl = empty($property['images']) ? 'assets/images/no_photo.png' : "assets/uploads/{$property['property_id']}/{$property['images'][0]}"; ?>
        <a class="gallery-images clear" href="<?php echo base_url($imageUrl) ?>" rel="gallery">
            <img style="<?php echo (!empty($disableLeftModule)) ? 'width:710px' : 'width: 500px;'?>" alt="<?php echo lang('Property Image') ?>" src="<?php echo base_url($imageUrl) ?>" />
        </a>
        <?php if (!empty($property['images'])) :
            ?>
        <div id="gallery-scroll" class="clear" style="<?php echo (!empty($disableLeftModule)) ? 'width:710px' : ''?>">
            <?php foreach ($property['images'] AS $key=>$image) :
                $relGallery = ($key==0)? 'other': 'gallery';
                ?>
            <?php if($key!=0): ?>
            <a class="gallery-images" rel='<?php echo $relGallery;  ?>' href="<?php echo base_url("assets/uploads/{$property['property_id']}/{$image}") ?>">
			<img style="<?php echo (!empty($disableLeftModule)) ? 'width:167px;height:115px' : ''?>"alt="<?php echo lang('Property Image') ?>" src="<?php echo base_url("assets/uploads/{$property['property_id']}/thumb_image/{$image}") ?>" /></a>
            <?php endif; ?>
            <?php endforeach ?>
        </div>
        <?php endif ?>

        <div class="item_1" style="<?php echo (!empty($disableLeftModule)) ? 'margin:0;width:350px' : ''?>">
            <span class="price"><?php echo lang('Selling price') ?>: <strong><?php echo empty($property['price']) ? showMessageForEmptyPrice($this->session->userdata('language')) : number_format($property['price'],0,".",".") . mb_convert_encoding(' €', 'HTML-ENTITIES') ?></strong></span><br/><br/>
            <?php if (!empty($property['slogan'])) : ?>
            <span class="slogan"><?php echo $property['slogan'] ?></span><br/>
            <?php endif ?>
            <h3><?php echo mb_convert_encoding(lang('Location'), 'HTML-ENTITIES') ?> : <strong><?php echo(isset($property['location']))? mb_convert_encoding($property['location'], 'HTML-ENTITIES'): ''; ?><br/></strong></h3>

            <?php if (!empty($property['is_sea_front'])) : ?>
            <span class="clear">
                <?php echo lang('First row to the sea') ?>
            </span>
            <?php endif ?>
        </div>
        <div class="item_1" style="<?php echo (!empty($disableLeftModule)) ? 'margin:0;width:350px' : ''?>">
            <button id="add-button"><?php echo lang('Add to My List') ?></button>
            <a class="my_list" href="<?php echo site_url('my_list/'.$this->session->userdata('language')) ?>"><strong><?php echo lang('My List') ?></strong></a> <br/><br/>
            <?php echo lang('Note: use this button to add this real-estate to Your list. You can access it later choosing My List link.') ?>
        </div>

        <div class="clr">&nbsp;</div>

        <?php if (!empty($property['advantages'])) : ?>
        <div class="item_1" style="<?php echo (!empty($disableLeftModule)) ? 'margin:0;width:350px' : ''?>">
            <h3><?php echo lang('Advantages') ?>: </h3>
            <ul>
                <?php foreach ($property['advantages'] AS $advantage): ?>
                    <li><?php echo mb_convert_encoding($advantage, 'HTML-ENTITIES') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif ?>

        <div class="item_1" style="<?php echo (!empty($disableLeftModule)) ? 'margin:0;width:350px' : ''?>">
            <h3><?php echo lang('Description') ?> :</h3>
            <p>
                <?php echo lang('Living space') ?> : <strong><?php echo $property['living_space'] . mb_convert_encoding('m²', 'HTML-ENTITIES')?></strong> <br/>
                <?php echo mb_convert_encoding(lang('Land space'), 'HTML-ENTITIES') ?> : <strong><?php echo empty($property['land_size']) ? 0 : $property['land_size'] . mb_convert_encoding('m²', 'HTML-ENTITIES')?></strong> <br/>
                <?php echo lang('Number of rooms') ?> : <strong><?php echo $property['number_of_rooms'] ?></strong> <br/>
                <?php echo lang('Number of floors') ?> : <strong><?php echo $property['number_of_floors'] ?></strong> <br/>
                <?php echo lang('Number of bathrooms') ?> : <strong><?php echo $property['number_of_bathrooms'] ?></strong> <br/>
            </p>
        </div>

        <div class="clr">&nbsp;</div>
        <div class="item_desc">
            <p>
                <?php $description = empty($property['long_description_'.$this->session->userdata('language')])
                    ? $property['long_description_'.Language::EN]
                    : $property['long_description_'.$this->session->userdata('language')] ?>
                <?php echo $description ?>
            </p>
        </div>

        <br/><br/>

        <div id="location_desc" style="<?php echo (!empty($disableLeftModule))? '' : ''?>">
            <b><?php echo lang('Location description') ?></b><br/><br/>
            <?php 
            if (!empty($property['island_id']) && !empty($property['island_description'])) :
                echo mb_convert_encoding($property['island_description'], 'HTML-ENTITIES');
            elseif (!empty($property['city_id']) && !empty($property['city_description'])) :
                echo mb_convert_encoding($property['city_description'], 'HTML-ENTITIES');
            elseif(!empty($property['location_id']) && !empty($property['location_description'])):
                echo mb_convert_encoding($property['location_description'], 'HTML-ENTITIES');
            else :
                echo '';
            endif ?>
            <br/><br/>
            <?php // if (!empty($property['island_id'])) :
               // $link = $property['island_link_place'];
           // else
                if (!empty($property['city_id'])) :
                $link = $property['city_link_place'];
                elseif (!empty($property['location_link_place'])) :
                    $link = $property['location_link_place'];
            else :
                $link = '';
            endif;
            ?>
            <a style="text-decoration: underline;" rel="nofollow" title="<?php echo lang('More') ?>" href="<?php echo prep_url($link); ?>" target="_blank">
                <?php echo mb_convert_encoding(lang('Click for more'), 'HTML-ENTITIES') ?>
            </a><br/><br/>
        </div>
        
        <div id="property_form" style="<?php echo (!empty($disableLeftModule))? '' : ''?>">
            <form action='<?php echo site_url('send_main_to_property_admin/'.$this->session->userdata('language')) ?>' method="post" id="send_email_form">

                <fieldset style="border-radius: 5px;">
                    <legend><b><?php echo lang('This property interests you?') ?><br/> <?php echo lang('Leave your message') ?></b></legend>
                    <p>* <?php echo lang('Required fields') ?></p>
                    <p id="formResponse" style="color: green"></p>
                    <div class="clear">
                        <label for="name">*<?php echo mb_convert_encoding(lang('Your Name'), 'HTML-ENTITIES') ?></label>
                        <div>
                            <input name="name" id="name" value="" size="32" type="text"/>
                        </div>
                    </div>

                    <div class="clear">
                        <label for="email">*<?php echo mb_convert_encoding(lang('Your Email'), 'HTML-ENTITIES') ?></label>
                        <div>
                            <input name="email" id="email" value="" size="32" type="text"/>
                        </div>
                    </div>

                    <div class="clear">
                        <label for="phone">*<?php echo mb_convert_encoding(lang('Your Phone'), 'HTML-ENTITIES') ?></label>
                        <div>
                            <input name="phone" id="phone" value="" size="32" type="text"/>
                        </div>
                    </div>

                    <div class="clear">
                        <label for="subject"><?php echo lang('Subject') ?></label>
                        <div>
                        <input name="subject" id="subject" type="text" value="<?php echo lang('Ref').': '.$property['reference_no'] ?>" size="32" readonly="readonly" />
                        </div>
                    </div>

                    <div class="clear">
                        <label for="message">*<?php echo lang('Message') ?> :</label><br/>
                        <textarea name="message" id="message" rows="8" cols="33"></textarea>
                    </div>

                    <input type="hidden" name="propertyIds" value="<?php echo $property['property_id'] ?>" />
                    <div>
                        <input name="terms" id="terms" value="1" type="checkbox"/>
                        <?php echo mb_convert_encoding(lang('I agree to the <a href="#">Terms and conditions</a>'), 'HTML-ENTITIES') ?>?
                    </div><br/>
                    <input name="send" value="<?php echo mb_convert_encoding(lang('Send'), 'HTML-ENTITIES') ?>" type="submit" />
                    <img id='sending-img' src="<?php echo base_url('assets/images/ajax-loading.gif') ?>" alt="send" style="display: none">
                </fieldset>
            </form>
        </div>

        <?php if (!empty($similarProperties)) : ?>
        <div class="clr" style="padding-top: 10px; overflow: hidden">
            <h3><?php echo lang('Similar Properties') ?></h3>
            <hr />
            <!-- emphasis module -->
<?php if (!empty($similarProperties)) :  ?>
<ul class="bxslider" id="bxslider">
    <?php foreach($similarProperties AS $property) : ?>
        <li class="property-slide">
            <div class="mcc">
                <div class="n4" style="clear: both">
                    <a href="<?php echo site_url('property/' . (empty($property['permalink_'.$lang])? $property['permalink_en'] :urlencode($property['permalink_'.$lang])).'/'.$this->session->userdata('language')) ?>">
                        <?php if (!empty($property['island'])) : ?>
                        <?php echo lang('Island') ?> &nbsp;<?php echo $property['island'] ?>,
                        <?php elseif (!empty($property['city'])) : ?>
                        <?php echo lang('City') ?> &nbsp;<?php echo $property['city'] ?>,
                        <?php endif ?>
                        &nbsp;<?php echo lang('Croatia') .(empty($property['special_note']) ? '' : (', '.$property['special_note'])) ?>,
                        <?php $propertyTitle = empty($property['title_'.$this->session->userdata('language')])
                            ? $property['title_'.Language::EN]
                            : $property['title_'.$this->session->userdata('language')] ?>
                        <?php echo mb_convert_encoding($propertyTitle, 'HTML-ENTITIES') ?>
                    </a>
                </div>
                
                <?php
                $permlink_url= empty($property['permalink_'.$lang])? $property['permalink_en'] :$property['permalink_'.$lang];
                
                $imageUrl = empty($property['images']) ? 'assets/images/no_photo.png' : "assets/uploads/{$property['property_id']}/thumb_image/{$property['images'][0]}"; ?>
                <a href="<?php echo site_url('property/' . $permlink_url.'/'.$this->session->userdata('language')) ?>" class="clear">
				<img style="width: 140px; height: 105px;" alt="<?php echo lang('Property Image') ?>" src="<?php echo base_url($imageUrl) ?>" />
                </a>
                <span class="clear"><b><?php echo lang('Selling price') ?> :</b> <?php echo empty($property['price']) ? showMessageForEmptyPrice($this->session->userdata('language')) : number_format($property['price'],0,".",".") . mb_convert_encoding(' €', 'HTML-ENTITIES') ?></span>
                <span class="clear"><b><?php echo lang('Living space') ?> :</b> <?php echo $property['living_space'] . mb_convert_encoding('m²', 'HTML-ENTITIES')?></span>
                <span class="clear"><b><?php echo mb_convert_encoding(lang('Land space'), 'HTML-ENTITIES') ?> :</b> <?php echo empty($property['land_size']) ? 0 : $property['land_size'] . mb_convert_encoding('m²', 'HTML-ENTITIES')?></span>
                <?php if (!empty($property['advantages'])) : ?>
                <span class="clear"><b><?php echo lang('Advantages') ?> :</b> <?php echo implode(', ', $property['advantages']) ?></span>
                <?php endif ?>
                <?php if (!empty($property['is_sea_front'])) : ?>
                    <?php echo lang('First row to the sea') ?><br />
                    <?php endif ?>
            </div>
            <div class="mn">
                <a href="<?php echo site_url('property/' . (empty($property['permalink_'.$lang])? $property['permalink_en'] :$property['permalink_'.$lang]).'/'.$this->session->userdata('language')) ?>">
                    <?php echo lang('Property detail') ?>
                </a>
            </div>
        </li>
    <?php endforeach ?>
</ul>
<?php endif ?>
        </div>
        <!-- <div class="clr" style="padding-top: 10px; overflow: hidden">
            <h3><?php echo lang('Similar Properties') ?></h3>
            <hr />
            <?php foreach ($similarProperties AS $key => $singleProperty) : ?>
            <div class="property_item">
                <div class="p_image">
                    <?php 
                    // if (isset($similarProperties[$key-1])) {
                    //     $preSinglePermlink = empty($similarProperties[$key-1]['permalink_'.  strtolower($this->session->userdata('language'))])? $similarProperties[$key-1]['permalink_en'] :$similarProperties[$key-1]['permalink_'.strtolower($this->session->userdata('language'))];
                    //     echo $preSinglePermlink;
                    // }
                    // if (isset($similarProperties[$key+1])) {
                    //     $nextSinglePermlink = empty($similarProperties[$key+1]['permalink_'.  strtolower($this->session->userdata('language'))])? $similarProperties[$key+1]['permalink_en'] :$similarProperties[$key+1]['permalink_'.strtolower($this->session->userdata('language'))];
                    //     echo $nextSinglePermlink;
                    // }

                    $singlePermlink= empty($singleProperty['permalink_'.  strtolower($this->session->userdata('language'))])? $singleProperty['permalink_en'] :$singleProperty['permalink_'.strtolower($this->session->userdata('language'))];
                    // $permlink_url= empty($property['permalink_'.  strtolower($this->session->userdata('language'))])? $property['permalink_en'] :$property['permalink_'.strtolower($this->session->userdata('language'))]; ?>
                    <a class="popup" title="<?php echo lang('Property Image') ?>" href="<?php echo site_url('main/property_detail/'.$singlePermlink.'/'.$this->session->userdata('language')) ?>">
                        <?php $imageUrl = empty($singleProperty['images'][0]) ? 'assets/images/no_photo.png' : "assets/uploads/{$singleProperty['property_id']}/{$singleProperty['images'][0]}"; ?>
                        <img width="150" height="150" src="<?php echo base_url($imageUrl)?>" alt="<?php echo lang('Property Image') ?>" />
                    </a>
                </div>
                <b><?php
                // $singlePermlink= empty($singleProperty['permalink_'.  strtolower($this->session->userdata('language'))])? $singleProperty['permalink_en'] :$singleProperty['permalink_'.strtolower($this->session->userdata('language'))];
                ?>
                    <a class="popup" title="<?php echo lang('Property detail') ?>"
                       href="<?php echo site_url('main/property_detail/' . $singlePermlink.'/'.$this->session->userdata('language')) ?>">
                        <strong>
                        <?php if (!empty($singleProperty['island'])) : ?>
                        <?php echo lang('Island') ?> &nbsp;<?php echo $singleProperty['island'] ?>,
                        <?php elseif (!empty($singleProperty['city'])) : ?>
                        <?php echo lang('City') ?> &nbsp;<?php echo $singleProperty['city'] ?>,
                        <?php endif ?>
                        &nbsp;<?php echo lang('Croatia') .(empty($singleProperty['special_note']) ? '' : (', '.$singleProperty['special_note'])) ?>,

                        <?php $propertyTitle = empty($singleProperty['title_'.$this->session->userdata('language')])
                            ? $singleProperty['title_'.Language::EN]
                            : $singleProperty['title_'.$this->session->userdata('language')] ?>
                        <?php echo $propertyTitle ?>
                        </strong>

                        ( <?php echo lang('Ref') . ': ' . $singleProperty['reference_no'] ?> )
                    </a>
                </b>
                <br />
                <div class="p_info">
                    <span class="clear">
                        <?php echo lang('Selling price') ?> : <strong><?php echo empty($singleProperty['price']) ? showMessageForEmptyPrice($this->session->userdata('language')) : number_format($singleProperty['price'],0,".",".")   . ' €' ?></strong>
                    </span>
                    <span class="clear">
                        <?php echo lang('Living space') ?> : <strong><?php echo $singleProperty['living_space'] ?> m²</strong>
                    </span>
                    <span class="clear">
                        <?php echo lang('Land space') ?> : <strong><?php echo empty($singleProperty['land_size']) ? 0 : $singleProperty['land_size'] ?> m²</strong>
                    </span>
                </div>
                <div class="p_adv">
                    <strong><?php echo lang('Advantages') ?>: </strong>
                    <?php echo (empty($singleProperty['advantages']) ? null : implode(', ', $singleProperty['advantages'])) ?>
                    <?php if (!empty($property['is_sea_front'])) : ?>
                    <span class="clear">
                        <?php echo lang('First row to the sea') ?>
                    </span>
                    <?php endif ?>
                </div>
                <div class="clr"></div>
                <hr color="#cae1ff" noshade />
            </div>
            <?php endforeach ?>
        </div> -->
        <?php endif ?>
        <div class="clr">&nbsp;</div>
        <a href="javascript:window.history.back()" class="return_link">[ <?php echo lang('Back') ?> ]</a>
        <?php
        // foreach ($search_result as $key => $value) {
        //     if ($value['permalink_'.strtolower($this->session->userdata('language'))] == $this->uri->segment(3)) {
        //         $currentProp = $key;
        //     }
        // }
        // if (isset($currentProp)) {
        //     if(isset($search_result[$currentProp-1])) {
        //         $lang = strtolower($this->session->userdata('language'));
        //         $prevLink = site_url('main/property_detail/'.$search_result[$currentProp-1]['permalink_'.$lang].'/'.$this->session->userdata('language'));
        //     }
        //     if(isset($search_result[$currentProp+1])) {
        //         $lang = strtolower($this->session->userdata('language'));
        //         $nextLink = site_url('main/property_detail/'.$search_result[$currentProp+1]['permalink_'.$lang].'/'.$this->session->userdata('language'));
        //     }
        // }
        
        // if (isset($prevLink)) : ?>
            <!-- <p><a href="<?=$prevLink?>" class="pre_details">[ <?php echo lang('Previous') ?> ]</a></p> -->
        <?php //endif;
        // if (isset($nextLink)) : ?>
            <!-- <p><a href="<?=$nextLink?>" class="next_details">[ <?php echo lang('Next') ?> ]</a></p> -->
        <?php //endif; ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#add-button").on('click', function () {
            $.post('<?php echo site_url('addPropertyToList') ?>',
                { propertyId: '<?php echo $property['property_id'] ?>' }, function (response) {
                    if (response.status == 'success') {
                        window.location = '';
                    } else {
                        if (confirm('<?php echo addslashes(lang('Something went wrong! Do you want to reload?')) ?>')) {
                            window.location = '';
                        }
                    }
                }, 'json');
            return false;
        });

        $(".gallery-images").fancybox({
            openEffect: 'elastic',
            closeEffect: 'elastic',
            helpers: {
                title: {
                    type: 'inside'
                }
            }
        });
    });
</script>
<link type="text/css" href="<?php echo base_url('assets/vendor/bx-slider/jquery.bxslider.css') ?>" rel="stylesheet" media="screen" />
<link type="text/css" href="<?php echo base_url('assets/vendor/bx-slider/custom.css') ?>" rel="stylesheet" media="screen" />
<script type="text/javascript" src="<?php echo base_url('assets/vendor/bx-slider/jquery.bxslider.js') ?>"></script>
<script type="text/javascript">
    $(function(){
        $('#bxslider').bxSlider({
            auto: false,
            maxSlides: 3,
            minSlides: 2,
            slideMargin: 10,
            slideWidth: 185,
            display: 'block',
            overflow: 'hidden',
            controls: <?php echo (count($properties) > 3) ? 'true' : 'false' ?>
        });
    });
</script>

