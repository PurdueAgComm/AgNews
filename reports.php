<?php
include_once('includes/header.php'); // authenticate users, includes db connection.
if($_SESSION["isAdmin"] != 1) {
	$_SESSION["error"] = "You do not have the creditentials to access this page. (Admin)";
	header("Location: error.php");
}
?>

<h3>Reports</h3>

<h3><strong>Step 1:</strong> Select the fields that you want to appear in your custom report</h3>
<div class="row">
    <div class="col-sm-12">
        <select multiple="multiple" data-title="Fields" data-source="includes/report.json" data-value="index" data-text="name"></select>
    </div>
</div>

<h3><strong>Step 2:</strong> Choose the field with which you want to sort</h3>


<h3><strong>Step 3:</strong> Choose a custom date range</h3>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/dual-list-box.min.js"></script>
<script type="text/javascript">
        $('select').DualListBox();
</script>

<?php
include_once('includes/footer.php');
?>