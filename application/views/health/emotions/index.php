<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Emotions</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/emotions/capture" method="POST">
            <h3>How are you feeling.</h3>
            <div class="emotionIconRow">
            <?php 
                foreach($emotionIcons as $k=>$v){
                    echo "<span class='emoticonBox' >"
                    . "<a src='#' "
                        . "id='".$v["id"]."' "
                        . "onClick='recordEmotion(".$v["id"].");'"
                        . "onmouseover='emotionNameShow(\"".$v["name"]."\");'"    
                        . ">"
                        . "<img src='/images/third_party/icons/".$v["icon"]."' "
                            . "class='emotionIcon' style='color:".$v["colour"].";' "
                            . "alt='".$v["name"]."' "
                            . "title='".$v["name"]."' "
                            . "ALIGN='top' /><br/><span class='emoticonText'>".$v["name"]."</span>"
                    . "</a></span>";
                }
            ?>
            </div>
        </form>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <div class="large-4 columns" >

        </div>
        <div class="large-8 columns" >
            <h2 id="emotion-name">
                
            </h2>
        </div>
    </div>
</div>
<hr/>
<div class="row expanded">
    <?php echo form_open('/health/emotion/tracker') ?>
    <div class="large-4 columns" >
        <label>
            From<input type="text" name="fromDate" id="fromDate" value="<?php echo $startDate; ?>"/>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            To<input type="text" name="toDate" id="toDate" value="<?php echo $endDate; ?>"/> 
        </label>
    </div>
    <div class="large-4 columns" style="vertical-align: central;margin-top:15px;" >
        <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
    </div>
    <?php echo form_close(); ?>
</div>
<?php 
//    echo "<pre>";
//    print_r($emotions);
//    echo "</pre>";
    foreach($emotions as $k=>$v){
        ?>
        <div class="row expanded" >
            <div class="large-3 columns" >
                <?php echo date_format(date_create($v["created_date"]), "l, d F Y @ H:i")?>
            </div>
            <div class="large-1 columns" >
                <img 
                    src='/images/third_party/icons/<?php echo $emotionIcons[$v["emotion_id"]]["icon"] ?>' 
                    class='emotionIcon' style='color:<?php echo $emotionIcons[$v["emotion_id"]]["color"]; ?>;' 
                    alt='<?php echo $emotionIcons[$v["emotion_id"]]["name"]; ?>' 
                    title='<?php echo $emotionIcons[$v["emotion_id"]]["name"]; ?>' />
            </div>
            <div class="large-1 columns" >
                <?php echo $emotionIcons[$v["emotion_id"]]["name"]; ?>
            </div>
            <div class="large-3 columns" >
                 <span 
                     class="editable"
                         data-url="/health/emotion/tracker/description/<?php echo $v["id"]; ?>"
                         data-type="textarea"
                         data-ok-button="OK"
                         data-cancel-button="Cancel" >
                             <?php echo (!empty($v["description"])) ? $v["description"] : ""; ?>
                     </span>
            </div>
            <div class="large-3 columns" >
                Action
            </div>
        </div>
<?php 
    }
?>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/jinplace-1.2.1.min.js"></script>
<script src="/js/health/emotions/index.js" ></script>
