$(function(){
	$('input[type="checkbox"]').each(function(){
		var self = $(this),
		label = self.next(),
		label_text = label.text();

		label.remove();
		self.iCheck({
			checkboxClass: 'icheckbox_line-red',
			insert: '<div class="icheck_line-icon"></div>' + label_text
		});
	});

	$('input[type="radio"]').each(function(){
		var self = $(this),
		label = self.next(),
		label_text = label.text();

		label.remove();
		self.iCheck({
			radioClass: 'iradio_line-red',
			insert: '<div class="icheck_line-icon"></div>' + label_text
		});
	});

	$("[data-toggle='tooltip']").tooltip();

	// Toggle main menu slide
	$('.toggle-menu').click(function () {
	    $('.full-content-wrapper').toggleClass("toggle");
	});

	// Add a max heigt to .main-menu-outer-box for scrolling
	$(function () {
	    var mainMenuOuterBoxMaxHeight = $(window).height() - 80 - $('.version-marker').outerHeight();
	    $('.main-menu-outer-box').css("max-height", mainMenuOuterBoxMaxHeight);
	});
	$(window).resize(function () {
	    var mainMenuOuterBoxMaxHeight = $(window).height() - 80 - $('.version-marker').outerHeight();
	    $('.main-menu-outer-box').css("max-height", mainMenuOuterBoxMaxHeight);
	});

	$('.client_theme_picker').on('change', function(){
        document.cookie = "prometheus_theme=" + $(this).val();
        location.reload();
	});

	$('.client_language_picker').on('change', function(){
        document.cookie = "prometheus_language=" + $(this).val();
        location.reload();
	});
});

$('.ids').on('click', function(){
	var steam64 = $(this).find('.steam64').text();
	var steamid = $(this).find('.steamid').text();

	var curtext = $(this).find('.userid').text();

	if(curtext == steam64){
		$(this).find('.userid').text(steamid);
	} else {
		$(this).find('.userid').text(steam64);
	}
});	


/**
 * Packages
 */

function chooseFile() {
	$("#img").click();
}

$("#display_check").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#display_img').show();
	} else {
		$('#display_img').hide();
	}
});

$("#custom_price").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#price_options').hide();
		$('#price_options2').show();
	} else {
		$('#price_options').show();
		$('#price_options2').hide();
	}
});

$("#alternative_pp_check").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#alternative_pp').show();
	} else {
		$('#alternative_pp').hide();
	}
});

$("#pkg_permanent").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#days').hide();
		$('#subscription').hide();

	} else {
		$('#days').show();
		$('#subscription').show();
	}
});

$("#pkg_label").on("change", function() {
	var count = $(this).val()
	var amount = $("#inputs").children().length

	if (count > 0 && count != 'none') {
		$("#labels").show();
	} else {
		$("#labels").hide();
	}

	for (i=amount;i<count;i++){
		$("<input class='form-control' style='margin-top: 5px;' placeholder='Label " + i + "' name='labels[]'>").appendTo("#inputs");
	}

	var difference = amount - count;

	for(var i = 0; i < difference; i++) {
		$("input:last-child", $('#inputs')).remove();
	}
})

/**
 * Actions
 */

$(".action_checkbox").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;

	if(done) {
		$(this).parents('.checkbox').find('.options').show();
	} else {
		$(this).parents('.checkbox').find('.options').hide();
	}
});

$("#rank_before").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#rank_after').hide();
	} else {
		$('#rank_after').show();
	}
});

$("#rank_prefix_tick").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#rank_after2').show();
		$('#rank_normal').hide();
	} else {
		$('#rank_after2').hide();
		$('#rank_normal').show();
	}
});

$("#custom_action_after").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#code_after').show();
	} else {
		$('#code_after').hide();
	}
});

$("#teamspeak_group_tick").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#teamspeak_group_options').show();
	} else {
		$('#teamspeak_group_options').hide();
	}
});

$("#teamspeak_channel_tick").on("ifChanged", function() {
	var done = ($(this).is(':checked')) ? true : false;
	if(done) {
		$('#teamspeak_channel_options').show();
	} else {
		$('#teamspeak_channel_options').hide();
	}
});

$("#updateButton").click(function() { 
	var $this = $(this);

	$this.text("Updating ...");
});

$(function() {
	$( "#datepicker" ).datepicker();
	$( "#datepicker2" ).datepicker();
});

/**
 * Theme editor
 */

$('.color_box').colpick({
	layout:'rgbhex',
	submit: 0,
	colorScheme:'light',
	onChange:function(hsb,hex,rgb,el,bySetColor) {
		$(el).css('border-left','3px solid #'+ hex + '');
		$(el).val = rgb['r'] + ',' + rgb['g'] + ',' + rgb['b'];
		if(!bySetColor) $(el).val(rgb['r'] + ',' + rgb['g'] + ',' + rgb['b']);

		if($(el).attr('forclass') != ""){
			var changeClass = $(el).attr('forclass');
			var changeType = $(el).attr('classtype');

			//$(changeClass).css(changeType, 'rgb('+ rgb["r"] +', '+ rgb["g"] +', '+ rgb['b'] +') !important;');

			$(changeClass).each(function () {
			    this.style.setProperty(changeType, 'rgb('+ rgb["r"] +', '+ rgb["g"] +', '+ rgb['b'] +')', 'important');
			});
		}
	}
}).keyup(function(){
	$(this).colpickSetColor(this.value);
});

$(document).ready(function() {
    $(".buy-btn-free").click(function() { 
		$(this).addClass("disabled");
	});
});

/**
 * Admin sidebar
 */

$(function() {
	$('#sidebarButton').on('click', function(){
		$('#sidebar').fadeToggle(500);

		var state = 0;

		if($('#maincontent').hasClass('col-md-9')){
			setTimeout(function(){
		   		$('#maincontent').removeClass('col-md-9');
		   		$('#maincontent').addClass('col-md-12');

		   		state = 0;
		    }, 500);
		} else if($('#maincontent').hasClass('col-md-12')){
		    $('#maincontent').removeClass('col-md-12');
		    $('#maincontent').addClass('col-md-9');

		    state = 1;
		}

	    $.ajax({
	        url: "inc/ajax/sidebar.php",
	        type: "POST",
	        data: "action=setState&state=" + state,
	        cache: false,
	        success: function (response) {}
	    });
	});
});

function getUrlParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}