function search_customer_data(){
    const user_id = document.querySelector('#customer_id_input')

    if(user_id.value != ""){
        $.ajax({
          method: "POST",
          url: "functions/get-user.php",
          data:{id:user_id.value},
          dataType: 'json',
          success:function(result){
            location.href = "https://thavorn-jewelry.com/member/history-reward/history.php?id="+result.id
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