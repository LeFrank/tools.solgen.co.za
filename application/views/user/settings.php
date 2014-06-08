<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="setting-feedback" class="hidden"></div>
<h3>Settings</h3>
<img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
<h4><a href="/user/email/password" >Change Email Account</a></h4>
<h4><a href="/user/email/password" >Change Password</a></h4>
<h4><a href="/user/location/manage">User Locations</a></h4>
<h4><a href="#"><span id="delete-account" >Delete account</span></a></h4>
<h4>Email Subscription Status : 
    <input type="checkbox" value="1" name="unsubscribe" id="unsubscribe" <?php echo (($user->subscribed == 1)?"checked":"");?> />
    <span id="email-subscribed-status"><?php echo (($user->subscribed == 1)?"Subscribed":"Unsubscribed");?></span> 
</h4>
<script type="text/javascript" src="/js/user/settings.js" ></script>
<script type="text/javascript">
    var user_id = <?php echo $user->id;?>;
</script>