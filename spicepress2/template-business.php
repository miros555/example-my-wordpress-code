<?php 
		// Template Name: Business Template
		
		get_header();
?>
<div class="sf">
<input type="text" id="txt" >
<input type="button" id="btn" value="&#10155;Пошук" onclick="someFunc()">
</div>
<script>
    function someFunc(a){
	var a = document.getElementById("txt").value
    window.location.href='https://www.google.com/search?q='+a;
	}
	</script>
<?php
		do_action( 'spiceb_spicepress_sections', false );
		get_template_part('index','news');
?>
<?php
        get_footer();
?>