<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Your file was successfully uploaded!</h3>

        <ul>
            <?php foreach ($user_content as $item => $value): ?>
                <li><?php echo $item; ?>: <?php echo $value; ?></li>
            <?php endforeach; ?>
        </ul>

        <p><?php echo anchor('upload', 'Upload Another File!'); ?></p>
        <?php
        if ($this->session->flashdata("success") !== FALSE) {
            echo $this->session->flashdata("success");
        }
        ?>
        <?php echo validation_errors(); ?>
        <?php echo form_open('expenses/import/capture') ?>
        <table id="importExpenses" class="tablesorter responsive expanded widget-zebra">
            <thead>
            <th>
                Ignore
            </th>
            <th>
                Date
            </th>
            <th>
                Expense Type
            </th>
            <th>
                Payment Method
            </th>
            <th>
                Description
            </th>
            <th>
                Location
            </th>
            <th>
                Amount
            </th>
            </thead>
            <tbody>
                <?php
                foreach ($expenses as $k => $v) {
                    if ($v["amount"] < 0) {
                        ?>
                        <tr id="row_<?php echo $k; ?>">
                            <td><span id="remove-row" onClick="removeTabRow(<?php echo $k; ?>)">Remove</span></td>
                            <td>
                                <input type="hidden" name="createDate[]" id="createDate[]" value="<?php echo date('Y/m/d H:i', strtotime($v["date"])); ?>" />
                                <?php echo date('Y/m/d H:i', strtotime($v["date"])); ?>
                            </td>
                            <td><?php echo $expenseTypeSelect; ?></td>
                            <td><?php echo $paymentMethodSelect; ?></td>
                            <td><textarea row="1" name="description[]" ><?php echo (!empty($v["description"])) ? $v["description"] : ""; ?>
                                </textarea>
                            </td>
                            <td>
                                <input  type="text" id="location[]" name="location[]" placeholder="Where was the expense made?"/>
                                <input  type="hidden" id="locationId[]" name="locationId[]" value="0"/><br/><br/>
                            </td>
                            <td><input type="hidden" name="amount[]" id="amount[]" value="<?php echo $v["amount"]; ?>" /><?php echo $v["amount"]; ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr id="row_<?php echo $k; ?>" style="margin-top: 20px;margin-bottom: 20px;">
                            <td>&nbsp;</td>
                            <td>
                                <?php echo date('Y/m/d H:i', strtotime($v["date"])); ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <?php echo (!empty($v["description"])) ? $v["description"] : ""; ?>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                <?php echo $v["amount"]; ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <span>* Required Field</span><br/><br/>
        <input type="submit" name="submit" value="Record" class="button"/>
        </form>
    </div>
</div>
<script type="text/javascript" src="/js/expenses/import/upload_success.js" ></script>