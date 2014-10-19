<?php 
	
	
?>

<div id="notesContent" class="notesContent" >
    <h2>Note Overview</h2>

    <div id="latestNotes">
    	<h3>Five Latest Notes</h3>
        <?php if (is_array($notes) && !empty($notes)) {
            ?>
            <table>
                <thead>
                <th>Date</th>
                <th>heading</th>
  				<th>body</th>
  				<th>tagg</th>
  				<th>action</th>
                </thead>
                <tbody>
                    <?php
                    $total = 0.0;
                    foreach ($notes as $k => $v) {
                        echo "<tr>";
                        echo "<td>".$v["create_date"];
                        if(!empty($v["update_date"])){
                            echo "<br/><span class=\"update_date\">Last edited:<br/>".$v["update_date"]."<br/>No. of updates: ".$v["update_count"]."</span>";
                        }
                        echo "</td>";
                        echo "<td>".$v["heading"]."</div></td>";
                        echo "<td>".$v["body"]."</td>";
                        echo "<td>".$v["tagg"]."</td>";
                        echo "<td><a href=\"/notes/edit/".$v["id"]."\" >edit</a>"
                                . " | <a href=\"/notes/delete/".$v["id"]."\" >delete</a>"
                                . "</td>";
                        echo "</tr>";
                    }
                    ?>
            	</tbody>
            </table>
            <?php
        } else {
            echo "No expenses captured.";
        }
        ?>
    </div>
    <br/><br/>
    <div id="captureNote" >
        <h3>Capture Note</h3>
        <?php echo $capture_form;?>
    </div>
</div>
<script type="text/javascript" src="/js/notes/index.js" ></script>