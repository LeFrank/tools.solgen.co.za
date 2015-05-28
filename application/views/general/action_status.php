<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="large-12 columns">
        <div data-alert="" class="alert-box radius <?php echo $action_classes; ?>">
            <h3>Status : <?php echo $status; ?></h3>
            <span class="user-action inline-block <?php echo $action_classes; ?>" ><?php echo $action_description; ?></span>
            <p class="user-message <?php echo $message_classes; ?>" ><?php echo $message; ?></span>
                <a href="<?php echo (isset($reUrl))? $reUrl: ""; ?>" class="close">×</a>
        </div>
    </div>
</div>