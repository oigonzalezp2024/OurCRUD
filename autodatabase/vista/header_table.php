<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="mydatabases.php">Back</a></li>
                <li><a href="mydatabase_table_id.php?id=<?php echo $id; ?>">database</a></li>
                <li><a href="mytable_id.php?id=<?php echo $id; ?>">table</a></li>
                <li><a href="field_sizes.php">configuration</a></li>
            </ul>
        </div>
    </div>
</nav>