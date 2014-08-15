function topology(dataIn, outDivWidth, outDivHeight) {
	var data = dataIn.networks; // 得到节点数据
	var data_length = data.length; // 得到有几个网段
	var max_width = 0; // 所有网段一起占的总宽，供后面画线的画布用
	var max_height = 0; // 所有网段一起占的总高，供后面画线的画布用
	var outside_div = d3.select("#topo").append("div").style("position",
			"relative"); // 外围div，包含所有网段和网段之间的连线
	outside_div.attr("width", outDivWidth).attr("height", outDivHeight);// 根据传入参数确定外围div的宽和高
	for ( var di = 0; di < data_length; di++) { // 按网段个数遍历每个网段
		var name = data[di].name;
		var parameter = data[di].parameter; // 可选参数，如果JSON中没有定义，则应是undefined
		var nodes = data[di].nodes; // 该网段节点
		// var windowWidth = window.screen.width - 42;
		// //浏览器宽，-42是因为考虑到右边会有滚动条，这里应该要改
		// var windowHeight = window.screen.height - 150;
		// //浏览器高，-150是因为考虑到浏览器上面的菜单，这里应该要改
		var wleft;
		var wtop;
		var wwidth;
		var wheight;
		if (parameter == undefined) { // 没有定义字段parameter，则默认为占满外围div；
			wleft = 0;
			wtop = 0;
			wwidth = outDivWidth;
			wheight = outDivHeight;
		} else { // 定义有该字段则按定义的百分比
			wleft = outDivWidth * Number(parameter[0]) / 100;
			wtop = outDivHeight * Number(parameter[1]) / 100;
			wwidth = outDivWidth * Number(parameter[2]) / 100;
			wheight = outDivHeight * Number(parameter[3]) / 100;
		}
		if ((wleft + wwidth) > max_width) { // 判断所有网段一起占的总宽有没有变大
			max_width = wleft + wwidth;
		}
		if ((wtop + wheight) > max_height) { // 判断所有网段一起占的总高有没有变大
			max_height = wtop + wheight;
		}
		var main_div = outside_div.append("div") // 每个网段都有自己对应的div
		.attr("id", name + "_main_div") // 网段div的id根据网段的名字动态生成
		.style("position", "absolute").style("left", wleft + "px") // 按照parameter参数确定该div的位置和宽高
		.style("top", wtop + "px").style("width", wwidth + "px").style(
				"height", wheight + "px");
		var text_line_svg = main_div // 该div用来放该网段节点显示名字和连线
		.append("svg").attr("id", name + "_main_svg").attr("width", "100%") // 该svg占满所在div
		.attr("height", "100%");
		var rect = text_line_svg // 添加一个背景区分不同网段
		.append("rect").attr("x", "1%").attr("y", "1%").attr("width", "98%")
				.attr("height", "98%").attr("rx", 5) // 矩形圆角
				.attr("ry", 5) // 矩形圆角
				.style("fill", "#EDEDED") // 矩形底色
				.style("fill-opacity", 0.14) // 矩形底色透明度
				// .style("stroke","#8B8878") //矩形边颜色
				.attr("stroke-width", 2); // 矩形边宽度
		var level_depth = nodes.length;
		for ( var i = 0; i < level_depth; i++) { // 每个网段的节点数据是分层定义的，按层次来画
			var level = nodes[i].level; // level遍历在确定该层节点所在高度有用
			var levelNodes = nodes[i].levelNodes;
			var levelNodes_length = levelNodes.length;
			var sub_div = main_div // 每层节点都占据一个div，是对应网段div的子div
			.append("div").attr("id", name + "_level" + level + "_pngs_div");
			var imgs = sub_div // 绑定该层的节点数据，每个数据对应一个img
			.selectAll("img").data(levelNodes).enter().append("img").attr(
					"src", function(d) { // 确定img对应的源文件
						var src_name = '/images/topoPic/' + d.type + '.png';
						return src_name;
					}).attr("alt", "picture load fail").attr("id", function(d) {
				return d.ID
			}).attr("width", 50 + "px") // 调整img宽度，这里方便起见统一调整宽为25px,高则按原图片比例变化
			.attr("title", function(d) {
				return "type:" + d.type + "\n" + "id:" + d.ID
			}).attr(
					"cx",
					function(d, index) {
						return (wwidth / levelNodes_length) * (index + 0.4)
								+ this.width / 2
					})// cx是图片中心对应的x坐标的意思
			.attr(
					"cy",
					function() {
						return (wheight / level_depth) * (level - 0.3)
								- this.height + this.height / 2
					})// 画节点连线的时候用到cx、cy
			.attr("level", level).each(function(d, index) {
				$(this).css({
					position : "absolute",
					left : (wwidth / levelNodes_length) * (index + 0.4), // 这里确定每个img的left和top坐标
					top : (wheight / level_depth) * (level - 0.3) - this.height
				});
			});
			// 文字部分
			// 主svg上放一个svg用于显示文字
			var levelText_svg = text_line_svg.append("svg").attr("id",
					name + "_level" + level + "_text_svg").selectAll("text")
					.data(levelNodes).enter().append("text").attr("font-size",
							"12") // 文本字体大小
					.attr(
							"y",
							function(d) { // x和y是文本所在的坐标
								var el = document.getElementById(d.ID);
								return Number(d3.select(el).attr("cy"))
										+ el.height / 2 + 10;
							}).attr("x", function(d) {
						var el = document.getElementById(d.ID);
						return d3.select(el).attr("cx") - el.width;
					}).text(function(d) {
						return d.name;
					}).attr("fill", "blue") // 文本的颜色
					.attr("title", function(d) {
						return d.name
					}).on("mouseover", function() {
						d3.select(this).transition(100).attr("fill", "red")
					}).on("mouseout", function() {
						d3.select(this).transition(100).attr("fill", "blue")
					});
		}
		;
		// 图像之间的连线部分
		// 根据ID画线
		var links = data[di].links;
		var links_svg = text_line_svg.append("svg").attr("id", "lines");
		var lines = links_svg.selectAll("line").data(links).enter().append(
				"line").attr("bandwidth", function(d) {
			return d.bandwidth;
		}).attr("stroke", "black") // 一个网段内节点之间的连线的颜色
		.attr("stroke-width", "1") // 连线的粗细
		.on("mouseover", function() {
			d3.select(this).transition(100).attr("stroke", "red")
		}).on("mouseout", function() {
			d3.select(this).transition(100).attr("stroke", "black")
		}).attr(
				"title",
				function(d) {
					return "endpoint1_ID:" + d.endpoint1_ID + "\n"
							+ "endpoint2_ID:" + d.endpoint2_ID + "\n"
							+ "bandwidth:" + d.bandwidth
				}).each(
				function(d) { // 该函数是为了根据连线两端节点的层次大小，将连线端点定在节点img的下方中心、上方中心或图片中心
					var endpoint1 = document.getElementById(d.endpoint1_ID);
					var endpoint2 = document.getElementById(d.endpoint2_ID);
					var level1 = d3.select(endpoint1).attr("level");
					var level2 = d3.select(endpoint2).attr("level");
					if (Number(level1) == Number(level2)) {
						d3.select(this).attr("x1", function() {
							return d3.select(endpoint1).attr("cx");
						}).attr("y1", function() {
							return d3.select(endpoint1).attr("cy");
						}).attr("x2", function() {
							return d3.select(endpoint2).attr("cx");
						}).attr("y2", function() {
							return d3.select(endpoint2).attr("cy");
						});
					} else {
						var x1 = d3.select(endpoint1).attr("cx");
						var y1 = d3.select(endpoint1).attr("cy");
						var height1 = endpoint1.height;
						var x2 = d3.select(endpoint2).attr("cx");
						var y2 = d3.select(endpoint2).attr("cy");
						var height2 = endpoint2.height;
						if (Number(y1) > Number(y2)) {
							d3.select(this).attr("x1", x1).attr("x2", x2).attr(
									"y1", y1 - height1 / 2).attr("y2",
									Number(y2) + height2 / 2);
						} else {
							d3.select(this).attr("x1", x1).attr("x2", x2).attr(
									"y1", Number(y1) + height1 / 2).attr("y2",
									y2 - height2 / 2);
						}
					}
				});
	}
	// 处理不同网络之间的连线
	var linksBetweenNetworks = dataIn.linksBetweenNetworks;
	var linksBetweenNetworks_svg = outside_div.append("svg").style("position",
			"absolute").style("z-index", "-9").attr("id",
			"linksBetweenNetworks_svg").attr("width", max_width).attr("height",
			max_height);
	var linksBTN = linksBetweenNetworks_svg.selectAll("line").data(
			linksBetweenNetworks).enter().append("line").attr("bandwidth",
			function(d) {
				return d.bandwidth;
			}).attr("stroke", "green").attr("stroke-width", "1");
	linksBTN.attr("x1", function(d) {
		var endpoint1 = document.getElementById(d.endpoint1_ID);
		var answer = GetAbsoluteLocation(endpoint1);
		return answer.absoluteLeft + answer.offsetWidth / 2;
		// return d3.select(endpoint1).attr("cx");
	}).attr("y1", function(d) {
		var endpoint1 = document.getElementById(d.endpoint1_ID);
		var answer = GetAbsoluteLocation(endpoint1);
		return answer.absoluteTop + answer.offsetHeight / 2;
		// return d3.select(endpoint1).attr("cy");
	}).attr("x2", function(d) {
		var endpoint2 = document.getElementById(d.endpoint2_ID);
		var answer = GetAbsoluteLocation(endpoint2);
		return answer.absoluteLeft + answer.offsetWidth / 2;
		// return d3.select(endpoint2).attr("cx");
	}).attr("y2", function(d) {
		var endpoint2 = document.getElementById(d.endpoint2_ID);
		var answer = GetAbsoluteLocation(endpoint2);
		return answer.absoluteTop + answer.offsetHeight / 2;
		// return d3.select(endpoint2).attr("cy");
	});
}

// 因为有很多网段，每个网段的子节点的坐标参数都是相对它的父亲的，而不是整个document，该函数可计算dom元素相对整个文档的坐标
function GetAbsoluteLocation(element) {
	if (arguments.length != 1 || element == null) {
		return null;
	}
	var offsetTop = element.offsetTop;
	var offsetLeft = element.offsetLeft;
	var offsetWidth = element.offsetWidth;
	var offsetHeight = element.offsetHeight;
	while (element = element.offsetParent) {
		offsetTop += element.offsetTop;
		offsetLeft += element.offsetLeft;
	}
	return {
		absoluteTop : offsetTop,
		absoluteLeft : offsetLeft,
		offsetWidth : offsetWidth,
		offsetHeight : offsetHeight
	};
}