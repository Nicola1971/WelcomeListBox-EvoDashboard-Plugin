<?php
/******
WelcomeDocumentsListBox 3.1.3 RC
 * 
&wdgVisibility=Show widget for:;menu;All,AdminOnly;show &WidgetTitle= Widget title:;string;List Documents &WidgetIcon= Widget Icon:;string;fa-pencil &ParentFolder=Parent folder for List documents:;string;2,15 &ListItems=Max items in List:;string;20 &tablefields= Tv Fields:;string;[+longtitle+],[+description+],[+introtext+],[+documentTags+] &tableheading=TV  heading:;string;Long Title,Description,Introtext,Tags &hideFolders= Hide Folders:;list;yes,no;yes &showPublishedOnly= Show Published Only:;list;yes,no;no &dittolevel= Depht:;string;1 &showMoveButton= Show Move Button:;list;yes,no;yes &showPublishButton= Show Publish Button:;list;yes,no;yes &showDeleteButton= Show Delete Button:;list;yes,no;yes &datarow= widget row position:;list;1,2,3,4,5,6,7,8,9,10;2 &datacol= widget col position:;list;1,2,3,4;1 &datasizex= widget x size:;list;1,2,3,4;2 &datasizey= widget y size:;list;1,2,3,4,5,6,7,8,9,10;4 &WidgetID= Unique Widget ID:;string;DocListBox 


****
*/
// get manager role
$role = $_SESSION['mgrRole'];          
if(($role!=1) AND ($wdgVisibility == 'AdminOnly')) {}
else {
// get language
global $modx,$_lang;
// get plugin id
$result = $modx->db->select('id', $this->getFullTableName("site_plugins"), "name='{$modx->event->activePlugin}' AND disabled=0");
$pluginid = $modx->db->getValue($result);
if($modx->hasPermission('edit_plugin')) {
$button_pl_config = '<a data-toggle="tooltip" title="' . $_lang["settings_config"] . '" href="index.php?id='.$pluginid.'&a=102" class="btn panel-setting"><i class="fa fa-cog"></i> </a>';
}
$modx->setPlaceholder('button_pl_config', $button_pl_config);
    
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
if($e->name == 'OnManagerWelcomePrerender') {
$parentId = $ParentFolder;
$dittototal = $ListItems;
$rowTpl = '@CODE: <tr>
<td data-toggle="collapse" data-target=".collapse'.$WidgetID.'[+id+]"> <span class="label label-info">[+id+]</span></td>
<td><a class="[[if? &is=`[+published+]:=:0` &then=`unpublished`]]" href="index.php?a=27&id=[+id+]" title="edit">[+pagetitle+]</a></td>
<td class="text-right text-nowrap">[+date+]</td>
<td style="text-align: right;" class="actions">
<a href="index.php?a=27&id=[+id+]" title="edit"><i class="fa fa-pencil-square-o"></i></a> 
<a href="[(site_url)]index.php?id=[+id+]" target="_blank" title="preview"><i class="fa fa-eye"></i></a>
';
if ($showMoveButton == yes) { 
$rowTpl .= '<a href="index.php?a=51&id=[+id+]" title="move"><i class="fa fa-arrows"></i></a>';
}
if ($showPublishButton == yes) { 
$rowTpl .= '[[if? &is=`[+published+]:=:1` &then=` 
<a href="index.php?a=62&id=[+id+]" title="unpublish"><i class="fa fa-arrow-down"></i></a> 
`&else=`
<a href="index.php?a=62&id=[+id+]" title="publish"><i class="fa fa-arrow-up"></i></a> 
`]]';
}
 
if ($showDeleteButton == yes) { 
$rowTpl .= '<a href="index.php?a=6&id=[+id+]" title="delete"><i class="fa fa-trash-o"></i></a> ';
}

$rowTpl .= ' <a class="resource_overview" title="' . $_lang["resource_overview"] . '" data-toggle="collapse" data-target=".collapse'.$WidgetID.'[+id+]"><i class="fa fa-info" aria-hidden="true"></i></a></td>

</tr>
<tr><td colspan="4" class="hiddenRow"><div class="resource-overview-accordian collapse collapse'.$WidgetID.'[+id+]"><div class="overview-body"><ul>        
'.$thtdfields.'

</ul>
</td>
</tr>
';

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
  .btn-group .panel-setting {
  margin-top : -7px;
  background:transparent;
  border:none!important;
  outline: 0;
  color: #ccc!important;
}
.btn-group .panel-setting:hover {
  color: #444!important;
  border:none;
}
 div.overview-body {border:0;padding:0;border:none!important;}
.resource-overview-accordian {border:0;padding:3px 0 3px -5px;}
#wdg_'.$WidgetID.' .panel-body {padding:0;}
#wdg_'.$WidgetID.' .table.data tbody tr:not(:hover) { background-color: #fff }
#wdg_'.$WidgetID.' .table.data tbody tr:nth-child(4n+1):not(:hover) { background-color: #f6f8f8 }
#wdg_'.$WidgetID.' .table.data tbody tr:nth-child(2n) { background-color: #fff }
td.actions a{margin-right:3px;}
a.resource_overview {margin-left:3px;}
 </style>
 <li id="'.$WidgetID.'" data-row="'.$datarow.'" data-col="'.$datacol.'" data-sizex="'.$datasizex.'" data-sizey="'.$datasizey.'">
                    <div class="panel panel-default widget-wrapper card" id="wdg_'.$WidgetID.'">
                    
                      <div class="panel-headingx widget-title sectionHeader clearfix">
                          <span class="pull-left"><i class="fa '.$WidgetIcon.'"></i> '.$WidgetTitle.'</span>
                            <div class="widget-controls pull-right">
                                <div class="btn-group">
                                  '.$button_pl_config.'<a href="#" class="btn btn-default btn-xs panel-hide hide-full fa fa-minus" data-id="'.$WidgetID.'"></a>
                                </div>     
                            </div>
                      </div>
                      
                      <div class="panel-body widget-stage sectionBody card-block">
                      <div class="table-responsive">
				<table class="table data">
                <thead>
						<tr>
							<th style="width: 1%">[%id%]</th>
							<th>[%resource_title%]</th>
							<th style="width: 1%">[%page_data_edited%]</th>
							<th style="width: 1%; text-align: center">[%mgrlog_action%]</th>
						</tr>
					</thead>
                    <tbody>
'.$list.' </tbody></table></div>
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
}
?>