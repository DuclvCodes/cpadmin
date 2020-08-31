// JavaScript Document for Nav Menu
var nestlelistchanged=false;	

function loadingImage(show,element,msg=''){
	if(show==false){
$(element).html('');
	}
	else{
		$(element).html('wait...'+msg);
	}
}

$(document).ready(function(){

	$(document).on('keyup','#quicksearchcontent',function() { 
	// $('#quicksearchcontent').change(function(){ searchcontents();
		//search the text box
		
		var term=$(this).val().trim();
		var resultpane=$('.searchcontentresult');
		resultpane.empty();
		
		if (!term){return false;}
		
		
		loadingImage(true,'.spinquicksearchcontent');
		//both are assumed to have values. Any error will be returned from the server
		$.ajax({
                type: "GET",
                url: SiteRoot+"admin/contentsearch/basic/"+term,
                data: {},
                dataType : "json",
                cache: "false",
                success: function (result) {
				
					
					var total=result.length;
					
         if(total>0){
			 var counter=0;
			
			 while(counter<total){
				 
				 resultpane.append('<p><a href="#" class="foundcontent" data-id="'+result[counter]['rowid']+'" data-route="'+result[counter]['route']+'" data-rowtitle="'+result[counter]['rowtitle']+'" data-alias="'+result[counter]['alias']+'">'+result[counter]['rowtitle']+'</a> <span class="tiny">'+result[counter]['alias']+'</span></p>');
				
				 counter++;
			 }


			 
		 }


loadingImage(false,'.spinquicksearchcontent');

                },
				fail: function (result){
					
				bootbox.alert(languages_navmenu['servererror']);
				}

            });
			loadingImage(false,'.spinquicksearchcontent');	
			
	    });
	
//--------------------------------------------------------------------------

 $('#deleteallmenus').click(function(){
		//delete all menus
		
			Lobibox.confirm({
                    msg: languages_navmenu['deleteall'],
                 callback: function ($this, type) {
						if(type=='no'){
						
						return false;	
						}
						else{
							//delete all menus
							clearmenus('all');
							//End delete all menus
						}
				 }
				});
			   
	    });
	
	$('#deletecurrentmenus').click(function(){
		//delete current menus
		
			Lobibox.confirm({
                    msg: languages_navmenu['deletecurrent'],
                 callback: function ($this, type) {
						if(type=='no'){
						
						return false;	
						}
						else{
							//delete all menus
							clearmenus('current');
							//End delete all menus
						}
				 }
				});
			   
	    });

function clearmenus(clearingkind){
	var path='';
	var postForm=$('#frmmenus').serialize();
	if(clearingkind=='all'){
		path=SiteRoot+"admin/navmenus/deleteallmenus";
		
	}
	else{
	var loc=$('#menu_locations').val();
var lang=$('#menu_languages').val();
postForm=postForm+'&loc='+loc+'&lang='+lang;
path=SiteRoot+"admin/navmenus/clearcurrentmenus";
	}

	$.ajax({
                type: "POST",
                url: path,
               
                data: postForm,
                dataType : "json",
                cache: "false",
                success: function (result) {
			
                    //remove it
					if(result=='1'){
					//success
					nestlelistchanged=false;
					$('#webmenus').empty();
					$('#generate').html(languages_navmenu['alldeleted']);
					}
					
					else {
						$('#generate').html(languages_navmenu['notalldeleted']);
					}
                },
				fail: function (result){
				showalert('error',languages_navmenu['servererror']);
				}
				
				
            });
	
	
}
//--------------------------------------------------------------------------------
	
	 $('#btn_showmenu').click(function(){
		//show menus
		if(nestlelistchanged==true){
			Lobibox.confirm({
                    msg: languages_navmenu['unsaved'],
                 callback: function ($this, type) {
						if(type=='no'){
						
						return false;	
						}
						else{
							showmenus();
						}
				 }
				});
			
		}
		else {
		showmenus();	
		}
						   
	    });
	
	
	 function showmenus(){
		//show menus
	
		nestlelistchanged=false;
		$('#webmenus').empty();
		loadingImage(true,'.spinloadstrucute');
		var loc=$('#menu_locations').val();
		var lang=$('#menu_languages').val();
		
		//both are assumed to have values. Any error will be returned from the server
		$.ajax({
                type: "GET",
                url: SiteRoot+"admin/navmenus/showmenus/"+loc+'/'+lang,
                data: {},
                dataType : "json",
                cache: "false",
                success: function (result) {

var total=result.length;


if(total==0){
	return false;
	}
else if(total==1){
	var webmenus=$('#webmenus');
	
	webmenus.append('<li class="dd-item" data-label="'+result[0]["name"]+'" data-id="'+result[0]["id"]+'" data-link="'+result[0]["link"]+'" data-cls="'+result[0]["class"]+'"><div class="dd-handle">'+result[0]["name"]+'</div> <span class="nestleeditd fa fa-pencil"></span> <span class="nestledeletedd fa fa-trash"></span>'+navmenuitemeditor()+'</li>');

}
else if(total>1){
//loop it up
var webmenus=$('#webmenus');
	var counter=0;
	var elems='';
	while (counter<total) {
	
		elems=elems+'<li class="dd-item" data-label="'+result[counter]["name"]+'" data-id="'+result[counter]["id"]+'" data-link="'+result[counter]["link"]+'" data-cls="'+result[counter]["class"]+'"><div class="dd-handle">'+result[counter]["name"]+'</div> <span class="nestleeditd fa fa-pencil"></span> <span class="nestledeletedd fa fa-trash"></span>'+navmenuitemeditor();
		
		if(counter<total-1){
			if(result[counter+1]['level']>result[counter]['level']){
				elems=elems+'<ol class="dd-list">';
			
			}
			else{
			
				elems=elems+'</li>';
				
			}
			if (result[counter + 1]['level'] < result[counter]['level']) {
			
			elems=elems+'</ol></li>'.repeat(result[counter]['level']-result[counter+1]['level']);
               // echo str_repeat('</ol></li>' . "\n",$categories[$i]['level'] - $categories[$i + 1]['level']);
                                
            }
			
		}//if(counter<total-1){
			
			
		
		else {
	
          elems=elems+'</li>';
          //  echo str_repeat('</ol></li>' . "\n", $categories[$i]['level']);
		elems=elems+'</ol></li>'.repeat(result[counter]['level']);
		  
        }
		
		
		
		counter++;
	}//en while
	
	webmenus.append(elems);
	 $('#nestable').nestable();
}
loadingImage(false,'.spinloadstrucute');

                },
				fail: function (result){
					
				bootbox.alert(languages_navmenu['servererror']);
				}

            });
			loadingImage(false,'.spinloadstrucute');						   
	    }
		
		//-------------------------------------------------------------
	
	
	$(document).on('click','.nestleeditd', function(){
													//edit the clicked menu:
	//find the next menu
	hidemenueditingblock();
    var editmenu=$(this);
	var info=editmenu.closest("li");
	var mname=info.attr('data-label');
	var mlink=info.attr('data-link');
    var mclass=info.attr('data-cls');

	var editorblock=editmenu.next().next();
    editorblock.find('.mname').val(mname);
	editorblock.find('.mtarget').val(mlink);
	editorblock.find('.mclass').val(mclass);
editorblock.show();
});
	
	$(document).on('click','.nestledeletedd', function(){
nestlelistchanged=true;
	$(this).closest("li").remove();
});
	

	$(document).on('click','.cancelnavmenu', function(e){
													  e.preventDefault();
		var editmenu=$(this);
		var editorblock=editmenu.closest("div.menublock");

editorblock.hide();
	   });  
	  
	$(document).on('click','.updatenavmenu', function(){
		var editmenu=$(this);
		var editorblock=editmenu.closest("div.menublock");
   var mname= editorblock.find('.mname').val().trim();
	var mtarget=editorblock.find('.mtarget').val().trim();
	var mclass=editorblock.find('.mclass').val().trim();

                                             if(mname==""){
												showalert('error',languages_navmenu['musthavename']);
												return false;
											 }
											 nestlelistchanged=true;
											 var info=editmenu.closest("li");
											 info.attr('data-label', mname);
											 info.attr('data-link', mtarget);
											 info.attr('data-cls', mclass);
											 info.find("div:first").html(mname);
											//$(this).find("td").eq(1).text(moleorder);
															// editmenu.closest("li").find("div span.mlabel").html(mname);
															  
															 });
							
							
							                    
	 
	$('.addtonavmenu').click(function(e){
											nestlelistchanged=true;
											  var menu=$('#menu_target option:selected').val();
											  var menuname=$('#menu_target option:selected').text();
						   $('#webmenus').append('<li class="dd-item" data-id="0" data-link="'+menu+'" data-label="'+menuname+'" data-cls=""><div class="dd-handle">'+menuname+'</div> <span class="nestleeditd fa fa-pencil"></span> <span class="nestledeletedd fa fa-trash"></span>'+navmenuitemeditor()+'</li>');
						   $('#nestable').nestable({maxDepth:4});
										    
										   });
	
	
	
	
	$(document).on('click','.foundcontent', function(e){
//<a href="#" class="foundcontent" data-id="'+result[counter]['rowid']+'" data-route="'+result[counter]['route']+'" data-rowtitle="'+result[counter]['rowtitle']+'" data-alias="'+result[counter]['alias']+'">'+result[counter]['rowtitle']+'</a>
   e.preventDefault();
   var found=$(this);
   nestlelistchanged=true;
   $('#webmenus').append('<li class="dd-item" data-id="0" data-link="'+SiteRoot+found.attr("data-route")+'/'+found.attr("data-rowid")+'" data-label="'+found.attr("data-rowtitle")+'" data-cls=""><div class="dd-handle">'+found.attr("data-rowtitle")+'</div> <span class="nestleeditd fa fa-pencil"></span> <span class="nestledeletedd fa fa-trash"></span>'+navmenuitemeditor()+'</li>');
						   $('#nestable').nestable({maxDepth:4});
	
});
	
	
	
	 $(".searchcontentresult").slimscroll({
      height: 220,
      alwaysVisible: false,
      size: 3
    }).css("width", "100%");
	
	});


function navmenuitemeditor(id){
var editorelement='<div class="menublock"><input type="text" class="form-control requiredfields mname" required="required" value="" maxlength="75" placeholder="'+languages_navmenu["name"]+'"><input type="text" class="form-control requiredfields mtarget" required="required" value="" maxlength="255" placeholder="'+languages_navmenu["target"]+'"><input type="text" class="form-control mclass" value="" maxlength="255" placeholder="'+languages_navmenu["cssclass"]+'"><br/><input type="button" class="btn btn-theme updatenavmenu" value="'+languages_navmenu["updatemenu"]+'" /><a href="#" class="cancelnavmenu">'+languages_navmenu["cancel"]+'<a/></div>'
			  
return editorelement;
}

function hidemenueditingblock(){
	$('.menublock').hide();
	
}
