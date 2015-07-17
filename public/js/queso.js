  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-12049001-13', 'conque.so');
  ga('send', 'pageview');
//extend jquery
jQuery.expr[':'].Contains = function(a, i, m) { 
  return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0; 
};

var selectedQuestIndex = 0;

$(function() {
 $('.wysiwyg-area').editable({inlineMode: false})
/*    $('.wysiwyg-area').wysihtml5({
	"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
	"emphasis": true, //Italics, bold, etc. Default true
	"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
	"html": false, //Button which allows you to edit the generated HTML. Default false
	"link": true, //Button to insert a link. Default true
	"image": true, //Button to insert an image. Default true,
	"color": false //Button to change color of font  
});	
*/
	$('table.sortable').tablesorter({
		theme : "bootstrap", // this will 
		headerTemplate : '{content} {icon}', 
		widthFixed: true,
		widgets:["filter", "uitheme"],
		widgetOptions: {
			filter_cssFilter: 'tablesorter-filter',
			filter_childRows: false,
			filter_ignoreCase: true,
			filter_reset: '.reset',
			filter_searchDelay: 300,
			filter_startsWith: false,
			filter_hideFilters: false,
			}
		});

	$('a.btn-remove-file').click(function() {
		event.preventDefault();
		$(this).parent().remove();
	});


    
	//$("#create-quest").nod(questCreateMetrics);
     // Select all range inputs, watch for change
	 $("input[type='range']").change(function() {
	 	var labelId = $(this).attr("id")
         $("." + labelId).text($(this).val());
	   
	   // Move bubble
	 })
	 // Fake a change to position bubble at page load
	 .trigger('change');
    $('select.tablesorter-filter').selectpicker();
    $('input.tablesorter-filter').addClass('form-control');
    $('.selectpicker').selectpicker();
	$('table.chart').visualize({
							type: 'area'
						});

    $('.visualize').trigger('visualizeRefresh');
});

$('#quest-select').change(function() {
   if ($('#quest-select').val() == 1) {
		$("#activity_options").show();       
   }
    else {
		$("#activity_options").hide();    
    }

   if ($('#quest-select').val() == 2) {
		$("#submission_options").show();       
   }
    else {
		$("#submission_options").hide();    
   }

   if ($('#quest-select').val() == 3) {
		$("#video_options").show();       
   }
    else {
		$("#video_options").hide();    
    }


});

$('#skills-select').change(function() {
   if ($('#skills-select').val()) {
       $('#quest-skills-rewards p').eq(1).html("");
       $('#skills-select :selected').each(function(i, selected) {
        $('#quest-skills-rewards p').eq(1).append(skillReward($(selected).text(), $(selected).val()));
       });
   }
    else {
    $('#quest-skills-rewards .controls').html("<p></p><p><strong>You can't assign rewards unless the quest has skills associated with it.</strong></p>");

    }
});
jQuery(".next-step, .pager-next").click(function() {
	if (selectedQuestIndex < $('.quest-wizard-page').size() -1) {
		changeQuestPage(1);
		if (selectedQuestIndex == $('.quest-wizard-page').size() - 1) {
			$('.pager-next').addClass('disabled');
		}
		else {
			$('.pager-previous').removeClass('disabled');
		}
	}		
});

jQuery(".pager-previous, .step-back").click(function() {
	if (selectedQuestIndex > 0) {
		for (var i = selectedQuestIndex; i < $('.quest-wizard-page').size(); i++) {
			$('.pager button.page').eq(i).addClass('disabled');
		}
		changeQuestPage(-1);
		$('.pager-next').removeClass('disabled');
		if (selectedQuestIndex == 0) {
			$('.pager-previous').addClass('disabled');	
		}
	}
});

jQuery(".pager .page").click(function() {
	if (!$(this).hasClass('disabled')) {
		selectedQuestIndex = $(this).index() - 1;
		$('.quest-wizard-page').hide();
			for (var i = $(this).index(); i < $('.quest-wizard-page').size(); i++) {
				$('.pager button.page').eq(i).addClass('disabled');
				$('.pager button.page').eq(i).removeClass('active');
			}
			if (selectedQuestIndex != $('.quest-wizard-page').size()) {
				$('.pager-next').removeClass('disabled');
			}
			if (selectedQuestIndex == 0) {
				$('.pager-previous').addClass('disabled');
			
			}
			
		$(this).addClass('active');
		$('.quest-wizard-page').eq($(this).index()-1).show();
	}
});

$('#quest_filter').on('input', function() {
	$(".quest-box").hide();
	var filterText = $(this).val();
	$(".quest-box h3:Contains(" + filterText + ")").parent().parent().parent().show()
    $(".quest-box.quest-totals").show();
});

$('#category-select').change(function() {
    if ($(this).val() == 0) {
        $(".quest-box").show();
    }
    else {
        var filterText = $("#category-select option:selected" ).text();
        $(".quest-box").hide();
        $(".quest-box .quest_category:Contains(" + filterText + ")").parent().show()
        $(".quest-box.quest-totals").show();
    
    }
});
$('.btn-submit').click(function () {
        $(this).button('loading')
    });

