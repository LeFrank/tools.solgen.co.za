<?php ?>
<section id="cd-timeline" class="cd-container">
    <?php 
        foreach($events as $k=>$v){
            echo '<div class="cd-timeline-block">';
            echo '  <div class="cd-timeline-img '. $v->toolName .'">';
            echo '      <img src="images/third_party/codyhouse/vertical-timeline/cd-icon-picture.svg" alt="Picture">';
            echo '  </div>';
            echo '  <div class="cd-timeline-content">';
            echo '      <h2>'. $v->title. '</h2>';
//            if($v->toolId == "7"){
                echo '      <div id="body_content_'.$v->toolId.$v->id.'" class="note_body notes_body_clamp">'. $v->body. '</div>';
//            }else{
//                echo '      <div>'. $v->body. '</div>';
//            }
            echo '      <br/><br/><a href="'. $v->url .'" target="_blank" class="cd-read-more thickbox">Read more</a>';
//            if($v->toolId == "7"){
            echo '      &nbsp;&nbsp;<div id="showMoreDiv" class="show-content button tiny secondary" data-note-id="'.$v->toolId.$v->id.'">Show More</div>';
//            }
            echo '      <span class="cd-date">'. $v->date .'</span>';
            echo '  </div>';
            echo '</div>';
        } ?>
</section>
<script type="text/javascript" src="/js/third_party/codyhouse/vertical-timeline/main.js" ></script>
<script type="text/javascript">
    $(".show-content").click(function () {
        var note_id = $(this).attr("data-note-id");
        if ($("#body_content_" + note_id).hasClass("notes_body_clamp")) {
            $("#body_content_" + note_id).removeClass("notes_body_clamp").animate(8000);
            $(this).html("Show less");
        } else {
            $("#body_content_" + note_id).addClass("notes_body_clamp").animate(8000);
            $(this).html("Show More");
        }
    });
</script>