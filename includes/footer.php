
      <hr>

      <div class="footer" style="clear:both;">
        <!-- Site Launched January 2014 -->
        <p>&copy; Purdue University 2013-<?=date("Y")?> | You are logged in as <?php echo phpCAS::getAttribute('fullname');?>. <a href="?logout=1">Logout</a>
        <span class="muted pull-right"><small><i class="fa fa-gift text-muted" data-container="body" rel="tooltip" title="Updated 2015!"></i> version 1.3</small></p>


      <div class="alert alert-info"><strong>1.3.0 Changelog</strong><br />
        <ul>
          <li>Changes to doUpdateStage.php</li>
          <li>Notables release</li>
          <li>~ Bootstrap Upgrade</li>
      </div>

    </div> <!-- /container -->


    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });

    function setConfirmUnload(on) {
     window.onbeforeunload = (on) ? unloadMessage : null;
    }

    function unloadMessage() {
         return 'You have entered new data on this page.' +
            ' If you navigate away from this page without' +
            ' first saving your data, the changes will be' +
            ' lost.';
    }

    $(document).ready(function() {

     $(':input',document.addForm).bind(
         "change", function() {
              setConfirmUnload(true);
         }
     ); // Prevent accidental navigation away

    });






    </script>



  </body>
</html>
