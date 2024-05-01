<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Manager Personalized Income Assets</h3>
        <div>
            <p>My Income Assets</p>
            <?php
            if (!empty($incomeAssets)) {
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
                        <?php foreach ($incomeAssets as $k => $v) { ?>
                            <tr>    
                                <td><?php echo $v["description"]; ?></td>
                                <td><?php echo $v["enabled"]; ?></td>
                                <td><?php echo $v["create_date"]; ?></td>
                                <td><?php echo $v["update_date"]; ?></td>
                                <td>
                                    <a href="/income-assets/edit/<?php echo $v["id"]; ?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <a href="/income-assets/delete/<?php echo $v["id"]; ?>" onclick="return confirm_delete()">delete</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No personlized income assets exist.</p>";
            }
            ?>
        </div>

        <div id="manage-income=asset-form">
            <h3>Create Income Assets</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('income-assets/capture') ?>

            <label for="description">Description *</label>
            <input type="text" name="description" /><br />

            <label for="enabled">Enabled</label>
            <select name="enabled">
                <option value="true">True</option>
                <option value="false">False</option>';
            </select><br /><br />
            <input type="submit" name="submit" value="Create Income Assets" class="button"/>
            </form>
        </div>
    </div></div>