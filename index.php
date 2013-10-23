<?php 
if($_POST['valide'] == true) {
	header('Location: base.php');
}
include 'head.php'; 

?>
	<form method='POST' action="index.php" name="connect">
		<div id="container">
			<div id="connect">
				
				<table id="tabConnect">
				<caption><h3>Identification</h3></caption>
					<tr><td>Identifiant</td><td><input type="name"></td></tr>
					<tr><td>Pass</td><td><input type="password"></td></tr>
				</table>
				<input type="submit" value="ok" name="valide" />
			</div>
		</div>
<?php include 'foot.php'; ?>