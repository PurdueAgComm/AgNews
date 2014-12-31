<?php 

include_once("includes/header.php");

?>

<style type="text/css">

input[type="image"]{
   padding:10px;
   border:1px solid #cccccc;
   border-radius: 1.0em;
}
</style>

 <div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tabs1-pane1" data-toggle="tab">Creating Story</a></li>
		<li><a href="#tabs1-pane2" data-toggle="tab">Story Status</a></li>
		<li><a href="#tabs1-pane3" data-toggle="tab">Work List</a></li>
		<li><a href="#tabs1-pane4" data-toggle="tab">Control Panel</a></li>
   		<li><a href="#tabs1-pane5" data-toggle="tab">Quick FAQs</a></li>
   		<li><a href="#tabs1-pane6" data-toggle="tab">Contact Help</a></li>
	</ul>
	
    <div class="tab-content">
        
		<div class="tab-pane active" id="tabs1-pane1"> <!--Creating Story begin help section-->						
			<div class="accordion" id="accordion2">
              
                <!--start a new help segment, "Add a new story", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOneCreate">
			        Where do I go to enter a new story?
			      </a>
			    </div>
			    <div id="collapseOneCreate" class="accordion-body collapse">
			      <div class="accordion-inner">
			        A new story may be initiated from several starting points within the database. <br />You can start a new story:
                    <ul>
                    	<li>from the <b><a href="#" target="_self" name="Header" width="268" height="167" alt="header" class="img-rounded" onClick="window.open('img/help/newStoryHome.jpg','mywindow','width=400,height=230,top=200,screenX=100,screenY=100')">Home</a></b> tab</li>                        
                        <li>from the <b><a href="#" target="_self" name="Header" width="268" height="167" alt="header" class="img-rounded" onClick="window.open('img/help/newsStories1.jpg','mywindow','width=425,height=250,top=200,screenX=100,screenY=100')">News Stories</a></b> tab</li>
                        <li>from the <b><a href="#" target="_self" name="Header" width="268" height="167" alt="header" class="img-rounded" onClick="window.open('img/help/addStory.jpg','mywindow','width=475,height=475,top=200,screenX=100,screenY=100')">Add Story</a></b> tab</li>                  
                <br />
                      <INPUT type ="image" src="img/help/header2.jpg" name="Header" width="500" height="67" alt="header" class="img-rounded" onClick="window.open('img/help/header_03.jpg','mywindow','width=1020,height=180,top=200,screenX=100,screenY=100')">
                                                   
                    </ul>
                  
			      </div>
			    </div>
			  </div> <!--end Enter New Story, Creating Story-->
              
              
                 <!--start a new help segment, "Required", in Creating Story-->             
              <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwoRequired">
			        What is required to start a new story?
			      </a>
			    </div>
			    <div id="collapseTwoRequired" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <p>The only thing that is required to create a news story is the <strong>Filename</strong>.</p>
			      </div>
			    </div>
			  </div> <!--end Required, Creating Story-->
                                   
                 
                 <!--start a new help segment, "Edit Box", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThreeEdit">
			        How do I use the News edit box? 
			      </a>
			    </div>
			    <div id="collapseThreeEdit" class="accordion-body collapse">
			      <div class="accordion-inner">
			        The edit box includes the standard text editor tools:
                    <br />
                    <ul>
                    <li>The first three commands will change the style of your text to bold, italicize, or underline.</li>
                    <li>The hyperlink tool is to the right of underline.</li>
                    <li>You can put your story points in bulleted form or ordered by number.</li>
                    <li>You can undo or redo your actions.</li>
                    <li>You can search your story with a click on the binocular icon.</li>
                    <li>The tool to the right of the binoculars can be used to find/replace content.</li></ul>
                    The tracking tools are located to the very right of the tool bar. You have the choice to:
                    <ul>
                    <li>Turn on the tracking.</li>
                    <li>Turn off the tracking.</li>
                    <li>Accept all changes.</li>
                    <li>Decline all changes.</li>
                    <li>Accept individual changes.</li>
                    <li>Decline individual changes.</li></li>
                    </ul>
                
                <br />
                      <INPUT type ="image" src="img/help/storyEditBox1.jpg" name="editBox" width="400" height="171" alt="edit box" class="img-rounded" onClick="window.open('img/help/storyEditBox2.jpg','mywindow','width=900,height=500,top=200,screenX=100,screenY=100')">
                      
			      </div>
			    </div>
			  </div> <!--end Edit, Creating Story-->     

              
                 <!--start a new help segment, "Find a person, department", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFourPeople">
			        How do I choose a writer, source, department, or affiliation? 
			      </a>
			    </div>
			    <div id="collapseFourPeople" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <p>When you start typing in the field, a list of identified possible answers will show. The search will look for the combination of letters matching your entry.</p>
                    
                   <p> This type of search applies to the following fields:</p>
                    <ul>
                    <li>Writer(s)</li>
                    <li>Source(s)</li>
                    <li>Department(s)</li>
                    <li>Affiliation(s)</li>
                    </ul>        
                    
                    <p>The following example demonstrates this process in the <i>Source(s)</i> field. The news writer starts to type a name. You can type a first name or a last name. A group of possible choices will show under the field you are working in. The database has found several choices with the letter combination "ni". Once you see the information you want to select, you can choose the name by continuing typing until only one choice is evident then select by pressing your enter key. Or, you may use any combination of your select arrows, enter key, or mouse to choose the correct information for the field.</p>            
                    
               
                     <p/>
                      <INPUT type ="image" src="img/help/peopleFind_sm.jpg" name="People" width="250" height="130" alt="people find" class="img-rounded" onClick="window.open('img/help/peopleFind.jpg','mywindow','width=600,height=350,top=200,screenX=100,screenY=100')">
                      
			      </div>
			    </div>
			  </div> <!--end People, Creating Story-->               
              
              
                 <!--start a new help segment, "Internal Info", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFiveInternal">
			        What is important about the Internal Information area?
			      </a>
			    </div>
			    <div id="collapseFiveInternal" class="accordion-body collapse">
			      <div class="accordion-inner">
			       <p>The <i>Internal Information</i> area populates the <i>Work List</i>. <br />Fields included in this area are:</p>
                   <ul>
                   <li>Filename</li>
                   <li>Writer(s)</li>
                   <li>Intent</li>
                   <li>Reach</li>
                   </ul>
                 <p>You can save your story with the convenient blue "Create Story" button.</p>  
                      <INPUT type ="image" src="img/help/internal1.jpg" name="Internal Information" width="400" height="232" alt="header" class="img-rounded" onClick="window.open('img/help/internal.jpg','mywindow','width=800,height=400,top=200,screenX=100,screenY=100')">                                      
			      </div>
			    </div>
			  </div> <!--end Internal, Creating Story-->
              
                            
              
                 <!--start a new help segment, "General Info", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSixGeneral">
			        What is important about the General Information area?
			      </a>
			    </div>
			    <div id="collapseSixGeneral" class="accordion-body collapse">
			      <div class="accordion-inner">
			       <p>The <i>General Information</i> area requests additional story information. 
                   <br />&diams; Be sure to click on a blue "Create Story" button to save the entered information.
                   <br /><br />Fields included in this area are:</p>
                   <ul>
                   <li>Headline</li>
                   <li>Source(s) - up to 5 sources may be entered. If the source is not in the database, add the new source with a click of the <i>New Source Profile</i> icon</li>
                   <li>Department(s) - up to 5 departments may be entered.</li>
                   <li>Affiliation(s) - Up to 5 affiliations may be entered.</li>
                   <li>Publish Date - Please use the calendar icon to choose the date.</li>
                   </ul>
                   
                      <INPUT type ="image" src="img/help/generalInfo_sm.jpg" name="Internal Information" width="350" height="263" alt="header" class="img-rounded" onClick="window.open('img/help/generalInfo.jpg','mywindow','width=900,height=500,top=200,screenX=100,screenY=100')">                   
                   <p><b>Icon Definitions</b></p>
                   <ul>
                   <li>Show More Fields - This will open more fields. Choose this icon if more than one answer is applicable.<br />
                   <INPUT type ="image" src="img/help/iconsField.jpg" name="More fields icon" width="136" height="66" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsField.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                   </li>
