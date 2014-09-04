//<?php
/**
 * WelcomeListBox
 *
 * Additional Dashboard List Documents box widget for EvoDashboard
 *
 * @author    Nicola Lambathakis
 * @category    plugin
 * @version    1.1 RC
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @internal    @properties  &ListBoxEvoEvent= List Box placement:;list;OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender;OnManagerWelcomeHome &ListBoxSize= List Box size:;list;dashboard-block-full,dashboard-block-half;dashboard-block-half &ListMode= List Box mode:;list;basic,advanced;advanced &ListBoxTitle=Edit List documents Title:;string;List Box Widget &ParentFolder=Parent folder for List documents:;string;2 &ListItems=Max items in List:;string;20 &hideFolders= Hide Folders from List:;list;yes,no;no &dittolevel= Depht:;string;1
 */

/******
WelcomeListBox 1.0 RC
OnManagerWelcomeHome,OnManagerWelcomeRender

&ListBoxEvoEvent= List Box placement:;list;OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender;OnManagerWelcomeHome &ListBoxSize= List Box size:;list;dashboard-block-full,dashboard-block-half;dashboard-block-half &ListMode= List Box mode:;list;basic,advanced;advanced &ListBoxTitle=Edit List documents Title:;string;List Box Widget &ParentFolder=Parent folder for List documents:;string;2 &ListItems=Max items in List:;string;20 &hideFolders= Hide Folders from List:;list;yes,no;no &dittolevel= Depht:;string;1
****
*/
//blocks
$ListOutput = isset($ListOutput) ? $ListOutput : '';
//events
$ListBoxEvoEvent = isset($ListBoxEvoEvent) ? $ListBoxEvoEvent : 'OnManagerWelcomeRender';
// box size
$ListBoxSize = isset($ListBoxSize) ? $ListBoxSize : 'dashboard-block-full';
$output = "";
$e = &$modx->Event;

/*List documents box*/
if($e->name == ''.$ListBoxEvoEvent.'') {
$parentId = $ParentFolder;
$dittototal = $ListItems;
	if ($ListMode == advanced) {
$rowTpl = '@CODE: <li><a href="[(site_url)]index.php?id=[+id+]" target="_blank" title="preview"><i class="fa fa-eye green2"></i></a> <a href="index.php?a=27&id=[+id+]" title="edit"><i class="fa fa-pencil-square-o red2"></i></a> <a href="index.php?a=51&id=[+id+]" title="move"><i class="fa fa-arrows blueberry"></i></a> <a href="index.php?a=62&id=[+id+]" title="unpublish"><i class="fa fa-square-o blueberry"></i></a> <a href="index.php?a=6&id=[+id+]" title="delete"><i class="fa fa-trash-o red2"></i></a> <b>[+pagetitle+]</b> ([+id+])</li>';
}
	if ($ListMode == basic) {
$rowTpl = '@CODE: <li><a href="[(site_url)]index.php?id=[+id+]" target="_blank" title="preview"><i class="fa fa-eye green2"></i></a> <a href="index.php?a=27&id=[+id+]" title="edit"><i class="fa fa-pencil-square-o red2"></i></a> <b>[+pagetitle+]</b> ([+id+])</li>';
}
$outerTpl = '@CODE: [+wf.wrapper+]';
// Ditto parameters
$params['parents'] = $parentId;
$params['depth'] = $dittolevel;
$params['tpl'] = $rowTpl;
$params['total'] = $dittototal;
if ($hideFolders == yes) {
$params['hideFolders'] = '1';
}
	if ($hideFolders == no) {
$params['hideFolders'] = '0';
}
// run Ditto
$list = $modx->runSnippet('Ditto', $params);
$ListOutput = '<div class="'.$ListBoxSize.'"><div class="sectionHeader"><i class="fa fa-pencil"></i> '.$ListBoxTitle.'<a href="javascript:void(null);" onclick="doHideShow(\'idShowHideListBoxWidget2\');"><i class="fa fa-bars expandbuttn"></i></a></div>
<div id="idShowHideListBoxWidget2" class="dashboard-block-content sectionBody"><ul>'.$list.'</ul><br style="clear:both;height:1px;margin-top: -1px;line-height:1px;font-size:1px;" /> </div></div>';
}
//end list
$output = $ListOutput;
$e->output($output);
return;