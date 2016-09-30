<?php
/******
WelcomeDocumentsListBox 3.1 RC
 * 
&WidgetTitle= Widget title:;string;List Documents &WidgetIcon= Widget Icon:;string;fa-pencil &ListMode= List Box mode:;list;basic,advanced;advanced &ParentFolder=Parent folder for List documents:;string;2,15 &ListItems=Max items in List:;string;20 &tablefields= Tv Fields:;string;[+longtitle+],[+description+],[+introtext+],[+documentTags+] &tableheading=TV  heading:;string;Long Title,Description,Introtext,Tags &hideFolders= Hide Folders:;list;yes,no;yes &showPublishedOnly= Show Published Only:;list;yes,no;no &dittolevel= Depht:;string;1 &showMoveButton= Show Move Button:;list;yes,no;yes &showPublishButton= Show Publish Button:;list;yes,no;yes &showDeleteButton= Show Delete Button:;list;yes,no;yes &datarow= widget row position:;list;1,2,3,4,5,6,7,8,9,10;2 &datacol= widget col position:;list;1,2,3,4;1 &datasizex= widget x size:;list;1,2,3,4;2 &datasizey= widget y size:;list;1,2,3,4,5,6,7,8,9,10;4 &WidgetID= Unique Widget ID:;string;DocListBox 


****
*/
//widget name
$WidgetID = isset($WidgetID) ? $WidgetID : 'DocListBox';
$WidgetIcon = isset($WidgetIcon) ? $WidgetIcon : 'fa-pencil';
// size and position
$datarow = isset($datarow) ? $datarow : '1';
$datacol = isset($datacol) ? $datacol : '1';
$datasizex = isset($datasizex) ? $datasizex : '2';
$datasizey = isset($datasizey) ? $datasizey : '2';
//output
$WidgetOutput = isset($WidgetOutput) ? $WidgetOutput : '';
//events
$EvoEvent = isset($EvoEvent) ? $EvoEvent : 'OnManagerWelcomeHome';

$tablefields = isset($tablefields) ? $tablefields : '[+longtitle+],[+description+],[+introtext+],[+documentTags+]';
$tableheading = isset($tableheading) ? $tableheading : 'Long Title,Description,Introtext,Tags';


//get Tv vars Heading Titles from Module configuration (ie: Page Title,Description,Date)
//get Tv vars fields from Plugin configuration (ie: [+pagetitle+],[+description+],[+date+])

$tharr = explode(",","$tableheading");
$tdarr = explode(",","$tablefields");
foreach (array_combine($tharr, $tdarr) as $thval => $tdval){
    $thtdfields .=  "
    <li><b>" . $thval . "</b>: " . $tdval . "</li>
    ";
}

$output = "";
$e = &$modx->Event;

