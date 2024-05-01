<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="captureIncomes">
            <h3>Capture Incomes</h3>
            <?php echo validation_errors(); ?>
            <?php echo form_open_multipart('income/update') ?>
            <input type="hidden" name="id" value="<?php echo $income->id; ?>"
                   <label for="amount">Amount *</label>
            <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" value="<?php echo $income->amount; ?>"/><br />

            <label for="incomeType">Incomes Type</label>
            <select name="incomeType" id="incomeType">
                <?php
                foreach ($incomeTypes as $k => $v) {
                    echo '<option value="' . $v["id"] . '" ' . (($income->income_type_id == $v["id"]) ? "selected" : "" ) . '>' . $v["description"] . '</option>';
                }
                ?>
            </select><br />

            <label for="incomeAsset">Income Asset</label>
            <select name="incomeAsset">
                <?php
                foreach ($incomeAssets as $k => $v) {
                    echo '<option value="' . $v["id"] . '"  '
                    . (($income->income_asset_id == $v["id"]) ? 'selected' : '')
                    . '>' . $v["description"] . '</option>';
                }
                ?>
            </select><br />

            <label for="description">Description</label>
            <textarea name="description" id="description" cols="40" rows="5" ><?php echo $income->description; ?></textarea><br/><br/>

            <label for="source">Source</label>
            <input  type="text" id="source" name="source" value="<?php echo $income->source; ?>"/><br/><br/>

            <label for="incomeDate">Incomes Date</label>
            <input  type="text" id="incomeDate" name="incomeDate" value="<?php echo $income->income_date; ?>" /><br/><br/>
            <br/>
            <span>* Required Field</span><br/><br/>

            <input type="submit" name="submit" value="Record" class="button"/> <a href="/incomes" class="button secondary">Cancel</a>
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
        $("#incomeDate").datetimepicker();
        CKEDITOR.replace('description');
        $("#incomeType").change(function () {
            $.post(
                    "/income-types/type/" + $(this).val(),
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