<?php

include_once("includes/header.php");

?>
<style>
/* Custom container */
      .containerSocial {
        margin: 0 auto;
        max-width: 800px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);

      }
      .container > hr {
        margin: 60px 0;
      }

</style>



   <div class="containerSocial">
   	<h3>Social Media</h3>

    <?php ($_SESSION["customTweet"]) ? $title = "Custom Tweet: " : $title= "Headline: "; ?>

   	<p><strong><?= $title ?></strong> <?php echo $_SESSION["tweetHeadline"]; ?></p>
   	<p><strong>News URL:</strong> <a href="<?php echo $_SESSION["tweetURL"]; ?>"><?php echo $_SESSION["tweetURL"]; ?></a></p>

   	<hr>


   	<table style="width: 100%;">
   		<tr>
   			<td><strong>Tweet Story:</strong></td><td><a href="https://twitter.com/share" class="twitter-share-button" data-url="<? echo $_SESSION['tweetURL'];?>" data-text="<? echo $_SESSION['tweetHeadline'];?>" data-size="large">Tweet Purdue Ag</a></td>

   			<td>
   				<strong>Facebook Story:</strong>
   			</td>
   			<td>
   				<a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_SESSION["tweetURL"]; ?>','facebook-share-dialog','width=626,height=436'); return false;"><img src="img/fbshare.gif" alt="Share on Facebook" style="cursor: pointer;" /></a>
   			</td>
   		</tr>
   	</table>

   </div> <!-- /container -->



<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>








<?php

include_once("includes/footer.php");

?>