<br />
                   <li>New Source Profile - Choose this icon if a new source must be added to the database. <br />
                   <INPUT type ="image" src="img/help/iconsSource.jpg" name="Add a source icon" width="136" height="67" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsSource.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                   </li>        
<br />           
                    <li>Calendar - Choose this icon to open the calendar window. The <i>Publish Date</i> must be chosen via the calendar option. <br />
                   <INPUT type ="image" src="img/help/iconsCalendar.jpg" name="Calendar icon" width="137" height="65" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsCalendar.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                   </li>                   
                                                      
                   </ul>
       
			      </div>
			    </div>
			  </div> <!--end General, Creating Story-->
              
              
                              
                 <!--start a new help segment, "Metadata", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSevMeta">
			        What is important about the Define Metadata area?
			      </a>
			    </div>
			    <div id="collapseSevMeta" class="accordion-body collapse">
			      <div class="accordion-inner">
			       <p>The <i>Define Metadata</i> area requests additional story information. Check all that apply.</p>
                   <p>&diams; Be sure to click on a blue "Create Story" button to save the entered information.</p>

                      <INPUT type ="image" src="img/help/Meta_sm.jpg" name="Internal Information" width="154" height="400" alt="header" class="img-rounded" onClick="window.open('img/help/Meta.jpg','mywindow','width=400,height=1000,top=200,screenX=100,screenY=100')">                                    
			      </div>
			    </div>
			  </div> <!--end Meta, Creating Story-->
           
                               
                               
                 <!--start a new help segment, "Multimedia", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseEightMulti">
			        What is important about the Multimedia area?
			      </a>
			    </div>
			    <div id="collapseEightMulti" class="accordion-body collapse">
			      <div class="accordion-inner">
			       <ul>
                   <li>Copy/paste the YouTube video URL here.</li>
                   <li>Enter up to 5 related websites here. Be sure to enter the <i>Title</i> and the <i>Link</i>.</li>
                   <li>The <i>Included Media</i> will be added to the <i>Work List</i>. Check all that apply.</li>
                   </ul>
                  
                  <p>&diams; Be sure to click on a blue "Create Story" button to save the entered information.</p>
                  
                      <INPUT type ="image" src="img/help/multimedia_sm.jpg" name="Internal Information" width="400" height="129" alt="header" class="img-rounded" onClick="window.open('img/help/multimedia.jpg','mywindow','width=1100,height=400,top=200,screenX=100,screenY=100')">             
			      </div>
			    </div>
			  </div> <!--end Multimedia, Creating Story-->
              
             
                 <!--start a new help segment, "Work List", in Creating Story-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseNineWork">
			        When is my story added to the Work List?
			      </a>
			    </div>
			    <div id="collapseNineWork" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>In order for the story to be sent to M&M in the <i>Work List</i>, the story will need</p>
			        <ul>
			        	<li>Filename</li>
			        	<li>Writer (at least one)</li>
			        	<li>Intent</li>
			        </ul>

			        <p><span class="label label-important">Important</span> If you have entered a story that does not contain all four of these fields, the story will not be sent in the <i>Work List</i> to M&M; however, it will be saved in the database for you to update at a later time.</p>
			     
			      </div>
			    </div>
			  </div> <!--end Work List, Creating Story-->
      
     
                 <!--start a new help segment, "Copy/paste", in Creating Story-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTenCopy">
			        Can I copy/paste from Word, or other programs, to the "News Story" edit box? 
			      </a>
			    </div>
			    <div id="collapseTenCopy" class="accordion-body collapse">
			      <div class="accordion-inner">
			        Yes you can. The editor box will strip the formatting. 
                
                      <p><span class="label label-important">Important</span> Copy/paste the body of the story only in the "News Story" edit box. There is a seperate field to enter the story headline.</p>
			      </div>
			    </div>
			  </div> <!--end Copy/Paste, Creating Story-->      

			</div>
		</div> <!--end of the first help tab, Creating Story TAB-->
        
        
        
        <!--start a new help tab: Story Status-->        
		<div class="tab-pane" id="tabs1-pane2">
			<div class="accordion" id="accordion3">
            
                <!--start a new help segment, "List View", in Story Status-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseOneStory">
			        Recognizing the story status within the <b>Home</b> tab and <b>News Stories</b> tab.
			      </a>
			    </div>
			    <div id="collapseOneStory" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <p>The <b>Home</b> tab and the <b>News Stories</b> tab provide a list view of the stories.</p>
                                    
                      <INPUT type ="image" src="img/help/newsList.jpg" name="Internal Information" width="300" height="102" alt="header" class="img-rounded" onClick="window.open('img/help/newsList.jpg','mywindow','width=1200,height=450,top=200,screenX=100,screenY=100')">                    <p>&nbsp;</p>        
                    
                    <ul>
                    <li>Published - The news story has been published. Published stories have a white background.</li>

                   <INPUT type ="image" src="img/help/iconsStatus.jpg" name="Status icon" width="213" height="84" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsStatus.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')"> <br /><br />
                    <li>Waiting on Approval - The news story has a <b><font color="#cccc00"><span style="text-decoration: underline; ">yellow</span></font></b> background. The writer is waiting on approval from the coordinator, M&M, or the source.</li>

                   <INPUT type ="image" src="img/help/iconsApproval.jpg" name="Status icon" width="203" height="90" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsApproval.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')"> <br /><br />                  
                    <li>Waiting on the Writer - The writer needs to do something with the story. The news story has a <b><font color="#ff9999"><span style="text-decoration: underline;">pink</span></font></b> background.</li>

                   <INPUT type ="image" src="img/help/iconsWriter.jpg" name="Status icon" width="211" height="101" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsWriter.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">                            
                    </ul>

			      </div>
			    </div>
			  </div>  <!--end of List View in Story Status-->
     
     
                 <!--start a new help segment, "Change Status", in Story Status-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwoLocation">
			        Where do I go to change the status of the story?
			      </a>
			    </div>
			    <div id="collapseTwoLocation" class="accordion-body collapse">
			      <div class="accordion-inner">
			       
                    <ul>
                    <li>Find the story within the list of stories located in the <b>Home</b> tab or <b>News Stories</b> tab.</li>
                    <li>Click on the story <i>filename</i> or the <i>headline</i>.</li>
                    </ul>
                    
                    <p>You will find yourself in the <i>Story Center</i> area. 
                    <br />The page will look like this:</p>
                    
                   <input type ="image" src="img/help/behold_sm.jpg" name="story control panel" width="350" height="318" alt="storyControl" class="img-rounded" onClick="window.open('img/help/behold.jpg','mywindow','width=900,height=900,top=200,screenX=100,screenY=100')">
			     
                  </div>
			    </div>
			  </div>  <!--end of Status Change in Story Status-->
		
     
                 <!--start a new help segment, "How To", in Story Status-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThreeChange">
			       How do I change the status of the story?
                   </a>
                 </div>
			    <div id="collapseThreeChange" class="accordion-body collapse">
			      <div class="accordion-inner">
			    
                    <ul>
                    <li>Find the dropdown list of status choices.</li>
                    <li>Select a status and click on the green checkmark to the right of the status list.</li>
                    </ul>

                   <INPUT type ="image" src="img/help/storyManage_sm.jpg" name="manage story" width="200" height="219" alt="storyManage" class="img-rounded" onClick="window.open('img/help/storyManage.jpg','mywindow','width=900,height=500,top=100,screenX=100,screenY=100')"> 
                    
			      </div>
			    </div>
			  </div>  <!--end of How To in Story Status-->
		
     
                 <!--start a new help segment, "Why", in Story Status-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseFourWhy">
			       What is the benefit of the story status?
			      </a>
			    </div>
			    <div id="collapseFourWhy" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <ol>
                    <li>Provide an at-a-glance workflow view of your stories and the unit's stories within the <b>News Stories</b> tab and the <b>News</b> tab.</li>
                    <li>Automatic email alerts are sent to the reviewers when the following statuses are chosen:
                    	<ul>
                          <li>"Coordinator Review"</li>
                          <li>"Source Check"</li>
                          <li>"M&M Review"</li>
                        </ul>      
                      
                    </ol>

                   <INPUT type ="image" src="img/help/storyManage_sm.jpg" name="manage story" width="200" height="219" alt="storyManage" class="img-rounded" onClick="window.open('img/help/storyManage.jpg','mywindow','width=900,height=500,top=100,screenX=100,screenY=100')"> 
                    
			      </div>
			    </div>
			  </div>  <!--end of Why in Story Status-->

            </div>
	  	</div>   <!--end of Story Status help section TAB-->
        
        
         <!--start a new help section, Work List-->    		
         <div class="tab-pane" id="tabs1-pane3">
			<div class="accordion" id="accordion4">
                
                <!--start a new help segment, "Work List", in Work List-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseOneWL">
			        When is my story added to the Work List?
			      </a>
			    </div>
			    <div id="collapseOneWL" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>In order for the story to be sent to M&M in the <i>Work List</i>, the story will need:</p>
			        <ul>
			        	<li>Filename</li>
			        	<li>Writer (at least one)</li>
			        	<li>Intent</li>
                        
			        </ul>

			        <p><span class="label label-important">Important</span> If you have entered a story that does not contain all four of these fields, the story will not be sent in the <i>Work List</i> to M&M; however, it will be saved in the database for you to update at a later time.</p>
			     
			      </div>
			    </div>
			  </div>  <!--end of Work List in Work List-->
              
                             
                <!--start a new help segment, "Work List", in Work List-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseTwoInclude">
			        What is included in the Work List document?
			      </a>
			    </div>
			    <div id="collapseTwoInclude" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>The <i>Work List</i> provides information for M&M, the News coordinator, or anyone interested in the upcoming news releases.</p>
                    <p>The <i>Work List</i> document is sorted by "Reach" and includes the following information:</p>
			        <ul>
			        	<li>Filename - "NiyogiWeather" for example.</li>
			        	<li>Source - the name of the source.</li>
			        	<li>Writer - the writer's name.</li>
                        <li>Intent - story summary.</li>
                        <li>Publish Date - the goal date to publish the story.</li>
                        <li>Multimedia Information - include this information if the news release has an accompanying photo, video, graphic, or audio component.</li>
                        <li>Reach - Options include: State, Midwest, National, Global, or Development (no reach assigned).</li>
                        
			        </ul>
                    
                    <INPUT type ="image" src="img/help/workList_sm.jpg" name="work list" width="250" height="133" alt="workList" class="img-rounded" onClick="window.open('img/help/workList.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    

			      </div>
			    </div>
			  </div>  <!--end of Work List in Work List-->
              
                             
                <!--start a new help segment, "M&M Contact", in Work List-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseThreeContact">
			        What do we do if the M&M contact person changes?
			      </a>
			    </div>
			    <div id="collapseThreeContact" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>You can change the M&M contact's email information at any time.</p>
                    
			        <ul>
			        	<li>Navigate to the <b>Control Panel</b> tab.</li>
			        	<li>Press the <i>Work List</i> button.</li>
			        	<li>Locate the "Edit" icon.</li>
                   
                   <!--<p><INPUT type ="image" src="img/help/iconsEditWL.jpg" name="Status icon" width="213" height="84" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsEditWL.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')"><br />-->
                   
                      <INPUT type ="image" src="img/help/editContact_sm.jpg" name="edit contact" width="400" height="67" alt="editContact" class="img-rounded" onClick="window.open('img/help/editContact.jpg','mywindow','width=1150,height=350,top=100,screenX=100,screenY=100')">  
                   </p>

			        </ul>

			      </div>
			    </div>
			  </div>  <!--end of M&M contact in Work List-->
              
      
	    	</div>			
		</div>    <!--end of Work List help section TAB-->
        
        
        
        <!--start a new help tab: Control Panel-->          
		<div class="tab-pane" id="tabs1-pane4">

			<div class="accordion" id="accordion5">
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseOneControl">
			        What is the Control Panel for?
			      </a>
			    </div>
			    <div id="collapseOneControl" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <p>The <b>Control Panel</b> tab includes many useful tools for reporting.</p>
                    
                    <ul>
                    <li>Activity Log - Contains activity information per user. The log is separated by activity relating to stories and activity not related to stories.</li>
                    <li>Issue Options - This area provides access to add, edit, or deactivate issues at any time.</li>
                    <li>Topic Options - This area provides access to add, edit, or deactivate topics at any time.</li>
                    <li>Download Reports - The prepared reports are found within this area. The reports are in Excel format.</li>
                    <li>Work List - Access the <i>Work List</i> at any time.</li>
                    <li>Edit Roles - Change the News Coordinator, News Assistant, and MMU Administrator as needed.</li>
                    <li>Manage Users - Add, change, or edit News Database users.</li>
                    </ul>
                    
			      </div>
			    </div>
			  </div> <!--end of "Why" in Control Panel-->  
          
              
                 <!--start a new help segment, "Issue and Topic Options", in Control Panel-->              
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseTwoIssue">
			        How do I add, edit, or deactivate an issue or topic
                    ?
			      </a>
			    </div>
			    <div id="collapseTwoIssue" class="accordion-body collapse">
			      <div class="accordion-inner">

			        <p>Everyone has access to add, edit, or deactivate an issue. Just check with the News coordinator before making a change.</p><p>The following procedure is exactly the same for <i>issues</i> and <i>topics</i>. The directions will show examples from the <i>Issue Options</i> area.</p>
                    <ul>
                    <li>Add a new issue - Type the new issue/topic into the field and press the "Add" button. The database will look for any issues or topics that match the issue/topic you typed in. The new issue will be added to the list if not match is found.<br />

                   
