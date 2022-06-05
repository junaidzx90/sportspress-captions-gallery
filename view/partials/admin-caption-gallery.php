<div id="spg_caption_gallery">
    <div class="sp_caption_gallery">
        <?php
        global $post;
        $post_author = $post->post_author;
        $captions_galleries = get_user_meta($post_author, 'gcb_caption_gallery', true );
        if(!is_array($captions_galleries)){
            $captions_galleries = [];
        }

        echo '<input type="hidden" id="caption_current_user_id" value="'.$post_author.'">';
        if(sizeof($captions_galleries) > 0){
            foreach($captions_galleries as $key => $caption_gallery){
                ?>
                <div class="item">
                    <div class="img" style="background-image: url(<?php echo $caption_gallery['image'] ?>);">
                        <div class="action_buttons">
                            <span data-key= "<?php echo $key ?>" class="delete_spg_caption_gallery_item"></span>
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
</div>