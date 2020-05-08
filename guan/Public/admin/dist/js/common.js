$(function() {
	
	$('.upload_button').each(function(){
	
	   ajaxUpload(
			$(this).attr('id'), //上传的按钮id名称
			1024,  //允许上传的文件大小（单位：kb）
			"/admin.php", //提交服务器端地址
			"the_files", //提交服务器文件表单名称
			"$('#'+obj.fileinput).val(obj.filepath);$('#'+obj.imgarea).attr('src',obj.filepath);", //上传成功后执行的 js callback
			"loading"  //loading 图片id
        );
	
	});
  
});
function errPost(msg,id,type){
   //msgtype = 'error';
   var tipstype = arguments[2]?arguments[2]:0;
   if(tipstype == 1){
      //msgtype = 'ok';  
      $.fn.tips({type:'ok',content:msg,url:id});
   }else{
      $.fn.tips({type:'ok',content:msg});   
      $('#'+id).focus().parents('.form-group').addClass('has-error');
   }
   return false;
}
function ajaxUpload(id_name, filesize, url, filename, callback) {
    
	var button = $('#'+id_name), interval;
    var fileType = "pic", fileNum = "one";
	
	var fileinput = button.attr('data-input');
	var imgarea = button.attr('data-img');
	//alert(imgarea);
    new AjaxUpload(button,{
        action: url+'/Doc/upimg/someKey/'+fileinput+'/otherKey/'+imgarea,
        name: filename,
        onSubmit : function(file, ext){
            if(fileType == "pic") {
                if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
                    this.setData({
                        'info': '文件类型为图片'
                    });
                } else {
                    alert('提示：您上传的是非图片类型！');
                    return false;
                }
            }
            $("#"+imgarea).attr('src','/Public/admin/dist/img/loading.gif');
            if(fileNum == 'one') this.disable();
        },
        onComplete: function(file, response){
            eval("var obj="+response);
            if (obj.type == 'ok') {
                eval(callback);
            } else {
                switch (response) {
                    case '1':
                        alert('提示：上传失败，图片不能大于'+filesize+'k！');
                        break;
                    case '3':
                        alert('提示：图片只有部分文件被上传，请重新上传！');
                        break;
                    case '4':
                        alert('提示：没有任何文件被上传！');
                        break;
                    case '5':
                        alert('提示：非图片类型，请上传jpg|png|gif图片！');
                        break;
                    default:
                        alert('提示：上传失败，错误未知，请您及时联系网站客服人员！');
                        break;
                }
            }
            window.clearInterval(interval);
            this.enable();
        }
    });
}