<Input type ="image" src="img/help/issues_sm.jpg" name="Add Issue" width="250" height="58" alt="issueAdd" class="img-rounded" onClick="window.open('img/help/issues.jpg','mywindow','width=500,height=325,top=200,screenX=100,screenY=100')"><br /><br />
                    </li>                     
                    
                    <li>Edit an issue/topic - Make the necessary changes to the existing issue/topic. Once you are satisfied, press the "Edit" button. The changes will be reflected within any news release associated to the issue/topic.<br />
                    
<INPUT type ="image" src="img/help/issuesEdit_sm.jpg" name="Edit Issue" width="300" height="67" alt="issueEdit" class="img-rounded" onClick="window.open('img/help/issuesEdit.jpg','mywindow','width=600,height=325,top=200,screenX=100,screenY=100')"><br /><br />                    
                    </li>   
                                        
                    <li>Delete ("hide") an issue/topic - Press the red "x" button to the right of the issue/topic to remove from the activated list of issues/topics. The deactivated issue/topic will be added to the <b>Deleted Issues</b> list.<br />
                    
<INPUT type ="image" src="img/help/issuesDelete_sm.jpg" name="Delete Issue" width="250" height="39" alt="issueAdd" class="img-rounded" onClick="window.open('img/help/issuesDelete.jpg','mywindow','width=500,height=325,top=200,screenX=100,screenY=100')"><br /><br />   

