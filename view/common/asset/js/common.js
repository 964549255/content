/* 弹出层 */
function iframe(title, url, callback) {
	layui.use(["layer"], function() {
		let layer = layui.layer
		layer.open({
			type: 2,
			content: url,
			title: title,
			area: ["800px", "600px"],
			btn: ["提交", "取消"],
			shade: [0.8, "#000"],
			id: "iframe",
			maxmin: true,
			resize: false,
			scrollbar: false,
			shadeClose: true,
			yes: callback,
		})
	})
}

/* 消息层 */
function msg(content) {
	layui.use(["layer"], function() {
		let layer = layui.layer
		layer.msg(content, {
			time: 1000
		})
	})
}

/* 日期组件 */
function laydate(elem, type = "date") {
	layui.use(["laydate"], function() {
		let laydate = layui.laydate
		laydate.render({
			elem: elem,
			type: type
		})
	})
}

/* 上传组件 */
function uploadImage(elem, url, size, callback) {
	layui.use(["upload", "layer"], function() {
		let upload = layui.upload
		let layer = layui.layer
		upload.render({
			elem: elem,
			url: url,
			accept: "images",
			acceptMime: "image/*",
			size: size,
			done: callback,
			before: function() {
				layer.load(1)
			}
		})
	})
}

/* 修改选中 */
function changeAll() {
	$("input[type='checkbox'][name='deleteId']").prop("checked", $("#all").prop("checked"))
}

/* 删除选中 */
function deleteAll(url, msg) {
	if (confirm(msg)) {
		params = {
			ids: $.map($("input[type='checkbox'][name='deleteId']:checked"), function(value, index) {
				return $(value).val()
			})
		}
		$.get(url, params, function(data) {
			if (data == true) {
				location.reload()
			}
		})
	}
}

/* 修改排序 */
function changeSort(_this, id, url) {
	params = {
		id: id,
		sort: $(_this).val()
	}
	$.get(url, params, function(data) {
		if (data == true) {
			location.reload()
		}
	})
}

/* 修改状态 */
function changeStatus(status, id, url, msg) {
	if (confirm(msg)) {
		params = {
			id: id,
			status: status
		}
		$.get(url, params, function(data) {
			if (data == true) {
				location.reload()
			}
		})
	}
}

/* 删除 */
function destroy(id, url, msg) {
	if (confirm(msg)) {
		params = {
			id: id
		}
		$.get(url, params, function(data) {
			if (data == true) {
				location.reload()
			}
		})
	}
}

/* 判断为空 */
function isNull(data) {
	if (data == null || data == [] || data == "" || data == "undefined") {
		return true
	} else {
		return false
	}
}
