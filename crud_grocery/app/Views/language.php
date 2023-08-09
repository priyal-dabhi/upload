<h1>My Custom Language</h1>


<form>
    <select>

    </select>
</form>
<ul class="dropdown-menu">
    <li><a href="<?= site_url('lang/en'); ?>">HTML</a></li>
    <li><a href="<?= site_url('lang/ci'); ?>">CSS</a></li>
    <li><a href="#">JavaScript</a></li>
</ul>
<a class="dropdown-item" href="<?= site_url('lang/en'); ?>">English</a>
<a class="dropdown-item" href="<?= site_url('lang/ci'); ?>">chience</a>
<a class="dropdown-item" href="<?= site_url('lang/fr'); ?>">French</a>

<?php

echo ($first ?? '') . '<br/>';
echo ($second ?? '') . '<br/>';
echo ($third ?? '') . '<br/>';
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
</script>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        /* Selects the third <li> element.*/
        // var sess = "?php echo $this->session->get('lang'); ?>";
        // alert(sess);
       // $("li:eq(2)").css("background-color", "yellow");
    });
</script>