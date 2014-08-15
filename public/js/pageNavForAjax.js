var pageNavForAjax = pageNavForAjax || {};
// currentPage为当前页码,totalPage为总页数
pageNavForAjax.nav = function(currentPage, totalPage, block) {
	// 只有一页,不显示
	if (totalPage <= 1) {
		return "";
	}
	if (totalPage < currentPage) {
		currentPage = totalPage;
	}
	var re = "";
	// 第一页
	if (currentPage <= 1) {
		currentPage = 1;
	} else {
		// 非第一页
		re += this.notCurrentPageHtml(currentPage - 1, totalPage, "上一页", block);
		// 总是显示第一页页码
		re += this.notCurrentPageHtml(1, totalPage, "1", block);
	}
	// 校正页码
	this.currentPage = currentPage;
	this.totalPage = totalPage;

	// 开始页码
	var start = 2;
	var end = (totalPage < 9) ? totalPage : 9;
	// 是否显示前置省略号,即大于10的开始页码
	if (currentPage >= 7) {
		re += "...";
		start = currentPage - 4;
		var e = currentPage + 4;
		end = (totalPage < e) ? totalPage : e;
	}
	for ( var i = start; i < currentPage; i++) {
		re += this.notCurrentPageHtml(i, totalPage, i, block);
	}
	;
	re += this.currentPageHtml(currentPage);
	for ( var i = currentPage + 1; i <= end; i++) {
		re += this.notCurrentPageHtml(i, totalPage, i, block);
	}
	;
	if (end < totalPage) {
		re += "...";
	}
	;
	if (currentPage < totalPage) {
		re += this.notCurrentPageHtml(currentPage + 1, totalPage, "下一页", block);
	}
	;
	return re;
};
// 显示非当前页
pageNavForAjax.notCurrentPageHtml = function(pageNum, totalPage, showPageNum,block) {
	showPageNum = showPageNum || pageNum;
	pageNum = pageNum - 1;

	var H = "<a  href=javascript:pageNavForAjax.onClick('" + pageNum + "','"
			+ countPerPage + "','" + block + "') class='pageNum'>"
			+ showPageNum + "</a>";
	return H;
};
// 显示当前页
pageNavForAjax.currentPageHtml = function(pageNum) {
	var H = " <span class='cPageNum'>" + pageNum + "</span> ";
	return H;
};
pageNavForAjax.onClick = function(currentPage, countPerPage, block) {
	var url = pageNavForAjax.url + "currentPage=" + currentPage
			+ "&countPerPage=" + countPerPage;
	$.getJSON(url, {}, function(data) {
		$(block).html(data);
        totalPage = parseInt($('a#ajaxAttrProps').attr("totalPage"));
        count = parseInt($('a#ajaxAttrProps').attr("count"));
        pageNavForAjax.go((parseInt(currentPage)+1)%countPerPage, totalPage, block);
        showLowerBound= count==0 ? 0:(currentPage)*countPerPage+1;
        showUpperBound= (parseInt(currentPage)+1)*countPerPage;
        showUpperBound= (count>=showUpperBound) ?  showUpperBound : count;
        $('#tableInfo').html("当前范围："+showLowerBound+"~"+showUpperBound+"/ 共"+count+"条数据");
	});
};
// 输出页码,可根据需要重写此方法
pageNavForAjax.go = function() {
	var currentPage = arguments[0];
	var totalPage = arguments[1];
	var block = "#main-unit-right";
	if (arguments.length == 3) {
		block = arguments[2];
	}
	var elementId = "pageNavForAjax";
	if (arguments.length == 4) {
		elementId = arguments[3];
	}
	$("#" + elementId).html(this.nav(currentPage, totalPage, block));
};
