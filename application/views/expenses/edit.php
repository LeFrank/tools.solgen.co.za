<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="captureExpenses">
            <h3>Capture Expense</h3>
            <?php echo validation_errors(); ?>
            <?php echo form_open_multipart('expenses/update') ?>
            <input type="hidden" name="id" value="<?php echo $expense->id; ?>"
                   <label for="amount">Amount *</label>
            <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" value="<?php echo $expense->amount; ?>"/><br />

            <label for="expenseType">Expense Type</label>
            <select name="expenseType" id="expenseType">
                <?php
                foreach ($expenseTypes as $k => $v) {
                    echo '<option value="' . $v["id"] . '" ' . (($expense->expense_type_id == $v["id"]) ? "selected" : "" ) . '>' . $v["description"] . '</option>';
                }
                ?>
            </select><br />

            <label for="paymentMethod">Payment Method</label>
            <select name="paymentMethod">
                <?php
                foreach ($expensePaymentMethod as $k => $v) {
                    echo '<option value="' . $v["id"] . '"  '
                    . (($expense->payment_method_id == $v["id"]) ? 'selected' : '')
                    . '>' . $v["description"] . '</option>';
                }
                ?>
            </select><br />

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="40" rows="5" ><?php echo $expense->description; ?></textarea><br/><br/>

            <label for="location">Location</label>
            <input  type="text" id="location" name="location" value="<?php echo $expense->location; ?>"/><br/><br/>
            <input  type="hidden" id="locationId" name="locationId" value="<?php echo (null == $expense->location_id )? 0 : $expense->location_id ; ?>"/><br/><br/>

            <label for="expenseDate">Expense Date</label>
            <input  type="text" id="expenseDate" name="expenseDate" value="<?php echo $expense->expense_date; ?>" /><br/><br/>
            <br/>
            <?php 
                if(!empty($expense_resources)){
                    // print_r($expense_resources);
                    echo "Has a resource associated with this expense.";
                    foreach ($expense_resources as $k => $v) {
                        ?>
                        <div class="row expanded">
                            <div class="large-1 columns">
                                <img style="width:30px;margin-top:5px;" src="../../../images/third_party/icons/110942-file-formats-icons/svg/<?php echo ltrim($v["file_extension"], "."); ?>-file-format-symbol.svg">
                            </div>
                            <div class="large-2 columns">
                                <strong><?php echo $v["original_name"]; ?></strong>
                            </div>
                            <div class="large-3 columns">
                                <?php echo (empty($v["description"])) ? "&nbsp;" : $v["description"]; ?>
                            </div>
                            <div class="large-2 columns">
                                <?php echo $v["created_on"]; ?>
                            </div>
                            <div class="large-1 columns">
                                <?php
                                if ($v["filezise"] < 1024) {
                                    echo $v["filezise"] . " KB";
                                } elseif ($v["filezise"] > 1024 && $v["filezise"] < ( 1024 * 1024 )) {
                                    echo round($v["filezise"] / 1024, 2) . " MB";
                                }
                                ?>
                            </div>
                            <div class="large-1 columns">
                                <?php echo $tools[$v["tool_id"]]["name"]; ?>
                            </div>
                            <div class="large-2 columns">
                                <a href="/resource/delete/<?php echo $v["id"]; ?>" onclick="return confirm_delete()">Delete</a>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <a target="_blank" href="/resource/view/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">View</a>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="/resource/download/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">Download</a>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <a href="#/<?php echo $v["id"]; ?>">Re-Process</a>
                
                            </div>
                        </div>
            <?php
                    }
                }else{
                    ?>
                    <div class="row expanded">
                        <div class="large-12 columns">
                            <input name="userfile" id="userfile" type="file" />
                        </div>
                    </div>
                    <?php
                }
            ?>
            <br/>
            <br/>
            <span>* Required Field</span><br/><br/>

            <input type="submit" name="submit" value="Record" class="button"/> <a href="/expenses" class="button secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>'
<script src="/js/location/autocomplete.js"></script>
<script type="text/javascript">
    $(function() {
        $("#expenseDate").datetimepicker();
        CKEDITOR.replace('description');
        $("#expenseType").change(function () {
            $.post(
                    "/expense-types/type/" + $(this).val(),
                    null
            ).done(function (resp) {
                obj =  JSON.parse(resp);
                if(null != obj.template && obj.template != "" ){
                    CKEDITOR.instances.description.setData(CKEDITOR.instances.description.getData() + obj.template);
                }
            });
        });
    });
</script>