<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Gallery
 * @subpackage Gallery/admin/partials
 */
?>

<div class="sp_caption_gallery">
<?php
    $post_author = get_post()->post_author;
    $captions_galleries = get_user_meta($post_author, 'gcb_caption_gallery', true );
    if(!is_array($captions_galleries)){
        $captions_galleries = [];
    }

    if(sizeof($captions_galleries) > 0){
        foreach($captions_galleries as $caption_gallery){
            ?>
            <div class="item public">
              <div class="img" style="background-image: url(<?php echo $caption_gallery['image'] ?>);">
                <div class="action_buttons">
                  <a class="imageview" data-fancybox="captions-<?php echo $post_author ?>" data-caption="<?php echo $caption_gallery['caption'] ?>" href="<?php echo $caption_gallery['image'] ?>"></a>
                </div>
                <p><?php echo $caption_gallery['caption'] ?></p>
              </div>
            </div>
            <?php
        }
    }else{
      echo "No gallery item found!";
    }
?>
</div>