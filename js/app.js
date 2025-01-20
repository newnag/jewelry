function show_loading(){
	document.querySelector('.loading-section').classList.add('show')
}

function hide_loading(){
	document.querySelector('.loading-section').classList.remove('show')
}

function logout(){
	$.ajax({
		url: "../../function-main/logout.php",
		method: "POST",
		beforeSend: function(){
				show_loading()
		},
		success: function(result){
				if(result == true){
						Swal.fire({
								icon: 'success',
								title: 'สำเร็จ!',
								text: 'ออกจากระบบสำเร็จ',
						}).then(()=>{
								location.href = "https://thavorn-jewelry.com/management/"
						})
				}
				else{
						Swal.fire({
								icon: 'error',
								title: 'เกิดข้อผิดพลาด!',
								text: 'ไม่สามารถออกจากระบบได้',
						}).then(()=>{
								return false
						})
				}
				
		},
		error: function(textStatus){
				console.error(textStatus)
		},
		complete: function(){
				hide_loading()
		}
	})
}