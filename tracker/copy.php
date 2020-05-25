<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Copypaste</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.1/css/bulma.min.css">
    <link rel="stylesheet" href="copystyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://www.arvisual.eu/imgs/favicon.png">
</head>
<body>

<?php
require 'copystart.php';
header('Content-type: text/html; charset=utf-8');


//if nothing is set
if(!isset($_GET['lang'])){
    $pages = $db->query("SELECT * FROM eng")->fetchAll(PDO::FETCH_ASSOC);
}

//if en lang
if(isset($_GET['lang']) && $_GET['lang'] == "en"){
    $pages = $db->query("SELECT * FROM eng")->fetchAll(PDO::FETCH_ASSOC);
}

//if sk lang
if(isset($_GET['lang']) && $_GET['lang'] == "sk"){
    $pages = $db->query("SELECT * FROM sk")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="tabs is-centered ">
  <ul>
    <li class="sk"><a href="copy.php?lang=sk">Sk</a></li>
    <li class="en"><a href="copy.php?lang=en">En</a></li>
  </ul>
</div>


<div class="containerz">
    <div class="flexMain">
        <!-- Actual unit loop -->
        <?php foreach($pages as $page){?>
        <div class="flexUnit">
            <p class="text"><?php echo $page['txt'];?></p>
            <!-- Delete buttons -->
            <?php if(isset($_GET['lang']) && $_GET['lang'] == "sk"){?>
                <form class="deleteBtn" action="deletecopy.php?id=<?php echo $page['id'];?>&lang=sk" method="post">
                    <button name="submit" type="submit" class="delete is-danger"></button>
                </form>
            <?php } if(!isset($_GET['lang']) || $_GET['lang'] == "en"){?>
                <form class="deleteBtn" action="deletecopy.php?id=<?php echo $page['ID'];?>&lang=en" method="post">
                    <button name="submit" type="submit" class="delete is-danger"></button>
                </form>
            <?php }?>
            <!-- Delete buttons end -->
        </div>
        <?php }?>
        <!-- Actual unit loop end -->
    </div>
    <!-- Forms to add new texts -->
    <?php if(!isset($_GET['lang'])){ ?>
    <form class="addNewText" action="addcopy.php?lang=en" method="POST">
        <label for="textare">Add new note:</label>
        <textarea class="input is-primary" name="textarea"></textarea>
        <button class="button is-primary" type="submit" name="submit">Add&nbsp;&nbsp; <i class="material-icons">add_circle_outline</i></button>
    </form>
    <?php }?>
    <?php if(isset($_GET['lang']) && $_GET['lang'] == "en"){ ?>
    <form class="addNewText" action="addcopy.php?lang=en" method="POST">
        <label for="textare">Add new note:</label>
        <textarea class="input is-primary" name="textarea"></textarea>
        <button class="button is-primary" type="submit" name="submit">Add&nbsp;&nbsp; <i class="material-icons">add_circle_outline</i></button>
    </form>
    <?php }?>
    <?php if(isset($_GET['lang']) && $_GET['lang'] == "sk"){ ?>
    <form class="addNewText" action="addcopy.php?lang=sk" method="POST">
        <label for="textare">Add new note:</label>
        <textarea class="input is-primary" name="textarea"></textarea>
        <button class="button is-primary" type="submit" name="submit">Add&nbsp;&nbsp; <i class="material-icons">add_circle_outline</i></button>
    </form>
    <?php }?>
    <!-- End of form adding -->
</div>

<!-- Is-active functionality of language selectors -->
<?php if(!isset($_GET['lang'])){?><script>$('.en').addClass('is-active');</script><?php }?>
<?php if(isset($_GET['lang']) && $_GET['lang'] == "sk"){?><script>$('.sk').addClass('is-active');</script><?php }?>
<?php if(isset($_GET['lang']) && $_GET['lang'] == "en"){?><script>$('.en').addClass('is-active');</script><?php }?>

<script>
const aioColors = document.querySelectorAll('.flexUnit p');

aioColors.forEach(p => {
  p.addEventListener('click', () => {
    const selection = window.getSelection();
    const range = document.createRange();
    range.selectNodeContents(p);
    selection.removeAllRanges();
    selection.addRange(range);

    function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />'   : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag   + '$2');
    }

    try {
      document.execCommand('copy');
      selection.removeAllRanges();

      const original = p.textContent.nl2br();
      p.textContent = original;
      p.classList.add('success');

      setTimeout(() => {
        p.textContent = original;
        p.classList.remove('success');
      }, 1200);
    } catch(e) {
      const errorMsg = document.querySelector('.error-msg');
      errorMsg.classList.add('show');

      setTimeout(() => {
        errorMsg.classList.remove('show');
      }, 1200);
    }
  });
});
</script>
<script>
//Get mouse coords
$('.text').click(function(e){
    var ttip = document.createElement("p");
    document.body.appendChild(ttip);
    ttip.innerHTML = "Copied!";
    ttip.classList.add('tooltip');
    var x = e.clientX;
    var y = e.clientY;
    var width = $('.tooltip').innerWidth() - 15;
    var halfWidth = width / 2;
    $('.tooltip').css('top', y + 30).css('left', x - halfWidth).css('opacity','1');
    setTimeout(() => {
        $('.tooltip').css('opacity','0');
        document.body.removeChild(ttip);
    }, 800);
});

</script>
</body>
</html>