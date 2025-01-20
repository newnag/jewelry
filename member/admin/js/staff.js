function add(){
  let data = new FormData()
  data.append('username',document.querySelector('#username').value)
  data.append('password',document.querySelector('#password').value)
  data.append('email',document.querySelector('#email').value)
  data.append('role',document.querySelector('#role').value)
  
  $.ajax({
    method: "POST",
    url: "functions/add-staff.php",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    success:function(result){ 
      console.log(result)
      Swal.fire({
          icon: 'success',
          title: 'สำเร็จ!',
          text: 'เพิ่มข้อมูลสำเร็จ',
      }).then(()=>{
          location.reload()
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
    }
  })
}

function item_delete(id){
  Swal.fire({
    title: 'คุณต้องการลบใช่หรือไม่?',
    showDenyButton: true,
    confirmButtonText: 'ลบ',
    denyButtonText: `ไม่ลบ`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "functions/delete-user.php",
        data: {
          id:id
        },
        success:function(result){
          Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'ลบข้อมูลสำเร็จ',
          }).then(()=>{
            location.reload();
          })
        },
        error:function(textStatus){
          console.log(textStatus.responseText)
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถลบข้อมูลได้',
          })
        }
      })
    }
    else if (result.isDenied) {
      return false
    }
  })
}

function change_pass(id){
  document.querySelector('#id_change_pass').value = id
}

function edit_pass(){
  let password = document.querySelector('#password_change').value
  let pass_con = document.querySelector('#password_con').value

  if(password == pass_con){
    let data = new FormData()
    data.append('password',document.querySelector('#password_change').value)
    data.append('id',document.querySelector('#id_change_pass').value)
  
    $.ajax({
      method: "POST",
      url: "functions/change-pass.php",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){ 
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'แก้ไขข้อมูลสำเร็จ',
        }).then(()=>{
            location.reload()
        })
      },
      error:function(textStatus){
        console.error(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถแก้ไขข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
        })
      }
    })
  }
  else{
    Swal.fire({
      icon: 'warning',
      title: 'แจ้งเตือน!',
      text: 'คุณกรอกรหัสผ่านไม่ตรงกัน',
    })
  }
}

function change_role(id,role){
  $("#change_role").empty();
  document.querySelector('#id_change_role').value = id
  const select = document.querySelector('#change_role')
  let txt_opt = ""
  let opt_other = ""

  if(role == 1){
    txt_opt = "Owner"

    opt_other = `
    <option value="2">Manager</option>
    <option value="3">Employee</option>
    `
  }
  else if(role == 2){
    txt_opt = "Manager"
    opt_other = `
    <option value="1">Owner</option>
    <option value="3">Employee</option>
    `
  }
  else if(role == 3){
    txt_opt = "Employee"
    opt_other = `
    <option value="1">Owner</option>
    <option value="2">Manager</option>
    `
  }
  else{
    return false
  }

  let options = `<option value="${role}">${txt_opt}</option>`
  select.insertAdjacentHTML('beforeend',options)
  select.insertAdjacentHTML('beforeend',opt_other)
}

function edit_role(){
  let data = new FormData()
    data.append('role',document.querySelector('#change_role').value)
    data.append('id',document.querySelector('#id_change_role').value)
  
    $.ajax({
      method: "POST",
      url: "functions/change-role.php",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){ 
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'แก้ไขข้อมูลสำเร็จ',
        }).then(()=>{
            location.reload()
        })
      },
      error:function(textStatus){
        console.error(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถแก้ไขข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
        })
      }
    })
}