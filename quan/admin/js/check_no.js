


//检测物品编号是否重复
function chk_goods_no(){
	//alert("11111111");
	var no = $('#no').val();
	
		$.ajax({
			type:'GET',
			url:'check.php',
			data:'do=chk_goods_no&no='+no,
			beforeSend: function (){
				$('#noerror').hide();
				
			},
			complete: function (){
			
			},
			success: function(data){
				
				switch(data)
				{	
					case '1':
						$('#noerror').html("<font color='#FF0000'>物品编号重复，请重新输入</font>");
						$('#noerror').show();
						$("#no").css({ color: "blue", background: "red" });
						break;
					case '0':
						$('#noerror').hide();
						$("#no").css({ color: "blue", background: "white" });
						break;
				}
   		    }
	});
}

//检测道具编号是否重复
function chk_goods_props_no(){
	//alert("11111111");
	var no = $('#no').val();
	
		$.ajax({
			type:'GET',
			url:'check.php',
			data:'do=chk_goods_props_no&no='+no,
			beforeSend: function (){
				$('#noerror').hide();
				
			},
			complete: function (){
			
			},
			success: function(data){
				
				switch(data)
				{	
					case '1':
						$('#noerror').html("<font color='#FF0000'>物品编号重复，请重新输入</font>");
						$('#noerror').show();
						$("#no").css({ color: "blue", background: "red" });
						break;
					case '0':
						$('#noerror').hide();
						$("#no").css({ color: "blue", background: "white" });
						break;
				}
   		    }
	});
}