<p>Below is an example of a successful change to the issues/topics list.
<br />
<INPUT type ="image" src="img/help/issuesSuccess_sm.jpg" name="Success Notification" width="150" height="33" alt="issueSuccess" class="img-rounded" onClick="window.open('img/help/issuesSuccess.jpg','mywindow','width=500,height=325,top=200,screenX=100,screenY=100')"></p>
                    </li>                       
                    
                   <li>Activate a deleted issue/topic - Find the deleted issue/topic and press the green checkmark button to reactivate.<br />

<INPUT type ="image" src="img/help/issuesActive_sm.jpg" name="Activate Issue" width="225" height="68" alt="issueActive" class="img-rounded" onClick="window.open('img/help/issuesActive.jpg','mywindow','width=500,height=325,top=200,screenX=100,screenY=100')"> <br />                  </li>                    
                       
                    </ul>

			      </div>
			    </div>
			  </div> <!--end of "Issue Options" in Control Panel-->


                 <!--start a new help segment, "Reports", in Control Panel-->    
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseThreeReport">
			        Where are reports located and who can pull reports?
			      </a>
			    </div>
			    <div id="collapseThreeReport" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <p>Anyone with permission to work in the News Database may pull reports.</p>
                    
                    <ul>
                    <li>Find the report within the <i>Download Reports</i> area.</li>
                    <li>Press the "Download Reports" button.</li>
                    </ul>
                    
                    <p>Your report will download to an Excel format. From there, you can sort and filter within the Excel software application.</p>
                      <p>&diams; Please Note: Report functionality will evolve with future versions of this database.</p>
                    
			      </div>
			    </div>
			  </div> <!--end of "Reports" in Control Panel-->       
              
              
                 <!--start a new help segment, "Work List", in Control Panel-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseFourIncludeWL">
			        What is included in the Work List document?
			      </a>
			    </div>
			    <div id="collapseFourIncludeWL" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>The <i>Work List</i> provides information for M&M, the News coordinator, or anyone interested in the upcoming news releases.</p>
                    <p>The <i>Work List</i> document is sorted by "Reach" and includes the following information:</p>
			        <ul>
			        	<li>Filename - "NiyogiWeather" for example.</li>
			        	<li>Source - the name of the source.</li>
			        	<li>Writer - the writer's name.</li>
                        <li>Intent - story summary.</li>
                        <li>Publish Date - the goal date to publish the story.</li>
                        <li>Multimedia Information - include this information if the news release has an accompanying photo, video, graphic, or audio component.</li>
                        <li>Reach - Options include: State, Midwest, National, Global, or Development (no reach assigned).</li>
                        
			        </ul>
                    
                    <INPUT type ="image" src="img/help/workList_sm.jpg" name="work list" width="250" height="133" alt="workList" class="img-rounded" onClick="window.open('img/help/workList.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    

			      </div>
			    </div>
			  </div>  <!--end of Work List in Control Panel-->
               
              
                 <!--start a new help segment, "Edit Roles", in Control Panel-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseFiveRole">
			        What are the different roles within the News Database?
			      </a>
			    </div>
			    <div id="collapseFiveRole" class="accordion-body collapse">
			      <div class="accordion-inner">

                    <p>There are three roles that may be edited at any time. Pick a name from the dropdown list and press the green checkmark button to secure your choice.</p>
			        <ul>
			        	<li>Coordinator - Notifications are emailed to the News Unit Coordinator anytime the status is changed to "Coordinator Review". Update this field if the coordinator changes contact information or if someone else takes over the coordinator review process.</li>
			        	<li>News Assistant - The News Assistant Role receives an email update when stories are progressed to the "M&M Review" status prompting them to log in, update the story URL, and publish the story.</li>
			        	<li>MMU Administrator - The MMU Administrator is the Multimedia contact for this website. All help emails will be sent to this person..</li>                                                
			        </ul>
                    
                    <INPUT type ="image" src="img/help/updateRoles_sm.jpg" name="update roles" width="250" height="99" alt="roles" class="img-rounded" onClick="window.open('img/help/updateRoles.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    

			      </div>
			    </div>
			  </div>  <!--end of Edit Roles in Control Panel-->             
               
              
                 <!--start a new help segment, "Manage Users", in Control Panel-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseSixManage">
			        How do we give someone access to the News Database?
			      </a>
			    </div>
			    <div id="collapseSixManage" class="accordion-body collapse">
			      <div class="accordion-inner">
                   
			        <ul>
                        <li>Enter the <b>Control Panel</b> tab.</li>
                        <li>Find, and click on, the <i>Manage Users</i> button.</li>
			        	<li>Click on the "Add User" button to give access to the News database.</li>                                           
			        </ul>
                    
                    <INPUT type ="image" src="img/help/manageUsers_sm.jpg" name="update roles" width="250" height="76" alt="roles" class="img-rounded" onClick="window.open('img/help/manageUsers.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    

			      </div>
			    </div>
			  </div>  <!--end of Manage Users in Control Panel-->   
               
              
                 <!--start a new help segment, "Edit Users", in Control Panel-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseSevenEdit">
			        How do we update a user's information? 
			      </a>
			    </div>
			    <div id="collapseSevenEdit" class="accordion-body collapse">
			      <div class="accordion-inner">
                   
			        <ul>
                        <li>Enter the <b>Control Panel</b> tab.</li>
                        <li>Find, and click on, the <i>Manage Users</i> button.</li>
			        	<li>Click on a name to enter the edit zone.</li>			        	                                           
			        </ul>
                    
                    <INPUT type ="image" src="img/help/manageUsers_sm.jpg" name="update roles" width="250" height="76" alt="roles" class="img-rounded" onClick="window.open('img/help/manageUsers.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    

			      </div>
			    </div>
			  </div>  <!--end of Edit Users in Control Panel-->       
               
              
                 <!--start a new help segment, "Edit Zone", in Control Panel-->  
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseEightZone">
			        What user information may I edit? 
			      </a>
			    </div>
			    <div id="collapseEightZone" class="accordion-body collapse">
			      <div class="accordion-inner">
                   <p>The edit screen is shown below.<br />
                   You may edit:</p> 
			        <ul>
                        <li>The first and last name.</li>
                        <li>The user's Alias (username).</li>
			        	<li>The phone number on file.</li>
                        <li>The user's contact email.</li>
                        <li>The "Staff Role" - most users will have just one role. You may check more than one role. 	
			        </ul>
                    
                      <p>&diams; Be sure to click on a blue "Update User" button to save the entered information.</p>
                    
                    <INPUT type ="image" src="img/help/editUser_sm.jpg" name="edit user" width="225" height="117" alt="editUser" class="img-rounded" onClick="window.open('img/help/editUser.jpg','mywindow','width=1150,height=750,top=100,screenX=100,screenY=100')">                    
			      </div>
			    </div>
			  </div>  <!--end of Edit Zone in Control Panel-->                  
    
			</div>                            
		 </div>    <!--end of Control Panel help section TAB-->
    
    
         
    			<!--start the Quick FAQs tab-->            
          <div class="tab-pane" id="tabs1-pane5">
             <div class="accordion" id="accordion6">
			  <div class="accordion-group">
			  
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseOneFAQ">
			        Why do we need a new database?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseOneFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        
			        <p>The previous database is outdated. We could not track current critical issues and we could not easily access historical information.</p>
                
                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->    
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group">
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseTwoFAQ">
			        How does this new News database benefit me?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseTwoFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <ul>
			        <li>Work lists do not need to be sent to your coordinator. Work lists are created behind the scenes and readily available at any time.</li>
                    <li>You can access your story anywhere Internet is available.</li>
                    <li>If you are unexpectedly out of the office, your colleagues can keep your story moving forward if need be.</li>
                    </ul>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->          
        
                                               
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseThreeFAQ">
			        Why write the story in the database instead of Word?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseThreeFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <ul>
			        <li>You can access your story anywhere Internet is available. </li>
                    <li>This process minimizes passing documents through email. The story will stay in one place through the writing and editing process.</li>
                    </ul>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->      
                                
                                
                <!--start a new help segment, "Home vs. News Stories", in Quick FAQs-->
			  <div class="accordion-group">
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseHomeFAQ">
			        What is the difference between the <b>Home</b> tab and the <b>News Stories</b> tab?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseHomeFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <ul>
			        <li>The <b>Home</b> tab is customized to present only the stories for the person currently logged in.</li>
                    <li>The <b>Home</b> tab shows the most recent activity.</li>
                    </ul>
                    <p>Both the <b>Home</b> tab and the <b>News Stories</b> tab provide tools to:
                    <ul>
                    <li>View where the story is in the workflow process.</li>
                    <li>Delete the story.</li>
                    <li>Edit the story.</li>
                    <li>Search the database for the story filename.</li>
                    <li>Add a new story.</li>
                    </ul>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                      
                    
                    
                            
              
                <!--start a new help segment, "Icon help", in Quick FAQs-->
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseIconFAQ">
			        Icon Definitions</b>
			      </a>
			    </div>
			    <div id="collapseIconFAQ" class="accordion-body collapse">
			      <div class="accordion-inner">
                
                   <p><b>Add Story Icon Definitions</b></p>
                   <ul>
                   <li>Show More Fields - This will open more fields. Choose this icon if more than one answer is applicable.<br />
                   <INPUT type ="image" src="img/help/iconsField.jpg" name="More fields icon" width="136" height="66" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsField.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                   </li>
