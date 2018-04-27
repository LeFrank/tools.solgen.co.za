<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Import Expenses</h2>
        <p>
            Please check to ensure that the import file has at a minimum for following three columns:
            <ul>
                <li>Date</li>
                <li>Description</li>
                <li>Amount</li>
            </ul>
        </p>
        <?php echo $error; ?>
        <?php echo form_open_multipart('expenses/import/do_upload'); ?>
        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />
        </form>
    </div>
</div>