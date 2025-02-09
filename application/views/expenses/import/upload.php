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
        <br/>
        <h1>Choose Expense Defaults</h1>
        <br/>
        <div class="row expanded">
            <div class="large-6 columns">
                <?php echo $expenseTypeSelect; ?>
            </div>
            <div class="large-6 columns">
                <?php echo $paymentMethodSelect; ?>
            </div>
        </div>
        <h1>Choose Income Defaults</h1>
        <br/>
        <div class="row expanded">
            <div class="large-6 columns">
                <?php echo $incomeTypeSelect; ?>
            </div>
            <div class="large-6 columns">
                <?php echo $incomeAssetSelect; ?>
            </div>
        </div>
        <br/>
        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />
        </form>
    </div>
</div>