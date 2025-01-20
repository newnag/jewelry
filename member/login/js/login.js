function login(){
    const data = {
        username : document.querySelector('#username_input').value,
        password : document.querySelector('#password_input').value,
        remember : document.querySelector('#remember').checked // true || false
    }
    
    $.ajax({
        url: "functions/login.php",
        method: "POST",
        data: data,
        beforeSend: function(){
            show_loading()
        },
        success: function(result){
            if(result == true){
                // console.log(111)
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'คุณเข้าสู่ระบบสำเร็จ',
                }).then(()=>{
                    location.href = "https://thavorn-jewelry.com/member/dashboard/"
                })
            }
            else{
                // console.log(222)
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'username หรือ password อาจจะผิดพลาด',
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