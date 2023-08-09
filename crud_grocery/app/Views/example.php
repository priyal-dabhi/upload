<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://d328ce9sgcu5lp.cloudfront.net/assets/themes/default/images/favicon.png" type="image/x-icon" />



    <?php
    foreach ($css_files as $file) : ?>
        <link type=" text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <style>
        .select li {
            display: none;
            cursor: pointer;
            padding: 5px 10px;
            border-top: 1px solid black;
            min-width: 150px;
        }

        .select li:first-child {
            display: block;
            border-top: 0px;
        }

        .select {
            border: 1px solid black;
            display: inline-block;
            padding: 0;
            border-radius: 4px;
            position: relative;
        }

        .select li:hover {
            background-color: #ddd;
        }

        .select li:first-child:hover {
            background-color: transparent;
        }

        .select.open li {
            display: block;
        }

        .select span:before {
            position: absolute;
            top: 5px;
            right: 15px;
            content: "\2193";
        }

        .select.open span:before {
            content: "\2191";
        }
    </style>
</head>


<body>

    <div style='height:20px;'></div>
    <ul class="select">
        <li><a href="<?php echo base_url('change'); ?>/1">English</a></li>
        <li><a href="<?php echo base_url('change'); ?>/2">chience</a></li>
        <li><a href="<?php echo base_url('change'); ?>/3">Malay</a></li>
    </ul>
    <?php


    ?>
    <div style="padding: 10px">
        <div class="tDiv3">

        </div>
        <?php echo $output; ?>
    </div>
    <?php foreach ($js_files as $file) : ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script>
        $(".select").click(function() {
            var is_open = $(this).hasClass("open");
            if (is_open) {
                $(this).removeClass("open");
            } else {
                $(this).addClass("open");
            }
        });

        $(".select li").click(function() {

            var selected_value = $(this).html();
            var first_li = $(".select li:first-child").html();

            $(".select li:first-child").html(selected_value);
            $(this).html(first_li);

        });

        $(document).mouseup(function(event) {

            var target = event.target;
            var select = $(".select");

            if (!select.is(target) && select.has(target).length === 0) {
                select.removeClass("open");
            }

        });
    </script>
   
</body>

</html>