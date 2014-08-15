function validateForm(id) {
	var inputs = $("#" + id + " .requiredInput");
	var selects = $("#" + id + " .requiredSelect");
	var temp = true;
	inputs.each(function(index) {
		var input = inputs[index];
		if (input.value.length <= 0) {
			temp = false;
		}
	});
	selects.each(function(index) {
		var select = selects[index];
		if (select.value == "-1") {
			temp = false;
		}
	});
	if (!temp) {
		alert("请完成页面必填（选）信息再提交");
	}
	return temp;
}
function checkForm(id) {

	if (validateForm(id)) {
		$("#" + id).submit();
	}
}