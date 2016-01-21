<footer> 
    <?php
	echo "footer";
    ?>
</footer>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo BOOTSTRAP;?>js/bootstrap.min.js"></script>    
<?php
    if(isset($css)&&($css!="")){
	for($i=0;$i<count($css);$i++){
	    echo '<link href="'.$css[$i].'" rel="stylesheet">';
	}
    }
    if(isset($load_js)&&($load_js!="")){
	for($i=0;$i<count($load_js);$i++){
	    echo '<script type="text/javascript" src="'.$load_js[$i].'"></script>';
	}
    }
?>
</body>
</html>