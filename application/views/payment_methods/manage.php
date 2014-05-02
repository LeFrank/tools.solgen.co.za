<?php ?>
<h3>Manager Personalized Payment Methods</h3>
<div>
    <p>My Payment Methods</p>
    <?php
    if (!empty($paymentMethods)) {
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
                <?php foreach ($paymentMethods as $k => $v) { ?>
                    <tr>    
                        <td><?php echo $v["description"]; ?></td>
                        <td><?php echo $v["enabled"]; ?></td>
                        <td><?php echo $v["create_date"]; ?></td>
                        <td><?php echo $v["update_date"]; ?></td>
                        <td>
                            <a href="/payment-methods/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/payment-methods/delete/<?php echo $v["id"];?>">delete</a></td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
        <?php
    }else{
        echo "<p>No personlized payment methods exist.</p>";
    }
    ?>
</div>

<div id="manage-payment-type-form">
    <h3>Create Payment Method</h3>
    <?php echo validation_errors(); ?>

    <?php echo form_open('payment-methods/capture') ?>

    <label for="description">Description *</label>
    <input type="text" name="description" /><br />

    <label for="enabled">Enabled</label>
    <select name="enabled">
        <option value="true">True</option>
        <option value="false">False</option>';
    </select><br />
    <input type="submit" name="submit" value="Create Payment Method" />
</form>
</div>
