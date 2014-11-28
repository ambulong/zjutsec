$(function(){
	$(".nav-icon").hover(function(){
		$(this).addClass("hover");
		$(this).children(".nav-panel").show();
	},function(){
		$(this).removeClass("hover");
		$(this).children(".nav-panel").hide();
	});
	$(".nav-user").hover(function(){
		$(this).addClass("hover");
		$(this).children(".nav-user-panel").show();
	},function(){
		$(this).removeClass("hover");
		$(this).children(".nav-user-panel").hide();
	});
	$(".content-main .main-tabs .main-tabs-item").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	});
	$(".nav-user .nav-user-panel li").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	});
	$(".content-main .main-tabs .main-tabs-item").live("click",function(){
		window.location.href = $(this).children("a").attr("href");
	});
	$("#uploadAvatarBtn").live("click",function(){
		var formData = new FormData($("#uploadAvatarForm")[0]);
		$.ajax({
			type: "POST",
	        url: $("#uploadAvatarForm").attr("action"),
	        data: formData,
	        cache: false,
	        processData: false,
	        contentType: false,
	        success: function (data) {
	        	$("#uploadAvatarForm .avatar img").attr("src", data);
	        	$("#baseinfoform input[name='avatar']").attr("value", data);
	        }
	      });
	});
	$("#uploadImgBtn").live("click",function(){
		if($('input#inputFile').val() != ""){
			var formData = new FormData();
			formData.append('image', $('input#inputFile')[0].files[0]);
			$.ajax({
				type: "POST",
		        url: $("#uploadImgForm").attr("action"),
		        data: formData,
		        cache: false,
		        processData: false,
		        contentType: false,
		        success: function (data) {
		        	$("textarea[name='desc']").append("&lt;img src=\""+data+"\"&gt;");
		        	$('input#inputFile').val("");
		        }
		      });
		}else{
			alert("请选择文件");
		}
	});
});