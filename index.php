<HTML>
<HEAD>
<TITLE> Skeleton page - demonstrates how to query a database</TITLE>
<!-- // Load any stylesheets here
<LINK rel="stylesheet" type="text/css" HREF="./books.css">

</HEAD>
<BODY>
<!-- Variables are returned as $_GET["varname"] or $_POST["varname"] -->
<!-- Displaying the time at the server is useful to show the page was generated and not loaded from cache -->
<?php date_default_timezone_set('Australia/Sydney'); ?>
<p>Local time is <?php echo  date("l dS o F Y h:i:s A")?><BR>
<!--  Notice that the "<?= expression ?>" nugget to print an expression in the middle of HTML -->
<!--  won't work on all versions or installs of PHP and you may have to -->
<!--  use "<?php echo expression ?>" instead -->

<?php
	// PHP/C++-style comments inside the PHP code
	// First, include the common database access functions, if they're not already included
	require_once "./common_db.php";
	# Get a PDO database connection - see http://www.php.net/manual/en/book.pdo.php
	$dbo = db_connect();

	# Construct an SQL query as multiple lines for readability
	$query = "SELECT cat_id, cat_name AS Category, cat_desc AS Description";
	# Append to the $query string - note the required space
	$query .= " FROM Category";
	# If a category name has been provided, then add a WHERE clause
    if (isset($_GET["catname"])) {
    	$query .= " WHERE Category.cat_name LIKE '" . $_GET["catname"] ."%'";
    }
    # Sort on category name, not ID
    $query .= " ORDER BY cat_name";
    
    # Display the constructed query
    echo "<p>" . $query . "</p>";

	# Run the query, returning a PDOStatement object - see http://www.php.net/manual/en/class.pdostatement.php
	# Notice, this statement will throw a PDOException object if any problems - see http://www.php.net/manual/en/class.pdoexception.php
	# There's another thing wrong with this query which we'll look at when we discuss SQL injection
	try {
		$statement = $dbo->query($query);
	}
	# Provide the exception handler - in this case, just print an error message and die,
	# but see the provided default exception handler in common_db.php, which logs to the Apache error log
	catch (PDOException $ex) {
		echo $ex->getMessage();
		die ("Invalid query");
	}
	
	$headers = array("ID", "Category", "Description");
?>
<!-- Mixed-up HTML and embedded bits of PHP from here on; read the tags carefully -->
<!-- Print the table headers, with 2px borders around cells so you can see the structure -->
<TABLE BORDER=2>
<TR>
<!-- First, print the column headers -->
<?php for($j=0; $j < $statement->columnCount(); $j++) { ?> <!-- see http://www.php.net/manual/en/pdostatement.columncount.php -->
	<TH><?php echo $headers[$j] ?></TH>
<?php	} ?>
   </TR>
<?php
	# Print the rest of the table
	# fetch() returns an array (by default, both indexed and name-associated) of result values for the row
    while($row = $statement->fetch()) { ?> <!-- see http://www.php.net/manual/en/pdostatement.fetch.php -->
		<TR>
	<?php	for ($j = 0; $j < $statement->columnCount(); $j++) { ?>
		    <TD><?php echo $row[$j]?></TD>
	<?php	} ?>
		</TR>
<?php	}

	# Drop the reference to the database
	$dbo = null;
?>
</TABLE>
<!-- A small form to allow searching for a specific category -->
<FORM METHOD="get" ACTION="skel.php">
    <P>Enter a specific category to search for:</P>
    <INPUT TYPE="TEXT" NAME="catname" SIZE="40">
    <INPUT TYPE="SUBMIT">
</FORM>
</BODY>
</HTML>