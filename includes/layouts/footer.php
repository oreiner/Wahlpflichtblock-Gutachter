    <div id="footer"><small>Copyright <?php echo date("Y"); ?>, WPB-Gutachter</small></div>

	</body>
</html>
<?php
  // 5. Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>
