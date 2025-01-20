function search_customer_data(){
  let customer_id = document.querySelector('#customer_id_input')

  if(customer_id.value != ""){
    $.ajax({
      method: "POST",
      url: "functions/get-user.php",
      data:{id:customer_id.value},
      dataType: 'json',
      success:function(result){
        location.href = "https://thavorn-jewelry.com/member/history/history.php?id="+result.id
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถค้นหาข้อมูลได้',
        })
      }
    })
  }
  else{
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน!',
      text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
    })
  }
}