function skillReward(name, id) {
	var html = "<div class='controls'><h4>" + name + "</h4>";
			html += "<div class='skill_reward form-inline'>";
			html += "<input value='Minimum' type='hidden' name='skill_reward["+id+"][label][]'> ";
			html += "<input class='form-control input-sm' placeholder='Minimum Point Value' required type='text' name='skill_reward["+id+"][amount][]' style='width:40%;'/> ";
			html += "<input value='Maximum' type='hidden' name='skill_reward["+id+"][label][]'> ";
			html += "<input class='form-control input-sm' placeholder='Maximum Point Value' required type='text' name='skill_reward["+id+"][amount][]' style='width:40%;'/> ";
			html +=	"</div>";
		html += "</div>";
	return html;	
		
}

$(document).bind('change', function(e){
    if( $(e.target).is(':invalid') ){
        $(e.target).parent().addClass('invalid');
    } else {
        $(e.target).parent().removeClass('invalid');
    }
});

$('.validated-submission').click(function() {
	checkRequiredInputs();
});

function checkRequiredInputs() {
	$('#alertModal').remove();
	var inputs = document.getElementsByTagName('input');
	var isGood = true;
	var alertHTML = '<div id="alertModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="alertModalLabel">Missing Information</h3></div><div class="modal-body">';
	for (var i=0; i<inputs.length; i++) {
	 	if (!inputs[i].validity.valid) {
	 		isGood = false;
	 		alertHTML += "<p>"+inputs[i].title+" is required</p>";
	 	}
	}
	alertHTML += '</div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Close</button></div></div>';

	if (!isGood) {
		$('body').append(alertHTML);
	}
	$('#alertModal').modal('show');
}

function changeQuestPage(direction) {
  $('.quest-wizard-page').eq(selectedQuestIndex).hide();
  $('.pager button.page').eq(selectedQuestIndex).removeClass('active');
  selectedQuestIndex += direction;
  $('.quest-wizard-page').eq(selectedQuestIndex).show();
  if (direction == 1) {
	  $('.pager button.page').eq(selectedQuestIndex).removeClass('disabled');
  }
  $('.pager button.page').eq(selectedQuestIndex).addClass('active');
}

function swapPhoto(url) {
	$('#photo_url').val(url);
	$('#profile_photo').attr('src', url);
}
// function taken from http://stackoverflow.com/questions/9552883/regex-to-extract-domain-and-video-id-from-youtube-vimeo-url

function parseVideoURL(url) {

    function getParm(url, base) {
        var re = new RegExp("(\\?|&)" + base + "\\=([^&]*)(&|$)");
        var matches = url.match(re);
        if (matches) {
            return(matches[2]);
        } else {
            return("");
        }
    }

    var retVal = {};
    var matches;

    if (url.indexOf("youtube.com/watch") != -1) {
        retVal.provider = "youtube";
        retVal.id = getParm(url, "v");
    } else if (matches = url.match(/vimeo.com\/(\d+)/)) {
        retVal.provider = "vimeo";
        retVal.id = matches[1];
    }
    return(retVal);
}

$('.select-all').click(function() {
	if($(this).hasClass( "select-all" )) {
		//select all
		
           $('.user-checkbox').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
 	
		$(this).removeClass("select-all");
		$(this).text("Select None");
	}
	else {

           $('.user-checkbox').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"               
            });
		$(this).addClass("select-all");
		$(this).text("Select All");

	}
});

function emailSelectedStudents() {
	var addressList = "";
	 $('.user-checkbox').each(function() { //loop through each checkbox
        if(this.checked) {
    		addressList += $(this).parent().children('.email').text() + ",";    
        }
    });
    	if (addressList.length > 0) {
         document.location.href = "mailto:" + addressList;
		}
		else {
			alert("You need to select students in order to email them");
		}
}

function filterQuests() {
$(".category").parent().parent().parent().show();
	

	if ($('select#category-select :selected').val() != 0) {
		$(".category").filter(function() {
			return $(this).text() != $('select#category-select :selected').text();
		}).parent().parent().parent().hide();
	}
	$( "select.selectskill" ).each(function( index ) {
	  var skillId = $( this ).attr('rel');
	  var skillLevel = $('select#skill-select-' + skillId + ' :selected').val()
	  console.log("Searching for Skill " + skillId + " with level of " + skillLevel);
		$(".required_skill_id").filter(function() {
			return $(this).text() === skillId;
		}).each(function() {
			//check if level is greater than or equal to selected level
			if ($(this).parent().children('.required_skill_amount').text() >= skillLevel) {
				console.log("match and level found");
			}
			else {
				console.log("no match for level found");
				$(this).parent().parent().parent().parent().hide();
			}
		});
	});

}