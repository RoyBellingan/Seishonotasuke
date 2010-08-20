<?php 
define('ABSPATH', dirname(__FILE__).'/');


include_once (ABSPATH."/util/top_foot_inc.php");

//include_once ("elenco_lib.php");
top2();
?>
<form action="lang2.php" method="post" accept-charset="utf-8" name="lingua">
<h2>Lingua Principale</h2>
	<select id="lang" name="lang">
		<option value="italiano">Italiano</option>
		<option value="english">English</option>
		<option value="日本語">日本語</option>
		<option value="español">Español</option>
		<option value="pусский">Pусский</option>
	</select>
<h2>Lingua Interlineare</h2>
		<select id="lang1" name="lang1">
		<option value="italiano">Italiano</option>
		<option value="english">English</option>
		<option value="日本語">日本語</option>
		<option value="español">Español</option>
		<option value="pусский">Pусский</option>
	</select>
	<p><input type="submit" value="Continue" /></p>
</form>
<?php foot();?>





