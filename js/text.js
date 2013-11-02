function TextJS() {
	var main = this;
	this.options = {
		charPage: 800,
		lineNumbers: 'show',
	}
	this.text = new Object();
	this.currentSelected = ''; // Needed for selection
	this.currentStart = '';
	this.currentEnd = '';
	this.color = 'none';
	this.highlightblue1 = 'rgba(165,179,253,0.10)';
	this.highlightgreen1 = 'rgba(165,253,178,0.10)';
	this.highlightred1 = 'rgba(134, 4, 4, 0.30)';
	this.highlightblue2 = 'rgba(7, 38, 136, 0.30)';
	this.highlightgreen2 = 'rgba(4, 134, 43, 0.30)';
	this.highlightred2 = 'rgba(255,138,138,0.10)';
	var color1, color2;
	$(document).ready(function() { // Wait for everything to load. 
		var textID = main.getUrlVars()["t"];
		var user = $('#personid').val(); 
		
		main.GetData(textID);
		//$('#contentText').tooltip({ selector: "span", placement: 'top' });  
		$('#messageBox').draggable();
		$('.pageSingle').live('mouseup', function(e) {
			console.log('Log: mouseup registered.'); 
			if (main.color != 'none') {
				console.log('Log: color selected:' + main.color); 
				var pagenumber = $(this).attr('pageID');
				//var spannedText = $(this).find('span').text(); 					//remove highlight from text
				//$(this).find('span').replaceWith(spannedText); 								
				main.currentSelected = main.GetSelectedText();
				var getId = 'page' + pagenumber;
				var element = document.getElementById(getId);
				main.currentStart = main.GetSelectedLocation(element).start - 1;
				main.currentEnd = main.GetSelectedLocation(element).end;
				console.log(' end ' + main.currentEnd);
				var number = Math.floor((Math.random() * 100000000) + 1);
				console.log(main.currentStart + '-' + main.currentEnd);
				$(this).children('.letter').each(function() {
					console.log('Log: going through letter.');
					var letterID = $(this).attr('letterID');
					console.log('start: ' + main.currentStart + ' -- end: ' + main.currentEnd + ' -- letterID: ' + letterID);
					if (letterID > main.currentStart && letterID < main.currentEnd) {
					console.log('Log: letter within highlight.');
						$(this).addClass('selected');
						var bg = $(this).css('background-image');
						console.log('Log: background color before: ' + bg);
						if (bg == 'none') {
							bg = '';
						} else {
							bg = bg + ', ';
						}
						var redBG = 'linear-gradient(to bottom , rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						var greenBG = 'linear-gradient(to bottom , rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						var blueBG = 'linear-gradient(to bottom, rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						switch (main.color) {
						case 'red':
							$(this).addClass('redH');
							redBG = 'linear-gradient(to bottom, ' + main.highlightred1 + ', ' + main.highlightred2 + ')';
							break;
						case 'blue':
							$(this).addClass('blueH');
							blueBG = 'linear-gradient(to bottom , ' + main.highlightblue1 + ', ' + main.highlightblue2 + ', ' + main.highlightblue1 + ')';
							break;
						case 'green':
							$(this).addClass('greenH');
							blueBG = 'linear-gradient(to bottom, ' + main.highlightgreen1 + ', ' + main.highlightgreen2 + ')';
							break;
						}
						var finalColor = bg + redBG + ', ' + blueBG + ', ' + greenBG;
					console.log('Log: Background color after: ' + finalColor);

						$(this).css('background', finalColor);
						$(this).attr('hID', number);
						if (letterID == main.currentEnd - 1) {
							$(this).addClass('end');
						}
					}
				});
				if ((main.currentEnd - main.currentStart) > 2) {
					// Save the highlight
					main.NewHighlight(number, user, textID, pagenumber, main.currentStart, main.currentEnd, main.color, '', main.currentSelected); 

					$('#currentHighlight').val(number);
					console.log(number);
					$('#messageText').val('');
					$('#commentbox').hide(); 
					$('#messageBox').show(); // show comment box
					$('#messageText').focus();
					// clear highlight option
					main.color = 'none';
					$('#greenDot').removeClass('greenDot2 active').addClass('greenDot');
					$('#blueDot').removeClass('blueDot2 active').addClass('blueDot');
					$('#redDot').removeClass('redDot2 active').addClass('redDot');
					
					// Undo text section
					$('#undoText').removeClass('undoTextLight').addClass('undoTextDark').attr('undoID', number); // Make undo text dark 

				
				}
			}
		});
		$('#undoText').live('click', function () {
				var hID = $(this).attr('undoID'); 
				console.log(hID); 
				$('.letter[hID='+hID+']').each(function() {
					$(this).removeClass('selected blueH greenH redH').css('background-image', 'none');
					$(this).children('span').html(''); 
				}); 
				// remove highlight
				$(this).removeClass('undoTextDark').addClass('undoTextLight').attr('undoID', '0'); // Make undo text dark 
				// remove comment box 
				$('#commentbox').hide(); 

				// delete last from database as well
					main.DeleteHighlight(hID); 
		}); 		
		$('#blueDot').live('click', function() {
			if ($(this).hasClass('active')) {
				$(this).removeClass('blueDot2 active').addClass('blueDot');
				main.color = 'none';
			} else {
				$(this).removeClass('blueDot').addClass('active blueDot2');
				main.color = 'blue';
				$('#greenDot').removeClass('greenDot2 active').addClass('greenDot');
				$('#redDot').removeClass('redDot2 active').addClass('redDot');
			}
			$('#messageBox').hide(); 

		});
		$('#greenDot').live('click', function() {
			if ($(this).hasClass('active')) {
				$(this).removeClass('greenDot2 active').addClass('greenDot');
				main.color = 'none';
			} else {
				$(this).removeClass('greenDot').addClass('active greenDot2');
				main.color = 'green';
				$('#blueDot').removeClass('blueDot2 active').addClass('blueDot');
				$('#redDot').removeClass('redDot2 active').addClass('redDot');
			}
			$('#messageBox').hide(); 

		});
		$('#redDot').live('click', function() {
			if ($(this).hasClass('active')) {
				$(this).removeClass('redDot2 active').addClass('redDot');
				main.color = 'none';
			} else {
				$(this).removeClass('redDot').addClass('active redDot2');
				main.color = 'red';
				$('#greenDot').removeClass('greenDot2 active').addClass('greenDot');
				$('#blueDot').removeClass('blueDot2 active').addClass('blueDot');
			}
			$('#messageBox').hide(); 

		});
		$('#cancelMessage').live('click', function() {
			$('#currentHighlight').val('');
			$('#messageText').val('');
			$('#messageBox').hide(); 
		});
		$("#messageText").keydown(function(event) {
			if (event.which == 27) {
				event.preventDefault();
				$('#currentHighlight').val('');
				$('#messageText').val('');
				$('#messageBox').hide(); // show comment
			}
		});
		$('#addMessage').live('click', function() {
			var spanid = $('#currentHighlight').val();
			var text = $('#messageText').val();
			
			// add message to highlight in the database
			main.AddMessage(spanid, text); 
			
			console.log(spanid + text);
			$('#messageBox').hide(); // show comment
			$('span[hID="' + spanid + '"]').each(function() {
				if ($(this).hasClass('end')) {
					$(this).attr('title', text); // add message as attribute to the span				
				}
			});
			$('span[hID="'+spanid+'"]').each(function() {
				if($(this).hasClass("end")){
					$(this).append('<span class="hasMessage"><i class="icon-comment"></i></span>')// add message icon to the span				
				}
				}); 
		});
		$("#messageText").keydown(function(event) { 
			if (event.which == 13) {
				event.preventDefault();
				var spanid = $('#currentHighlight').val();
				var text = $('#messageText').val();
				// add message to highlight in the database
				main.AddMessage(spanid, text); 
				
				$('#messageBox').hide(); // show comment
				$('span[hID="' + spanid + '"]').each(function() {
					if ($(this).hasClass('end')) {
						$(this).attr('title', text); // add message as attribute to the span				
					}
				});				
				$('span[hID="'+spanid+'"]').each(function() {
					if($(this).hasClass("end")){
						$(this).append('<span class="hasMessage"><i class="icon-comment"></i></span>')// add message icon to the span				
					}
				});
			}
		});

		$('#lineOff').live('click', function() {
			if ($('.lineNumbers').is(':visible')) {
				$('.lineNumbers').hide();
				$(this).css('color', '#999');
			} else {
				$('.lineNumbers').show();
				$(this).css('color', '#000');
			}
		});
		$('.hasMessage').live('click', function() {
			var message = $(this).parent().attr('title'); // get the message; 
			console.log(message); // add message to the comment box.
			var commentHeaderColor; 
			if($(this).parent().hasClass('blueH')){commentHeaderColor = 'rgba(163, 163, 224, 0.52)' ; }
			if($(this).parent().hasClass('greenH')){commentHeaderColor = 'rgba(134, 185, 134, 0.52)' ; }
			if($(this).parent().hasClass('redH')){commentHeaderColor = 'rgba(173, 112, 112, 0.52)' ; }
			
			$('#commentbox').html('<div class="commentHeader" style="background:'+commentHeaderColor+'"> </div><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> <div>' + message + '</div>'); // change show comment box with message
			$('#commentbox').show();
		});
		
		$('.close').live('click', function() {
		
			$(this).parent('div').hide();
		});

		// Previous and Next Page links
		$("#previous").on('click', function() {
			var s = $("#pageSlider"),
				val = s.slider("value"),
				step = 1,
				min = s.slider("option", "min");
				max = s.slider("option", "max");
			s.slider("value", val - step);
			if (val != min) {
				val = val - 1;
			}
			$("#pageLabel").html("Page " + val + " of " + max); // Show page number
			$('.pageSingle').hide(); // Hide all pages
			$('.pageSingle[pageID=' + val + ']').show(); // Show this page
		    $('html, body').animate({scrollTop : 0 });
		});
		$("#next").on('click', function() {
			var s = $("#pageSlider"),
				val = s.slider("value"),
				step = 1,
				max = s.slider("option", "max");
			s.slider("value", val + step);
			if (val != max) {
				val = val + 1;
			}
			$("#pageLabel").html("Page " + val + " of " + max); // Show page number
			$('.pageSingle').hide(); // Hide all pages
			$('.pageSingle[pageID=' + val + ']').show(); // Show this page
		    $('html, body').animate({scrollTop : 0 });
		});

	});
}
TextJS.prototype.GetData = function(textID) {
	var main = this;
	$.ajax({ // Ajax talking to the dbase.php file												
		type: "POST",
		url: "php/dbase.php",
		data: {
			textID: textID,
			action: 'getText'
		},
		success: function(data) { // If connection is successful . 
			main.text = data.text;
			main.loadH = data.highlights; 
			// run paginator
			main.Paginate(main.text.textContent);
			//main.LineNumbers();
			$('#textTitle').html(main.text.textTitle);

		},
		error: function() { // If connection is not successful.  
			console.log("The connection to dbase.php failed for getting text data.");
		}
	});
}
TextJS.prototype.LoadHighlights = function() {
	// load and draw the existing highlights. 
	var main = this;
	var i, o; 
	for(i = 0; i < main.loadH.length; i++){
		o =  main.loadH[i]; 
				var hPage = o.hPage; // get page number
				var hBegin = o.hBegin; 				
				var hEnd = o.hEnd; 
				var hType = o.hType; 
				var hComment = o.hComment; 
				var hContent = o.hContent; 
								
				$('.pageSingle[pageID=' + hPage + ']').children('.letter').each(function(){
					var thisLetterId; 
					    thisLetterId = $(this).attr('letterID'); 
					    thisLetterId = parseFloat(thisLetterId); 
					    hBegin = parseFloat(hBegin); hEnd = parseFloat(hEnd); 
					if(thisLetterId > hBegin && thisLetterId < hEnd){
						console.log(thisLetterId+'__yes ==  begin: '+hBegin+' end: '+hEnd);
						$(this).addClass('selected');
						var bg = $(this).css('background-image');
						if (bg == 'none') {
							bg = '';
						} else {
							bg = bg + ', ';
						}
						var redBG = 'linear-gradient(to bottom , rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						var greenBG = 'linear-gradient(to bottom , rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						var blueBG = 'linear-gradient(to bottom, rgba(255, 138, 138, 0), rgba(255, 135, 135, 0))';
						switch (hType) {
						case 'red':
							$(this).addClass('redH');
							redBG = 'linear-gradient(to bottom, ' + main.highlightred1 + ', ' + main.highlightred2 + ')';
							break;
						case 'blue':
							$(this).addClass('blueH');
							blueBG = 'linear-gradient(to bottom , ' + main.highlightblue1 + ', ' + main.highlightblue2 + ', ' + main.highlightblue1 + ')';
							break;
						case 'green':
							$(this).addClass('greenH');
							blueBG = 'linear-gradient(to bottom, ' + main.highlightgreen1 + ', ' + main.highlightgreen2 + ')';
							break;
						}
						var finalColor = bg + redBG + ', ' + blueBG + ', ' + greenBG;
						$(this).css('background', finalColor);
						$(this).attr('hID', o.hCode);
						
						if (hComment.length > 0 && thisLetterId == (hEnd - 1)) {
							$(this).addClass('end');
							$(this).attr('title', hComment); // add message as attribute to the span				
							$(this).append('<span class="hasMessage"><i class="icon-comment"></i></span>')// add message icon to the span				

						}
					}
				});			
	}	



}
TextJS.prototype.getUrlVars = function() {
	// Use case: var first = getUrlVars()["id"];
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
		vars[key] = value;
	});
	return vars;
}
TextJS.prototype.Paginate = function(fullText) {
	var main = this;
	var longText = fullText;
	//var pageLength = main.options.charPage;
/*
	var charsDone = 0;
	var i = 0;
	var divHeight, lineHeight, lines;
	while (charsDone <= longText.length && (pageLength + charsDone) < longText.length) {
		i++;
		var pageBox = longText.substr(lastSpace, pageLength);
		var lastSpace = charsDone + pageBox.lastIndexOf(" ");
		var page = longText.substring(charsDone, lastSpace);
		var pageid = 'page' + i;
		$('#contentText').append('<div class="pageSingle hide" id="' + pageid + '" pageID="' + i + '"><div class="lineNumbers"></div>' + page + '</div>');
		charsDone = lastSpace;
	}
	i++;
*/

	var allPages = longText.split("&&");
	var totalPages = allPages.length; 
	for(var i = 1; i < totalPages+1; i++){
		var pageid = 'page' + i;
		$('#contentText').append('<div class="pageSingle hide" id="' + pageid + '" pageID="' + i + '"><div class="lineNumbers"></div>' + allPages[i-1] + '</div>');		
	}

	$('.pageSingle[pageID=1]').show();
	main.WrapCharacters($('.pageSingle'));
	// Do the slider 
	$("#pageSlider").slider({
		value: 1,
		min: 1,
		max: totalPages,	
		step: 1,
		slide: function(event, ui) {
				$("#pageLabel").html("Page " + ui.value ); // Show page number
			$('.pageSingle').hide(); // Hide all pages
			$('.pageSingle[pageID=' + ui.value + ']').show(); // Show this page
		}
	});
	$("#pageLabel").html("Page " + $("#pageSlider").slider("value") + " of " + totalPages);
	main.LoadHighlights(); 

}
TextJS.prototype.LineNumbers = function() // Data about begin and end of selection
{
	var main = this;
	var totalLines = 1;
	$('.pageSingle').each(function() {
		var divHeight = $(this).height();
		var lineHeight = 30; // Set manually parseInt(document.getElementById(pageid).style.lineHeight);
		var lines = divHeight / lineHeight;
		var lines = Math.floor(lines);
		var maximum = totalLines + lines;
		for (x = totalLines; x < maximum; x++) {
			$(this).children('.lineNumbers').append('<div class="line">' + x + '</div> ');
		}
		totalLines = maximum;
	});
}
TextJS.prototype.GetSelectedLocation = function(element) // Data about begin and end of selection
{
	var main = this;
	var start = 0,
		end = 0;
	var sel, range, priorRange;
	if (typeof window.getSelection != "undefined") {
		range = window.getSelection().getRangeAt(0);
		priorRange = range.cloneRange();
		priorRange.selectNodeContents(element);
		priorRange.setEnd(range.startContainer, range.startOffset);
		start = priorRange.toString().length;
		end = start + range.toString().length;
	} else if (typeof document.selection != "undefined" && (sel = document.selection).type != "Control") {
		range = sel.createRange();
		priorRange = document.body.createTextRange();
		priorRange.moveToElementText(element);
		priorRange.setEndPoint("EndToStart", range);
		start = priorRange.text.length;
		end = start + range.text.length;
	}
	return {
		start: start,
		end: end
	};
}
TextJS.prototype.GetSelectedText = function() // Select text
{
	var main = this;
	var text;
	if (window.getSelection) {
		text = window.getSelection().toString();
	} else if (document.selection && document.selection.type != "Control") {
		text = document.selection.createRange().text;
	}
	return text;
}
TextJS.prototype.WrapCharacters = function(element) {
	var main = this;
	$(element).contents().each(function(index) {
		if (this.nodeType === 1) {
			main.WrapCharacters(this);
		} else if (this.nodeType === 3) {
			$(this).replaceWith($.map(this.nodeValue.split(''), function(c, d) {
				return '<span class="letter" letterID="' + d + '">' + c + '</span>';
			}).join(''));
		}
	});
}
TextJS.prototype.NewHighlight = function(hCode, hUser, hText, hPage, hBegin, hEnd, hType, hComment, hContent) {
// Use ajax to save a highlight
	var main = this;
	$.ajax({   // Ajax talking to the dbase.php file												
		type: "POST",
		url: "php/dbase.php",
		data: {
			hCode: hCode,
			hUser: hUser,
			hText: hText, 
			hPage: hPage, 
			hBegin: hBegin, 
			hEnd : hEnd, 
			hType: hType, 
			hComment: hComment,
			hContent: hContent,
			action: 'newHighlight'
		},
		success: function(data) { // If connection is successful . 
			console.log(data);
		},
		error: function() { // If connection is not successful.  
			console.log("The connection to dbase.php failed for saving new highlight.");
		}
	});
	
}
TextJS.prototype.AddMessage = function(hCode, hComment) {
// Use ajax to edit a highlight
	var main = this;
	$.ajax({   // Ajax talking to the dbase.php file												
		type: "POST",
		url: "php/dbase.php",
		data: {
			hCode: hCode,
			hComment: hComment,
			action: 'addMessage'
		},
		success: function(data) { // If connection is successful . 
			console.log(data);
		},
		error: function() { // If connection is not successful.  
			console.log("The connection to dbase.php failed for adding message to highlight.");
		}
	});
}
TextJS.prototype.DeleteHighlight = function(hCode) {
// Use ajax to delete a highlight
	var main = this;
	$.ajax({   // Ajax talking to the dbase.php file												
		type: "POST",
		url: "php/dbase.php",
		data: {
			hCode: hCode,
			action: 'deleteHighlight'
		},
		success: function(data) { // If connection is successful . 
			console.log(data);
		},
		error: function() { // If connection is not successful.  
			console.log("The connection to dbase.php failed for deleting highlight.");
		}
	});
}