<br />
                   <li>New Source Profile - Choose this icon if a new source must be added to the database. <br />
                   <INPUT type ="image" src="img/help/iconsSource.jpg" name="Add a source icon" width="136" height="67" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsSource.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                 </li>        
<br />           
                    <li>Calendar - Choose this icon to open the calendar window. The <i>Publish Date</i> must be chosen via the calendar option. <br />
                   <INPUT type ="image" src="img/help/iconsCalendar.jpg" name="Calendar icon" width="137" height="65" alt="openFields" class="img-rounded" onClick="window.open('img/help/iconsCalendar.jpg','mywindow','width=175,height=100,top=200,screenX=100,screenY=100')">
                   </li>  
                   </ul>   
                   <br />
                
                   <p><b>Home and News Stories Icon Definitions</b></p>  
                   <ul>                 
                    <li>Story Workflow Status: <b>Published</b> - This icon is found to the left of the story headline/filename. Hover over this icon to see the status of the story. This news story will not be highlighted.
                    <br />
                   <INPUT type ="image" src="img/help/iconsStatus.jpg" name="Status icon" width="213" height="84" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsStatus.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">
                   </li>          <br /> 
                   <li>Story Workflow Status: <b>Approval</b> - This icon is found to the left of the story headline/filename. This icon quickly helps the viewer to know the story is waiting on approval from the coordinator, M&M, or the source. Hover over this icon to see why the story is highlighted in yellow. 
                    <br />
                   <INPUT type ="image" src="img/help/iconsApproval.jpg" name="Status icon" width="203" height="90" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsApproval.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">
                   </li>          <br /> 
                   <li>Story Workflow Status: <b>Writer</b> - This icon is found to the left of the story headline/filename. This icon quickly helps the viewer to know the story is waiting on the writer to do something with the story. Hover over this icon to see why the story is highlighted in pink. 
                    <br />
                   <INPUT type ="image" src="img/help/iconsWriter.jpg" name="Status icon" width="211" height="101" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsWriter.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">
                   </li>          <br /> 
                    <li>Edit the story - This icon is found to the right of the story headline/filename. Click this icon to edit the story. <br />
                   <INPUT type ="image" src="img/help/iconsEdit.jpg" name="Status icon" width="213" height="84" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsEdit.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">
                   </li>          <br />  
                    <li>Delete the story - This icon is found to the right of the story headline/filename. Click this icon to delete the story. <br />
                   <INPUT type ="image" img src="img/help/iconsDelete.jpg" name="Status icon" width="213" height="84" alt="storyStatus" class="img-rounded" onClick="window.open('img/help/iconsDelete.jpg','mywindow','width=300,height=125,top=200,screenX=100,screenY=100')">
                   </li>          <br />                               
                                                      
                   </ul>
     
			      </div>
			    </div>
			  </div> <!--end icon help in Quick FAQs-->    
                                               
                                        
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseFourFAQ">
			        Can I copy/paste from Word or from other applications into the News Database editor?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseFourFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>Yes you can. You may copy and paste directly into the News Database editor.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                 
                                                 
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseFiveFAQ">
			        What do I need to know before entering a news release in the database?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseFiveFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>All you need is the <strong>filename</strong> of the news release. <br />You can edit the story as many times as you need to. <br />You can enter information at any point during the process.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                     
 
                 
                <!--start a new help segment, "Work List", in Quick FAQs-->      
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSixFAQ">
			        When is my story added to the Work List?
			      </a>
			    </div>
			    <div id="collapseSixFAQ" class="accordion-body collapse">
			      <div class="accordion-inner">
			        
			        <p>In order for the story to be sent to M&M in the <i>Work List</i>, the story will need</p>
			        <ul>
			        	<li>Filename</li>
			        	<li>Writer (at least one)</li>
			        	<li>Intent</li>
			        </ul>

			        <p><span class="label label-important">Important</span> If you have entered a story that does not contain all four of these fields, the story will not be sent in the <i>Work List</i> to M&M; however, it will be saved in the database for you to update at a later time.</p>
			     
			      </div>
			    </div>
			  </div>
                <!--end new help segment in Quick FAQs-->                                                        
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSixFAQ">
			        Do I need to be on campus to access the database?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseSixFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>No. You can access your story anywhere Internet is available.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                       
                                                 
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSevenFAQ">
			        Do I enter any story in this database or just news releases?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseSevenFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>You enter only the news releases in this database.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                         
                                                 
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseEightFAQ">
			        Who has access to the database?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseEightFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>The entire News unit has access to the News database.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->         
                                                 
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseNineFAQ">
			       Who do I ask when I need help?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseNineFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>Please contact <a href="https://dev.www.purdue.edu/agnewsdb/contactHelp.php" title="Help Desk">Multimedia</a> for help.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->                         
                                                  
                    
                                   
                <!--start a new help segment in Quick FAQs-->
			  <div class="accordion-group"> 
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseTenFAQ">
			       Can I access a coworker's news release?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseTenFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
			        <p>Yes you can.</p>

                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end help segment in Quick FAQs-->                  
                                     

                <!--start a new help segment, "Field Completion", in Quick FAQs-->
			  <div class="accordion-group">
                <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseFieldFAQ">
			        Do I need to provide information for every field?
			      </a>
                </div><!--end accordion-heading-->
			    <div id="collapseFieldFAQ" class="accordion-body collapse">
                  <div class="accordion-inner">
               <p>Yes. Before you finalize your story and send it away to M&M, please be sure to fill in the information requested.</p>


                  </div><!--end accordion-inner-->          
			    </div><!--end accordian-body collapse-->
			  </div><!--end accordion-group-->
                <!--end new help segment in Quick FAQs-->  
          
          
             </div><!--end accordian class-->
          </div><!--end tab-pane-paneFAQ->             <!--end Quick FAQs tab-->        
                                             


        <!--start a new help tab: Contact Help-->    
		<div class="tab-pane" id="tabs1-pane6">
			<div class="accordion" id="accordion7">
            
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle"  data-parent="#accordion7" href="contactHelp.php">
			        Help Contact Form
			      </a>
			    </div>
			    <div id="collapseOne6" class="accordion-body collapse">
			      <div class="accordion-inner">
		      	
			      </div>
			    </div>
			  </div>
 
                 <!--start a new help segment, "email help", in Contact Help-->             
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion7" href="#collapseTwoHelp">
			        How do I know that someone received my help e-mail?
			      </a>
			    </div>
			    <div id="collapseTwoHelp" class="accordion-body collapse">
			      <div class="accordion-inner">
			       <p> The system dynamically updates the Multimedia Unit contact so that it is always current. If you would like to follow up with a message you sent and have not heard back on, contact MMU directly.</p>
			      </div>
			    </div>
			  </div>   <!--end of help email in Work List-->

		
            </div>
          </div>  <!--end Contact Help TAB -->
       
        
   
      </div><!-- /.tab-content -->    
    
</div><!-- end tabbable -->






<script type="javascript">
$(".collapse").collapse()
</script>
<?php 

include_once("includes/footer.php");

?>