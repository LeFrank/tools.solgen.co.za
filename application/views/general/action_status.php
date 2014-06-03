<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div>
    <h3>Status : <?php echo $status; ?></h3>
    <span class="user-action inline-block<?php echo $action_classes; ?>" ><?php echo $action_description;?></span>
    <p class="user-message <?php echo $message_classes; ?>" ><?php echo $message;?></span>
</div>