var pageNav = pageNav || {};
// currentPage为当前页码,totalPage为总页数
pageNav.nav = function(currentPage, totalPage) {
	// 只有一页,直接显示1
	if (totalPage <= 1) {
		this.currentPage = 1;
		this.totalPage = 1;
		return this.currentPageHtml(1);
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
		re += this.notCurrentPageHtml(currentPage - 1, totalPage, "上一页");
		// 总是显示第一页页码
		re += this.notCurrentPageHtml(1, totalPage, "1");
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
		re += this.notCurrentPageHtml(i, totalPage);
	}
	;
	re += this.currentPageHtml(currentPage);
	for ( var i = currentPage + 1; i <= end; i++) {
		re += this.notCurrentPageHtml(i, totalPage);
	}
	;
	if (end < totalPage) {
		re += "...";
	}
	;
	if (currentPage < totalPage) {
		re += this.notCurrentPageHtml(currentPage + 1, totalPage, "下一页");
	}
	;
	return re;
};
// 显示非当前页
pageNav.notCurrentPageHtml = function(pageNum, totalPage, showPageNum) {
	showPageNum = showPageNum || pageNum;
	pageNum = pageNum - 1;
	var H = "<a href='" + pageNav.url + "currentPage=" + pageNum
			+ "&countPerPage=" + countPerPage + "' class='pageNum'>"
			+ showPageNum + "</a>";
	return H;
};
// 显示当前页
pageNav.currentPageHtml = function(pageNum) {
	var H = " <span class='cPageNum'>" + pageNum + "</span> ";
	return H;
};
// 输出页码,可根据需要重写此方法
pageNav.go = function() {
	var currentPage = arguments[0];
	var totalPage = arguments[1];
	var elementId = "pageNav";
	if (arguments.length == 3) {
		elementId = arguments[2];
	}
	$("#" + elementId).html(this.nav(currentPage, totalPage));

};
