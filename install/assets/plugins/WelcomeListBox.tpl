//<?php
/**
 * WelcomeListResourcesBox
 *
 * Dashboard List Resources box widget for EvoDashboard and Evo 1.2
 *
 * @author    Nicola Lambathakis
 * @category    plugin
 * @version    3.1 PL
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events  OnManagerWelcomePrerender
 * @internal    @installset base
 * @internal    @disabled 1
 * @internal    @modx_category Dashboard
 * @internal    @properties  &WidgetTitle= Widget title:;string;List Documents &WidgetIcon= Widget Icon:;string;fa-pencil &ParentFolder=Parent folder for List documents:;string;2,15 &ListItems=Max items in List:;string;20 &tablefields= Tv Fields:;string;[+longtitle+],[+description+],[+introtext+],[+documentTags+] &tableheading=TV  heading:;string;Long Title,Description,Introtext,Tags &hideFolders= Hide Folders:;list;yes,no;yes &showPublishedOnly= Show Published Only:;list;yes,no;no &dittolevel= Depht:;string;1 &showMoveButton= Show Move Button:;list;yes,no;yes &showPublishButton= Show Publish Button:;list;yes,no;yes &showDeleteButton= Show Delete Button:;list;yes,no;yes &datarow= widget row position:;list;1,2,3,4,5,6,7,8,9,10;2 &datacol= widget col position:;list;1,2,3,4;1 &datasizex= widget x size:;list;1,2,3,4;2 &datasizey= widget y size:;list;1,2,3,4,5,6,7,8,9,10;4 &WidgetID= Unique Widget ID:;string;DocListBox
 */

/******
WelcomeListResourcesBox 3.1 PL
 OnManagerWelcomePrerender

&WidgetTitle= Widget title:;string;List Documents &WidgetIcon= Widget Icon:;string;fa-pencil &ParentFolder=Parent folder for List documents:;string;2,15 &ListItems=Max items in List:;string;20 &tablefields= Tv Fields:;string;[+longtitle+],[+description+],[+introtext+],[+documentTags+] &tableheading=TV  heading:;string;Long Title,Description,Introtext,Tags &hideFolders= Hide Folders:;list;yes,no;yes &showPublishedOnly= Show Published Only:;list;yes,no;no &dittolevel= Depht:;string;1 &showMoveButton= Show Move Button:;list;yes,no;yes &showPublishButton= Show Publish Button:;list;yes,no;yes &showDeleteButton= Show Delete Button:;list;yes,no;yes &datarow= widget row position:;list;1,2,3,4,5,6,7,8,9,10;2 &datacol= widget col position:;list;1,2,3,4;1 &datasizex= widget x size:;list;1,2,3,4;2 &datasizey= widget y size:;list;1,2,3,4,5,6,7,8,9,10;4 &WidgetID= Unique Widget ID:;string;DocListBox
****
*/
// Run the main code
include($modx->config['base_path'].'assets/plugins/welcomelistbox/listbox.php');