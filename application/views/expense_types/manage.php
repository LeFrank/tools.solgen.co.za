<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
<div id="expense-type-manage-feedback" class="hidden"></div>
<h3>Manager Personalized Expense Types</h3>
<div>
    <p>My Expense Types</p>
    <?php
    if (!empty($expenseTypes)) {
        ?>
        <table>
            <thead>
            <th>Description</th>
            <th>Enabled</th>
            <th>Create Date</th>
            <th>Last Updated</th>
            <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($expenseTypes as $k => $v) { ?>
                    <tr>    
                        <td><?php echo $v["description"]; ?></td>
                        <td><?php echo $v["enabled"]; ?></td>
                        <td><?php echo $v["create_date"]; ?></td>
                        <td><?php echo $v["update_date"]; ?></td>
                        <td>
                            <a href="/expense-types/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/expense-types/delete/<?php echo $v["id"];?>">delete</a></td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
        <?php
    }else{
        echo "<p>No personlized expense types exist.</p>";
    }
    ?>
</div>

<div id="manage-expense-type-form">
    <h3>Create Expense Type</h3>
    <?php echo validation_errors(); ?>

    <?php echo form_open('expense-types/capture') ?>

    <label for="description">Description *</label>
    <input type="text" name="description" /><br />

    <label for="enabled">Expense Type</label>
    <select name="enabled">
        <option value="true">True</option>
        <option value="false">False</option>';
    </select><br /><br />
    <input type="submit" name="submit" value="Create Expense Type" class="button"/>
</form>
</div>
    </div>
</div>
