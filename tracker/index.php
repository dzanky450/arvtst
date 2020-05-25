<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Linkedin tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.1/css/bulma.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://www.arvisual.eu/imgs/favicon.png">
</head>
<body>

<?php
require 'start.php';
header('Content-type: text/html; charset=utf-8');

$limit = 7;
$query = "SELECT * FROM tabmsg";

$s = $db->prepare($query);
$s->execute();
$total_results = $s->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}

$starting_limit = ($page-1)*$limit;


if(!isset($_GET['keyword'])) {
    $show  = "SELECT * FROM tabmsg ORDER BY company DESC LIMIT $starting_limit, $limit";
}
if(isset($_GET['keyword'])) {
    $searchword = $_GET['keyword'];
    $show = "SELECT * FROM tabmsg WHERE company LIKE '%$searchword%'";
}
if(isset($_GET['country'])) {
    $state = $_GET['country'];
    $show = "SELECT * FROM tabmsg WHERE country LIKE '%$state%'";
}
if(isset($_GET['name'])) {
    $name = $_GET['name'];
    $show = "SELECT * FROM tabmsg WHERE name LIKE '%$name%'";
}

$r = $db->prepare($show);
$r->execute(); ?>

<main class="container center">
    <div class="logoCont">
        <a href="index.php"><div class="logoAR"></div></a>
    </div>
    <div class="searchFlex">
        <form class="search" action="index.php?name=<?php echo $_GET['name'];?>" method="get">
            <input type="text" name="name" class="input is-primary" placeholder="Name" required>
            <button type="submit" class="button is-primary"><i class="material-icons">search</i></button>
        </form>
        <form class="search" action="index.php?keyword=<?php echo $_GET['keyword'];?>" method="get">
            <input type="text" name="keyword" class="input is-primary" placeholder="Company" required>
            <button type="submit" class="button is-primary"><i class="material-icons">search</i></button>
        </form>
        <form class="search" action="index.php?state=<?php echo $_GET['country'];?>" method="get">
            <input type="text" name="country" class="input is-primary" placeholder="Country" required>
            <button type="submit" class="button is-primary"><i class="material-icons">search</i></button>
        </form>
    </div>
    <table class="table is-responsive">
        <thead>
            <tr>
                <th>Created</th>
                <th>Name</th>
                <th>Company</th>
                <th>Country</th>
                <th>Note</th>
                <th>Edit lead</th>
                <th>Add note</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while($res = $r->fetch(PDO::FETCH_ASSOC)):?>
            <tr>
                <td class="created"><?php echo $res['added']; ?></td>
                <td class="name"><?php echo $res['name']; ?></td>
                <td class="compWidth"><?php echo $res['company']; ?></td>
                <td class="compWidth"><?php echo $res['country']; ?></td>
                <td class="note"><?php echo $res['note']; ?></td>
                <td>
                    <?php if(isset($_GET['page'])){?>
                    <form method="post" action="index.php?page=<?php echo $_GET['page'] ?>&id=<?php echo $res['id']?>">
                        <button  type="submit" class="button editnote is-warning"><i class="far fa-edit"></i> &nbsp;&nbsp;Edit</button>
                    </form>
                    <?php }else{?>
                    <form method="post" action="index.php?id=<?php echo $res['id']?>">
                        <button  type="submit" class="button editnote is-warning"><i class="far fa-edit"></i> &nbsp;&nbsp;Edit</button>
                    </form>
                    <?php }?>
                </td>
                <td>
                    <?php if(strlen($res['note'])<1){?>
                        <form class="formWidth" action="addnote.php?id=<?php echo $res['id'];?>" method="post" autocomplete="off">
                            <input type="text" name="note" required class="input is-info">
                            <button name="submit" type="submit" class="button is-info"><i class="far fa-plus-square"></i> &nbsp;&nbsp;Add note</button>
                        </form>
                    <?php }?>
                </td>
                    <td class="delit"><form action="delete.php?id=<?php echo $res['id'];?>" method="post"><button name="submit" type="submit" class="delete is-danger"></button></form></td>
                
                <?php    endwhile;?>
            </tr>
        </tbody>
    </table>
    <form action="add.php" method="POST" class="addLead">
        <label for="name">Name:</label>
        <input type="text" name="name" class="input is-primary" required autocomplete="off">
        <label for="company">Company:</label>
        <input type="text" name="company" class="input is-primary" required autocomplete="off">
        <label for="company">Country:</label>
        <input type="text" name="country" class="input is-primary" required autocomplete="off">
        <button type="submit" class="button is-primary"><i class="material-icons">playlist_add</i> &nbsp;Add contact</button>
    </form>
    <!-- pagination -->
    <nav class="pagination">
        <?php
        if(!isset($_GET['page'])){?>
        <!-- indexphp -->
            <a class="is-current pagination-link" href='<?php echo "?page=1"; ?>' class="links pagination-link">1</a>
            <a class="pagination-link is-primary" href="index.php?page=2">2</a>
            <a class="pagination-link is-primary" href="index.php?page=3">3</a>
            <span class="pagination-ellipsis">&hellip;</span>
            <a class="pagination-link is-primary" href="index.php?page=<?php echo $total_pages;?>"><?php echo $total_pages;?></a>
            <a class="next button is-primary" href="index.php?page=2">Next <i class="material-icons">navigate_next</i></a>
        <?php }
        if(isset($_GET['page'])){$pageWatcher = $_GET['page'];
        //first page
        if($pageWatcher == 1){?>
            <a href='<?php echo "?page=$page"; ?>' class="links pagination-link"><?php echo $_GET['page']; ?></a>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']+1;}?>"><?php echo $_GET['page']+1;?></a>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']+2;}?>"><?php echo $_GET['page']+2;?></a>
            <span class="pagination-ellipsis">&hellip;</span>
            <a class="pagination-link is-primary" href="index.php?page=<?php echo $total_pages;?>"><?php echo $total_pages;?></a>
            <a class="next button is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']+1;}?>">Next <i class="material-icons">navigate_next</i></a>
        <?php }?>
        <?php $pageCount = intval($total_pages);
        //last page
        if($pageWatcher == $pageCount){?>
            <a class="prev button is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']-1;}?>"><i class="material-icons">navigate_before</i> Back</a>
            <a class="pagination-link is-primary" href="index.php?page=1"><?php echo 1;?></a>
            <span class="pagination-ellipsis">&hellip;</span>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']-2;}?>"><?php echo $_GET['page']-2;?></a>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']-1;}?>"><?php echo $_GET['page']-1;?></a>
            <a href='<?php echo "?page=$page"; ?>' class="links pagination-link"><?php echo $_GET['page']; ?></a>
        <?php }
        //rest of the results
        if($pageWatcher > 1 && $pageWatcher < $pageCount){?>
            <a class="prev button is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']-1;}?>"><i class="material-icons">navigate_before</i> Back</a>
            <a class="pagination-link is-primary" href="index.php?page=1"><?php echo 1;?></a>
            <span class="pagination-ellipsis">&hellip;</span>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']-1;}?>"><?php echo $_GET['page']-1;?></a>
            <a href='<?php echo "?page=$page"; ?>' class="links pagination-link"><?php echo $_GET['page']; ?></a>
            <a class="pagination-link is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']+1;}?>"><?php echo $_GET['page']+1;?></a>
            <span class="pagination-ellipsis">&hellip;</span>
            <a class="pagination-link is-primary" href="index.php?page=<?php echo $total_pages;?>"><?php echo $total_pages;?></a>
            <a class="next button is-primary" href="index.php?page=<?php if(isset($_GET['page'])) {echo $_GET['page']+1;}?>">Next <i class="material-icons">navigate_next</i></a>
        <?php }};?>
    </nav>
    <!-- pagination -->
    <?php if(isset($_GET['id']) > 0){ ?>        
    <div class="popupBody">
    <div class="closePopup"><a href="index.php?page=<?php echo $_GET['page'] ?>" class="delete is-medium"></a></div>
        <form action="editnote.php?id=<?php echo $_GET['id'];?>" method="post" autocomplete="off">
            <label for="name">Name</label>
            <textarea type="text" name="editname"required class="input menuInputHeight is-warning"><?php if (isset($_GET['id'])){ $displayName = $db->prepare("SELECT name FROM tabmsg WHERE id = :id"); $displayName->execute(['id' => $_GET['id']]);} foreach($displayName as $actualName){ echo $actualName['name'];};?></textarea>
            <label for="name">Company</label>
            <textarea type="text" name="editcompany"required class="input menuInputHeight is-warning"><?php if (isset($_GET['id'])){ $displayCompany = $db->prepare("SELECT company FROM tabmsg WHERE id = :id"); $displayCompany->execute(['id' => $_GET['id']]);} foreach($displayCompany as $actualCompany){ echo $actualCompany['company'];};?></textarea>
            <label for="name">Country</label>
            <textarea type="text" name="editcountry"required class="input menuInputHeight is-warning"><?php if (isset($_GET['id'])){ $displayCountry = $db->prepare("SELECT country FROM tabmsg WHERE id = :id"); $displayCountry->execute(['id' => $_GET['id']]);} foreach($displayCountry as $actualCountry){ echo $actualCountry['country'];};?></textarea>
            <label for="name">Note</label>
            <textarea type="text" name="editnote" required class="input is-warning"><?php if (isset($_GET['id'])){ $displayNote = $db->prepare("SELECT note FROM tabmsg WHERE id = :id"); $displayNote->execute(['id' => $_GET['id']]);} foreach($displayNote as $actualNote){ echo $actualNote['note'];};?></textarea>
            <button name="submit" type="submit" class="button is-warning">Submit</button>
        </form>
    </div>
    <script>
        $('.popupBody').css('left','0');
    </script>
    <?php }?>
</main>
    <script>
    $(document).ready(function(){
        $("a[href$='<?php if(isset($_GET['page'])){echo $_GET['page'];} ?>']").addClass('is-current');
    });
    </script>
</body>
</html>