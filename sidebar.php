<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="side.css">
    <title>Document</title>
</head>

<body>
    <label class="sidebar">
    <input class="input_tag" type="checkbox">
    <div class="toggle">
        <span class="top_line common"></span>
        <span class="mid_line common"></span>
        <span class="bottom_line common"></span>
    </div>

        <div class="slide">
            <h1>MENU</h1>
            <ul>
                <li><a href=""><i class="fa fa-tv"></i> dashboard</a></li>
                <li id="show-login"><a><i class="fa fa-upload"></i> Upload</a></li>
                <li id="all-songs-list"><a><i class="fa fa-tv"></i> Song List</a></li>
                <li><a href=""><i class="fa fa-tv"></i> dashboard</a></li>
            </ul>
        </div>
        </label>
    <?php
    include("uplaod.php");
    ?>
</body>

</html>