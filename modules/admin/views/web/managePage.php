<?php
/**
 * Parsimony
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@parsimony.mobi so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Parsimony to newer
 * versions in the future. If you wish to customize Parsimony for your
 * needs please refer to http://www.parsimony.mobi for more information.
 *
 * @authors Julien Gras et Benoît Lorillot
 * @copyright  Julien Gras et Benoît Lorillot
 * @version  Release: 1.0
 * @category  Parsimony
 * @package admin
 * @license    http://opensource.org/licenses/osl-3.0.php 
 *  Open Software License (OSL 3.0)
 */
?>
<SCRIPT LANGUAGE="Javascript" SRC="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js"> </SCRIPT>
<script>
    $(function() {
        $(document).on('click',".tabs li a",function(e){
            e.preventDefault();
            $(".panel").hide();
            $(".tabs ul .active").removeClass("active");
            $(this).parent().addClass("active");
            $($(this).attr('href')).show();
        });
    });
</script>
<style>
    table,th,thead,td{text-align:center;padding-top:8px;}
    table{width :100%}
    td{border: 1px solid #D3D5DB;padding: 13px 6px 0px;}   
    #tabs-admin-querieur{padding: 1px 20px 10px;box-shadow: 2px 1px 13px #777;}
    #tabs-admin-query{position:relative;text-align: left}
    .ui-icon-closethick{margin: 5px;border: #666 solid 1px;border-radius: 5px;margin: 0px auto}
    .modulecss{padding: 5px;list-style: none;border: 1px solid #99BBE8;background-color: #CBDDF3;text-transform: capitalize;}
    .modulecss a{text-decoration: none;color:#333;}
    .details{display:none;position:absolute;top:23px;z-index:1;background: rgba(255,255,255,0.8);width: 650px;overflow-x: scroll}
    .detailsCont{width: 1500px;}
    .entity{border-radius: 3px;background:#E8F4FF;border:1px solid #5E9AE2;margin:2px 2px;}
    .cent{width:100%;box-sizing:border-box;}
    td.type{cursor: move;}
    .entityname{padding:5px 4px;line-height: 20px;font-weight: bold;color: white;background: #5E9AE2;
				 background: -webkit-gradient(linear, left top, left bottom, from(#5E9AE2), to(#3570B8));
				 background: -moz-linear-gradient(top, #5E9AE2, #3570B8);}
    .property:hover{background:#CBDDF3}
    #recipiant_sql select{margin-bottom: 5px;margin-top: 5px;}
</style>
<div class="adminzone" id="adminformpage">

    <div id="admin_page" class="adminzonemenu">
        <div id="save_page" class="save"><a href="#" class="ellipsis"><?php echo t('Save', FALSE); ?></a></div>
        <div id="goto_page" class="adminzonetab"><a href="#" class="ellipsis"><?php echo t('See', FALSE); ?></a></div>
        <div id="delete_page" class="adminzonetab"><a href="#" class="ellipsis"><?php echo t('Delete', FALSE); ?></a></div>   
    </div>
    <div id="contentformpage"  class="adminzonecontent">
        <form class="form" target="ajaxhack" method="POST">
            <input type="hidden" name="TOKEN" value="<?php echo TOKEN; ?>" />
            <input type="hidden" name="id_page" value="<?php echo $page->getId(); ?>">
            <input type="hidden" name="action" value="savePage">
            <div class="tabs">
                <ul>
                    <li class="active"><a href="#tabs-1"><?php echo t('URL & Rewriting', FALSE); ?></a></li>
                    <li><a href="#tabs-2"><?php echo t('MetaData', FALSE); ?></a></li>
                </ul>
                <div class="clearboth" style="padding-top: 10px;"></div>
                <div id="tabs-1" class="panel">
                    <?php
                    echo '<input type="hidden" name="module" value="' . s($module->getName()) . '">';
                    ?>
                    <div class="placeholder">
                        <label for="title"><?php echo t('Title', FALSE); ?></label><input type="text" name="title" style="width:95%;" value="<?php echo s($page->getTitle()); ?>">
                    </div>
                    <div class="placeholder">
                        <label for="title"><?php echo t('URL', FALSE); ?></label><input type="text" id="patternurlregex" name="regex" style="width:540px;" value="<?php echo s(substr(substr($page->getRegex(), 1), 0, -1)); ?>">
                    </div>
                    <div style="top: 113px;position: absolute;left: 7px;text-overflow:ellipsis">
                        <span for="genereURL" style="font-size:11px"><?php echo t('URL Example', FALSE); ?> : </span><span id="totalurl">http://<?php echo $_SERVER['HTTP_HOST'] . BASE_PATH ?><span class="modulename"><?php $modulename = $module->getName();
                    if ($modulename != 'core') echo $modulename; ?></span><?php if ($modulename != 'core') echo '/'; ?><span id="patternurl" ><?php echo $page->getURL(); ?></span></span>
                    </div>
		    <?php if (BEHAVIOR == 2 ): ?>
                    <div style="top: 85px;position: absolute;left: 570px;color: #333;">
                        <a style="color: #333;line-height: 15px;text-decoration:none" href="#" onclick="$('#tabs-admin-querieur').toggle();return false;"><span style="position: relative;top: 0px;right: 4px;" class="parsiplusone floatleft"></span><?php echo t('Dynamic page', FALSE); ?></a>
                    </div>
		    <?php endif; ?>
                    <script type="text/javascript">
                        $('input[name="title"]').live('change keyup',function(){
                            genereregex();
                        });
                        $('#save_page').live('click',function(e){
                            e.preventDefault();
                            $('#conf_box input[name="action"]').val("savePage");
                            $('#sendFormPage').trigger('click');
                        });
                        $('#goto_page').live('click',function(e){
                            e.preventDefault();
                            parent.location = $('#totalurl').text();
                        });
                        $('#delete_page').live('click',function(e){
                            e.preventDefault();
                            var trad = t('Are you sure to delete this page ?');
                            if(confirm(trad)){
                                $('#adminformpage input[name="action"]').val("deleteThisPage");
                                $('#sendFormPage').trigger('click');
                            }
                        });
                        $('input[name="title"]').blur(function() {
                            if($('input[name="title"]').val().length >0 && $('input[name="regex"]').val().length == 0){
                                $('input[name="regex"]').addClass('active');
                                $.post(BASE_PATH + "admin/titleToUrl", {TOKEN: TOKEN ,url: $(this).val()},
                                function(data) {
                                    $('input[name="regex"]').val(data);
                                });
                            }
                        });
                        $(function() {
                            $("#schema_sql > div").hover(function() {
                                $("li",this).next().show();
                            },function() {
                                $("li",this).next().hide();
                            });
                            $(function() {
                                $( "table tbody" ).sortable({
                                    placeholder: "ui-state-highlight",
                                    stop:function(){
                                        genereregex();
                                    }
                                });
                                $( "table tbody" ).disableSelection();
                            });
                        });
                        $('#schema_sql .property').die('click');
                        $('#schema_sql .property').live('click', function(){
                            var obj = $('#abc').clone().attr('id','');
                            $(".parsiname input",obj).val($(this).attr('name'));
                            $(".regex input",obj).val($(this).attr('regex'));
                            $(".val input",obj).val($(this).attr('val'));
			    $(".modelProperty input",obj).val($(this).parent().attr("table") + "." + $(this).text());
                            obj.appendTo('table').show();
                            genereregex();
                        });
                        $('table tbody input').live('change keyup',function(){
                            genereregex();
                        });

                        $('#addparam').die('click');
                        $('#addparam').live('click', function(){
                            obj = $('#abc').clone();
                            obj.removeAttr("id");
                            $('.parsiname input',obj).val($('#paramname').val());
                            $('.regex input',obj).val($('#paramregex').val());
                            if($('#paramregex').val()=='(.*)') $('.val input',obj).val('abcd');
                            else $('.val input',obj).val('123');
                            obj.appendTo('table tbody').show();
                            $('#paramname').val('');
                            genereregex();
                        });
                        $('#addtextcomposant').die('click');
                        $('#addtextcomposant').live('click', function(){
                            $('#abcd').clone().removeAttr("id").appendTo('table tbody').show();
                            genereregex();
                        });

                        function genereregex(){
                            var url = '';
                            var urlRegex = '';
                            $('table tbody tr:not(#abc,#abcd)').each(function(i){
                                $("input",this).each(function(){
                                    $(this).attr("name","URLcomponents[" + i + "][" + $(this).parent().attr("class").replace("parsi","") +"]");
                                });
                                if($(this).hasClass('paramdyn')){
                                    url += $(".val input",this).val();
                                    urlRegex += "(\?<" + $(".parsiname input",this).val() + ">" + $(".regex input",this).val() + ')';
                                }else{
                                    url += $(".text input",this).val();
                                    urlRegex += $(".text input",this).val();
                                }
                            });
                            $("#patternurl").text(url);
                            $("#patternurlregex").val(urlRegex);
                            $(".showcomponent").show();
                        }
                    </script>

                    <div style="position:relative;padding-top: 30px;">
			<?php if (BEHAVIOR == 2 ): ?>
                        <div id="tabs-admin-querieur" class="none" style="">
                            <div id="tabs-admin-query" style="">
                                <h2><?php echo t('URL Rewriting', False); ?></h2>
                                <div id="schema_sql" >
                                    <div><?php echo t('To create your URL, Choose between these elements :', False); ?></div>
                                    <div style="padding:16px 0px;"><span class="ui-icon ui-icon-plusthick floatleft"></span><?php echo t('A SQL property', False); ?></div>
                                    <?php
                                    $models = $module->getModel();
                                    if (count($models) > 0) {
                                        echo '<div class="floatleft ui-tabs-nav" style="position:relative;">
                                            <li class="ui-state-default ui-corner-top modulecss"><a href="#" onclick="return false">' . $module->getName() . '</a></li><div class="details"><div class="detailsCont">';
                                        foreach ($models as $modelName => $model) {

                                            echo '<div class="inline-block entity" table="' . $module->getName() . '_' . $modelName . '">
								<div class="table entityname ellipsis">' . $module->getName() . '_' . $modelName . '</div>';
                                            $obj = app::getModule($module->getName())->getEntity($modelName);
                                            foreach ($obj->getFields() AS $field) {
                                                if (get_class($field) == 'field_foreignkey')
                                                    $link = ' link="' . $module->getName() . '_' . $field->link . '"';
                                                else
                                                    $link = '';
                                                echo '<div name="' . $field->name . '" regex="(.*)" val="example" class="ellipsis property ' . get_class($field) . '"' . $link . ' style="cursor:pointer;margin:5px">' . $field->name . '</div>';
                                            }
                                            echo '</div>';
                                        }
                                        echo '</div></div></div>';
                                    }
                                    ?>
                                    <div class="clearboth"></div>
                                </div>
                                <div style="text-align:left">
                                    <div style="padding: 6px 0px 10px;"><span class="ui-icon ui-icon-plusthick floatleft"></span></span><?php echo t('A textual or numeric parameter controlled with a Regex :', False); ?> </div>
                                    <input type="text" style="width:70px" id="paramname">
                                    <select id="paramregex"><option value="(.*)"></span><?php echo t('Text', False); ?></option><option value="([0-9]*)"></span><?php echo t('Numeric', False); ?></option></select>
                                    <input type="button" id="addparam" value="<?php echo t('Add Text Component', False); ?>">
                                </div>
                                <div style="text-align:left;padding-bottom: 12px;">
                                    <div style="padding: 6px 0px 10px;"><span class="ui-icon ui-icon-plusthick floatleft"></span></span><?php echo t('A simple textual parameter :', False); ?></div>
                                    <input type="button" id="addtextcomposant" value="<?php echo t('Add Text Component', False); ?>">
                                </div>
                                <?php
                                $components = $page->getURLcomponents();
                                ?>
                                <table class="showcomponent <?php
                                if (empty($components))
                                    echo 'none';
                                ?>" style="border-color: #99BBE8;border-style: solid;border-width: 2px;">
                                    <thead>
                                        <tr>
                                            <th><?php echo t('Component', FALSE); ?></th>
                                            <th><?php echo t('Name', FALSE); ?></th>
                                            <th><?php echo t('Regex', FALSE); ?></th>
                                            <th><?php echo t('Default Value', FALSE); ?></th>
                                            <th><span class="ui-icon ui-icon-closethick"></span></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="abc" class="none paramdyn">
                                            <td class="type"><?php echo t('Regex', FALSE); ?></td>
                                            <td class="parsiname"><input type="text" style="width:100px"></td>
                                            <td class="regex"><input type="text" style="width:100px"></td>
					    <td class="modelProperty" style="display:none"><input type="hidden"></td>
                                            <td class="val"><input type="text" style="width:100px"></td>
                                            <td><a href="" onClick="if(confirm('<?php echo t('Are you sure to delete this component ?', FALSE); ?>'))$(this).parent().parent().remove();genereregex();return false;"><span class="ui-icon ui-icon-closethick"></span></a></td>
                                        </tr>
                                        <tr id="abcd" class="none paramstatique">
                                            <td class="type"><?php echo t('Text', FALSE); ?></td>
                                            <td class="text" colspan="3"><input type="text" style="width:400px"></td>
                                            <td><a href="" onClick="if(confirm('<?php echo t('Are you sure to delete this component ?', FALSE); ?>'))$(this).parent().parent().remove();return false;"><span class="ui-icon ui-icon-closethick"></span></a></td>
                                        </tr>
                                        <?php
                                        if (!empty($components)) {
                                            foreach ($page->getURLcomponents() AS $idc => $component) {
                                                if (isset($component['regex'])) {
                                                    ?>
                                                    <tr class="paramdyn">
                                                        <td class="type"><?php echo t('Regex', FALSE); ?></td>
                                                        <td class="parsiname"><input value="<?php echo $component['name']; ?>" name="URLcomponents[<?php echo $idc; ?>][name]" style="width:100px" type="text" ></td>
                                                        <td class="regex"><input value="<?php echo $component['regex']; ?>" name="URLcomponents[<?php echo $idc; ?>][regex]" type="text" style="width:100px" ><input value="<?php if(isset($component['modelProperty'])) echo $component['modelProperty']; ?>" name="URLcomponents[<?php echo $idc; ?>][modelProperty]" type="hidden"></td>
                                                        <td class="val"><input value="<?php echo $component['val']; ?>" name="URLcomponents[<?php echo $idc; ?>][val]" type="text" style="width:100px"></td>
                                                        <td style="text-align:center"><a href="" onClick="if(confirm('<?php echo t('Are you sure to delete this component ?', FALSE); ?>'))$(this).parent().parent().remove();genereregex();return false;"><span class="ui-icon ui-icon-closethick"></span></a></td>
                                                    </tr>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <tr class="paramstatique">
                                                        <td class="type"><?php echo t('Text', FALSE); ?></td>
                                                        <td class="text" colspan="3"><input type="text" class="cent" name="URLcomponents[<?php echo $idc ?>][text]" value="<?php echo $component['text'] ?>"></td>
                                                        <td><a href="" onClick="if(confirm('<?php echo t('Are you sure to delete this component ?', FALSE); ?>'))$(this).parent().parent().remove();return false;"><span class="ui-icon ui-icon-closethick"></span></a></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="none"><a href="#" onClick="$('input[name=\'regex\']');return false;"><?php echo t('Dynamise your page with numbers', FALSE); ?></a> <a href="#" onClick="$(this).next().slideToggle();return false;"><?php echo t('Dynamise your page with String', FALSE); ?></a></div>
                            <div class="clearboth"></div>
                        </div>
			<?php endif; ?>
                    </div>
                </div>
                <div id="tabs-2" class="fields_to_update panel none">
                    <div class="placeholder"><label for="meta[description]"><?php echo t('Description', FALSE); ?></label><textarea class="cent" name="meta[description]" row="7" cols="50"><?php echo s($page->getMeta('description')); ?></textarea></div>
                    <div class="placeholder"><label for="meta[keywords]"><?php echo t('Keywords', FALSE); ?></label><textarea class="cent" name="meta[keywords]" row="7" cols="50"><?php echo s($page->getMeta('keywords')); ?></textarea></div>
                    <div class="placeholder"><label for="meta[author]"><?php echo t('Author', FALSE); ?></label><textarea class="cent" name="meta[author]" row="7" cols="50"><?php echo s($page->getMeta('author')); ?></textarea></div>
                    <div class="placeholder"><label for="meta[category]"><?php echo t('Category', FALSE); ?></label><textarea class="cent" name="meta[category]" row="7" cols="50"><?php echo s($page->getMeta('category')); ?></textarea></div>
                    <div class="placeholder"><label for="meta[copyright]"><?php echo t('Copyright', FALSE); ?></label><textarea class="cent" name="meta[copyright]" row="7" cols="50"><?php echo s($page->getMeta('copyright')); ?></textarea></div>
                </div>
                <input class="none" type="submit" id="sendFormPage">
            </div></form>
    </div>

</div>