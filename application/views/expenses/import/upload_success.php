<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Your file was successfully uploaded!</h3>

        <div class="row expanded">
            <div class="large-1 columns">
                <span>Icon: </span>
                <br/>
                <img style="width:30px;margin-top:5px;" src="../../../images/third_party/icons/110942-file-formats-icons/svg/<?php echo ltrim($user_content["file_extension"], "."); ?>-file-format-symbol.svg">
            </div>
            <div class="large-2 columns">
                <span>Name: </span>
                <br/>
                <strong><?php echo $user_content["original_name"]; ?></strong>
            </div>
            <div class="large-2 columns">
                <span>Description: </span>
                <br/>
                <?php echo (empty($user_content["description"])) ? "&nbsp;" : $user_content["description"]; ?>
            </div>
            <div class="large-1 columns">
                <span>Created: </span>
                <br/>
                <?php echo $user_content["created_on"]; ?>
            </div>
            <div class="large-1 columns">
                <span>File Size: </span>
                <br/>
                <?php
                if ($user_content["filezise"] < 1024) {
                    echo $user_content["filezise"] . " KB";
                } elseif ($user_content["filezise"] > 1024 && $user_content["filezise"] < ( 1024 * 1024 )) {
                    echo round($user_content["filezise"] / 1024, 2) . " MB";
                }
                ?>
            </div>
            <div class="large-6 columns">
                &nbsp;
            </div>
        </div>

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
                Expense/Income Type
            </th>
            <th>
                Payment Method / Asset
            </th>
            <th>
                Description
            </th>
            <th>
                Location / Source
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
                        <tr id="row_<?php echo $k; ?>" >
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
                            <td class="import_expense" ><input type="hidden" name="amount[]" id="amount[]" value="<?php echo $v["amount"]; ?>" /><?php echo $v["amount"]; ?></td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr id="row_<?php echo $k; ?>" style="margin-top: 20px;margin-bottom: 20px;">
                            <td><span id="remove-row" onClick="removeTabRow(<?php echo $k; ?>)">Remove</span></td>
                            <td>
                                <input type="hidden" name="createDate[]" id="createDate[]" value="<?php echo date('Y/m/d H:i', strtotime($v["date"])); ?>" />
                                <?php echo date('Y/m/d H:i', strtotime($v["date"])); ?>
                            </td>
                            <td><?php echo $incomeTypeSelect; ?></td>
                            <td><?php echo $incomeAssetSelect; ?></td>
                            <td>
                                <textarea row="1" name="description[]" ><?php echo (!empty($v["description"])) ? $v["description"] : ""; ?>
                                </textarea>
                            </td>
                                                      <td>
                                <input  type="text" id="location[]" name="location[]" placeholder="Where was the expense made?"/>
                                <input  type="hidden" id="locationId[]" name="locationId[]" value="0"/><br/><br/>
                            </td>
                            <td class="import_income" >
                                <input type="hidden" name="amount[]" id="amount[]" value="<?php echo $v["amount"]; ?>" /><?php echo $v["amount"]; ?>
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