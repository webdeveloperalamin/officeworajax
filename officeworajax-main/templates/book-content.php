<?php
    $lemonbook_category = get_the_terms( get_the_ID(), 'book-category');
				
    if( $lemonbook_category && ! is_wp_error( $lemonbook_category )){					
        $lemonbook_category_list = array();
        foreach( $lemonbook_category as $single_book_category ){
            $lemonbook_category_list[] = $single_book_category->slug;
        }
        $lemonbook_assigned_category = join(' ', $lemonbook_category_list);
    }else{
        $lemonbook_assigned_category = '';
    }
?>

<div class="single-book-list <?php echo $lemonbook_assigned_category; ?>">
    <div class="single-book-box">
        <div class="book-box-bg" style="background-image: url(<?php echo esc_url(get_the_post_thumbnail_url( get_the_ID(), 'full' ));?>)"></div>
        
        <div class="book-box-content"><div class="book-box-content-inner">
            <h3><?php echo esc_html(get_the_title()); ?></h3>
            <p><?php echo esc_html(wp_trim_words( get_the_content(), 15, "" )); ?></p>
            <a class="readmore-btn" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html("Read More"); ?></a>
        </div>
    </div>
</div>