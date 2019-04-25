refreshLinkTypeControls = function() {
	var linkType = $('#linkType').val();
	$('#linkTypePage').toggle(linkType == 1);
	$('#linkTypeExternal').toggle(linkType == 2);
}

$(document).ready(function() {
	$('#linkType').change(refreshLinkTypeControls);
	refreshLinkTypeControls();
});