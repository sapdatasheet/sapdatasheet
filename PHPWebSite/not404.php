<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>This is not an 404 Page</title>
    </head>
    <body>
        <h1>This is NOT an 404 Page</h1>
        <?php
        $args = func_get_args();
        foreach ($args as $value) {  ?>
            <?php echo $value ?> <br />
        <?php } ?>
    </body>
</html>
