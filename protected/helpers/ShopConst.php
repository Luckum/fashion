<?php
class ShopConst
{
    const SORT = 'sort';
    const SORT_DATE = 'date_added';
    const SORT_DATE_DESC = 't.added_date DESC';
    const SORT_PRICE_FROM_LOW = 'asc';
    const SORT_PRICE_ASC = 't.price ASC';
    const SORT_PRICE_FROM_HIGH = 'desc';
    const SORT_PRICE_DESC = 't.price DESC';
    const SORT_OUR_SELECTION = 't.our_selection DESC, t.added_date DESC';
    const SORT_SALE = 'sale';
    const SORT_SALE_CONDITION = 't.price != t.init_price';
    const PAGE_SIZE = 'pageSize';
    const PAGE_SIZE_ALL = 'all';
    const PAGE = 'page';
    const IMAGE_MAX_DIR = '/images/upload/';
    const IMAGE_MEDIUM_DIR = '/images/upload/medium/';
    const IMAGE_THUMBNAIL_DIR = '/images/upload/thumbnail/';
    const HOME_BLOCK_IMAGE_MAX_DIR = '/images/upload/blocks/';
    const HOME_BLOCK_IMAGE_MEDIUM_DIR = '/images/upload/blocks/medium/';
    const HOME_BLOCK_IMAGE_THUMBNAIL_DIR = '/images/upload/blocks/thumbnail/';
    const BLOG_IMAGE_MAX_DIR = '/images/blog/';
    const BLOG_IMAGE_MEDIUM_DIR = '/images/blog/medium/';
    const BLOG_IMAGE_THUMBNAIL_DIR = '/images/blog/thumbnail/';
}