/*List documents box*/
if($e->name == ''.$EvoEvent.'') {
$parentId = $ParentFolder;
$dittototal = $ListItems;
	if ($ListMode == advanced) {
$rowTpl = '@CODE: <tr>
<td data-toggle="collapse" data-target=".collapse'.$WidgetID.'[+id+]"> <span class="label label-info">[+id+]</span></td>
<td><a class="[[if? &is=`[+published+]:=:0` &then=`unpublished`]]" href="index.php?a=27&id=[+id+]" title="edit">[+pagetitle+]</a></td>
<td>[+date+]</td>
<td style="text-align: right;">
<a class="btn btn-xs btn-success btn-action" href="index.php?a=27&id=[+id+]" title="edit"><i class="fa fa-pencil-square-o icon-color-red icon-no-border"></i></a> 
<a class="btn btn-xs btn-info btn-action" href="[(site_url)]index.php?id=[+id+]" target="_blank" title="preview"><i class="fa fa-eye icon-color-light-green icon-no-border"></i></a>
';
if ($showMoveButton == yes) { 
$rowTpl .= '<a class="btn btn-xs btn-move btn-action" href="index.php?a=51&id=[+id+]" title="move"><i class="fa fa-arrows icon-color-blue icon-no-border"></i></a>';
}
if ($showPublishButton == yes) { 
$rowTpl .= '[[if? &is=`[+published+]:=:1` &then=` 
<a class="btn btn-xs btn-warning btn-action" href="index.php?a=62&id=[+id+]" title="unpublish"><i class="fa fa-arrow-down icon-color-grey icon-no-border"></i></a> 
`&else=`
<a class="btn btn-xs btn-primary btn-action" href="index.php?a=62&id=[+id+]" title="publish"><i class="fa fa-arrow-up icon-color-grey icon-no-border"></i></a> 
`]]';
}
 
if ($showDeleteButton == yes) { 
$rowTpl .= '<a class="btn btn-xs btn-danger btn-action" href="index.php?a=6&id=[+id+]" title="delete"><i class="fa fa-trash-o icon-color-red icon-no-border"></i></a> ';
}

$rowTpl .= '<button class="btn btn-xs btn-default btn-expand btn-action" title="' . $_lang["resource_overview"] . '" data-toggle="collapse" data-target=".collapse'.$WidgetID.'[+id+]"><i class="fa fa-info" aria-hidden="true"></i></button></td>

</tr>
<tr><td colspan="4" class="hiddenRow"><div class="resource-overview-accordian collapse collapse'.$WidgetID.'[+id+]"><div class="overview-body small"><ul>        
'.$thtdfields.'

</ul>
</td>
</tr>
';
}
	if ($ListMode == basic) {
$rowTpl = '@CODE: <tr>
<td width="5%"><a href="[(site_url)]index.php?id=[+id+]" target="_blank" title="preview"><i class="fa fa-eye green2"></i></a></td>
<td width="5%"><a href="index.php?a=27&id=[+id+]" title="edit"><i class="fa fa-pencil-square-o icon-color-red icon-no-border"></i></a> </td>
<td><b>[+pagetitle+]</b> ([+id+])</td>
</tr>';
}
// Ditto parameters
$params['parents'] = $parentId;
$params['depth'] = $dittolevel;
$params['tpl'] = $rowTpl;
$params['total'] = $dittototal;
$params['showPublishedOnly'] = $showPublishedOnly;
if ($showPublishedOnly == yes) {
$params['showPublishedOnly'] = '1';
}
	if ($showPublishedOnly == no) {
$params['showPublishedOnly'] = '0';
}
if ($hideFolders == yes) {
$params['hideFolders'] = '1';
}
	if ($hideFolders == no) {
$params['hideFolders'] = '0';
}
// run Ditto
$list = $modx->runSnippet('Ditto', $params);

$WidgetOutput = '
 <!--- doclist widget--->
 <style>
 .btn-move{background-color: #CC99FF;}
 .btn-move:hover{background-color: #B266FF; color: #FFF;}
 #'.$WidgetID.' > .resource-overview-accordian {border:0;padding:0;}
 </style>
 <li id="'.$WidgetID.'" data-row="'.$datarow.'" data-col="'.$datacol.'" data-sizex="'.$datasizex.'" data-sizey="'.$datasizey.'">
                    <div class="panel panel-default widget-wrapper">
                    
                      <div class="panel-headingx widget-title sectionHeader clearfix">
                          <span class="pull-left"><i class="fa '.$WidgetIcon.'"></i> '.$WidgetTitle.'</span>
                            <div class="widget-controls pull-right">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-default btn-xs panel-hide hide-full glyphicon glyphicon-minus" data-id="'.$WidgetID.'"></a>
                                </div>     
                            </div>
                      </div>
                      
                      <div class="panel-body widget-stage sectionBody">
     <table class="table table-hover table-condensed">'.$list.'</table>
                      </div>
                    </div>   
         
                </li>
<!--- /doclist widget---> 

';
}
//end widget
$output = $WidgetOutput;
$e->output($output);
return;
?>