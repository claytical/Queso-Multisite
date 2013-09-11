  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-12049001-13', 'conque.so');
  ga('send', 'pageview');

var selectedQuestIndex = 0;

$(function() {
	$('.wysiwyg-area').wysihtml5();	
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
	$('table.chart').visualize({
							type: 'area'
						});
	$('.slider').slider();
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
 		//mobile only js
 	}
	else {
		//desktop js
	    $(".chzn-select").chosen();

	}
	


	$('a.btn-remove-file').click(function() {
		event.preventDefault();
		$(this).parent().remove();
	});

	$('a.btn-edit-skill').click(function() {
		$(this).hide();
		$(this).parent().children('button.btn-edit-skill-save').show();
		$(this).parent().parent().parent().parent().children("td").children(".skill-input").show();
		$(this).parent().parent().parent().parent().children("td").children(".skill-name").hide();

	});
	//$("#create-quest").nod(questCreateMetrics);
     // Select all range inputs, watch for change
	 $("input[type='range']").change(function() {
	 
	   $(this).next("span").text($(this).val());
	   
	   // Move bubble
	 })
	 // Fake a change to position bubble at page load
	 .trigger('change');
});
  
$('#quest-select').chosen().change(function() {
	if ($('#quest-select').val() == 2) {
		$("#submission_options").show();
	}
	else {
		$("#submission_options").hide();

	}
});
$('#skills-select').chosen().change(function() {
	if ($('#skills-select :selected').size() > 0) {
		$('#quest-skills-rewards .controls').remove();
		$('#skills-select :selected').each(function(i, selected){ 
			$('#quest-skills-rewards p').append(skillReward($(selected).text(), $(selected).val()));
		});

	}
	else {
		$('#quest-skills-rewards .controls').html("<p></p><p><strong>You can't assign rewards unless the quest has skills associated with it.</strong></p>");
	}
});


jQuery(".next-step, .pager-next").click(function() {
	if (selectedQuestIndex < $('.control-group').size() -1) {
		changeQuestPage(1);
		if (selectedQuestIndex == $('.control-group').size() - 1) {
			$('.pager-next').addClass('disabled');
		}
		else {
			$('.pager-previous').removeClass('disabled');
		}
	}		
});

jQuery(".pager-previous, .step-back").click(function() {
	if (selectedQuestIndex > 0) {
		for (var i = selectedQuestIndex; i < $('.control-group').size(); i++) {
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
		$('.control-group').hide();
			for (var i = $(this).index(); i < $('.control-group').size(); i++) {
				$('.pager button.page').eq(i).addClass('disabled');
				$('.pager button.page').eq(i).removeClass('active');
			}
			if (selectedQuestIndex != $('.control-group').size()) {
				$('.pager-next').removeClass('disabled');
			}
			if (selectedQuestIndex == 0) {
				$('.pager-previous').addClass('disabled');
			
			}
			
		$(this).addClass('active');
		$('.control-group').eq($(this).index()-1).show();
	}
});

$('.btn-submit').click(function () {
        $(this).button('loading')
    });

function skillReward(name, id) {
	var html = "<div class='controls'><h4>" + name + "</h4>";
			html += "<div class='skill_reward form-inline'>";
			html += "<input value='Minimum' type='hidden' name='skill_reward["+id+"][label][]'> ";
			html += "<input placeholder='Minimum Point Value' required type='text' name='skill_reward["+id+"][amount][]'/> ";
			html += "<input value='Maximum' type='hidden' name='skill_reward["+id+"][label][]'> ";
			html += "<input placeholder='Maximum Point Value' required type='text' name='skill_reward["+id+"][amount][]'/> ";
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
  $('.control-group').eq(selectedQuestIndex).hide();
  $('.pager button.page').eq(selectedQuestIndex).removeClass('active');
  selectedQuestIndex += direction;
  $('.control-group').eq(selectedQuestIndex).show();
  if (direction == 1) {
	  $('.pager button.page').eq(selectedQuestIndex).removeClass('disabled');
  }
  $('.pager button.page').eq(selectedQuestIndex).addClass('active');
}

function swapPhoto(url) {
	$('#photo_url').val(url);
	$('#profile_photo').attr('src', url);
}
