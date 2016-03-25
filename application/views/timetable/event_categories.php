<?php ?>
<h3>Personalized Event Categories</h3>
<div>
    <p>My Event Categories</p>
    <?php
    if (!empty($eventCategories)) {
        ?>
        <table>
            <thead>
            <th>Name</th>
            <th>Description</th>
            <th>Create Date</th>
            <th>Last Updated</th>
            <th>Enabled</th>
            <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($eventCategories as $k => $v) { ?>
                    <tr>    
                        <td><?php echo $v["name"]; ?></td>
                        <td><?php echo $v["description"]; ?></td>
                        <td><?php echo $v["create_date"]; ?></td>
                        <td><?php echo $v["update_date"]; ?></td>
                        <td><?php echo $v["enabled"]; ?></td>
                        <td>
                            <a href="/event-category/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/event-category/delete/<?php echo $v["id"];?>">delete</a></td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
        <?php
    }else{
        echo "<p>No personlized event categories exist.</p>";
    }
    ?>
</div>

<div id="manage-event-category-form">
    <h3>Create Event Category</h3>
    <?php echo validation_errors(); ?>

    <?php echo form_open('event-category/capture') ?>

    <label for="name">Name *</label>
    <input type="text" name="name" autofocus /><br />
    
    <label for="description">Description *</label>
    <textarea name="description" id="description" cols="20" rows="8" ></textarea><br />

    <label for="enabled">Enabled</label>
    <select name="enabled">
        <option value="true">True</option>
        <option value="false">False</option>';
    </select>
    <br/>
    <br/>
    <input type="submit" name="submit" value="Create Event Category" class="button"/>
</form>
</div>