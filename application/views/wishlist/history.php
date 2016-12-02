<div class="row">
    <div class="large-3 columns" >
        <div class="row">
            <div class="large-12 columns" >
                <div id="WishlistFilter" class="WishlistFilter">
                    <h3>Filter Wishlist</h3>
                    <div id="validation_errors" ></div>
                    <form accept-charset="utf-8" method="post" action="/expense-wishlist/export" id="filterWishlistForm" >
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Filter by Period
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <select id="expensePeriod" name="expensePeriod">
                                    <option value="0">Current Month</option>
                                    <?php
                                    foreach ($expensePeriods as $k => $v) {
                                        echo "<option value='" . $v["id"] . "'>" . $v["name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Date From
                                    <input type="text" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforYear[0]; ?>"/>
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Date To<input type="text" name="toDate" id="toDate" value="<?php echo $startAndEndDateforYear[1]; ?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label>Amount From
                                    <input type="text" name="fromAmount" id="fromAmount" value="0" />
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>To
                                    <input type="text" name="toAmount" id="toAmount" value="0" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Keywords
                                    <input type="text" name="keyword" id="keyword" value="" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Statuses</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="row">
                                    <div class="large-6 columns">
                                        <input type="checkbox" checked="checked" value="all" name="statuses[]" />
                                        <label>all</label>
                                    </div>
                                    <?php
                                    $count = 1;
                                    $breakCount = 2;
                                    foreach ($statuses as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $k . "' name='statuses[]' /><label>" . $v . "</label></div>";
                                        $count++;
                                        if ($count % $breakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                Priorities
                                <div class="row">
                                    <div class="large-6 columns">                        
                                        <input type="checkbox" checked="checked" value="all" name="priorities[]" /><label>all</label>
                                    </div>
                                    <?php
                                    $pmCount = 1;
                                    $bpmBeakCount = 2;
                                    foreach ($priorities as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $k . "' name='priorities[]' /><label>" . $v . "</label></div>";
                                        $pmCount++;
                                        if ($pmCount % $bpmBeakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                <input type="button" name="export" value="Export To CSV" id="export" class="button secondary" onClick="submit()"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="large-9 columns">
        <h2>Wishlist Items</h2>
        <div id="latestItems">
            <?php echo $itemsTable;?>
        </div>
        <br/>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/wishlist/history.js" ></script>