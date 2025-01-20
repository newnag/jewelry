function add_type(){
    let data = new FormData()
    data.append('type_name',document.querySelector('#type_name').value)
    
    $.ajax({
      method: "POST",
      url: "functions/add-type.php",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){ 
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'เพิ่มข้อมูลสำเร็จ',
        }).then(()=>{
            location.href = "https://thavorn-jewelry.com/stock-gold/type-product/"
        })
      },
      error:function(textStatus){
        console.error(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
        })
        $('#modal-add').modal('hide')
      }
    })
}

function add_cate(){
    let data = new FormData()
    data.append('cate_name',document.querySelector('#cate_name').value)
    data.append('type_id',document.querySelector('#type_id').value)
    
    $.ajax({
      method: "POST",
      url: "functions/add-cate.php",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){ 
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'เพิ่มข้อมูลสำเร็จ',
        }).then(()=>{
            location.href = "https://thavorn-jewelry.com/stock-gold/type-product/"
        })
      },
      error:function(textStatus){
        console.error(textStatus.responseText)
        Swal.fire({
          icon: 'error',
          title: 'เกิดข้อผิดพลาด!',
          text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
        })
        $('#modal-add').modal('hide')
      }
    })
}

function get_type(){
    $.ajax({
      method: "POST",
      url: "functions/get-type.php",
      dataType: 'json',
      success:function(result){
        // console.log(result)
        const table = document.querySelector('#table-type tbody')
  
        for(i=0;i<result.length;i++){
            let tem = `
            <tr>
            <td class="no">${i+1}</td>
            <td class="type_product">${result[i].type_name}</td>
            <td>
                <div class="col-12">
                  <div class="row">
                      <div class="col-6"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit_type(${result[i].id})" data-toggle="modal" data-target="#modal-edit-type">แก้ไข</button></div>
                      <div class="col-6"><button type="button" class="btn btn-block bg-gradient-danger btn-cus-w" onclick="item_type_delete(${result[i].id})">ลบ</button></div>
                  </div>
                </div>
            </td>
            </tr>
            `
            table.insertAdjacentHTML('beforeend',tem)
        }
        
      },
      error:function(textStatus){
        const table = document.querySelector('#table-user tbody')
        let tem = `
          <tr>
            <td>ไม่มีข้อมูลสแดงผล</td>
          </tr>
          `
        table.insertAdjacentHTML('beforeend',tem)
        console.log(textStatus.responseText)
      }
    })
}

function get_cate(){
    $.ajax({
      method: "POST",
      url: "functions/get-cate.php",
      dataType: 'json',
      success:function(result){
        // console.log(result)
        const table = document.querySelector('#table-cate tbody')
  
        for(i=0;i<result.length;i++){
            let tem = `
            <tr>
            <td class="no">${i+1}</td>
            <td class="type_product">${result[i].cate_name}</td>
            <td class="type_product">${result[i].type_name}</td>
            <td>
                <div class="col-12">
                <div class="row">
                    <div class="col-6"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit_cate(${result[i].id})" data-toggle="modal" data-target="#modal-edit-cate">แก้ไข</button></div>
                    <div class="col-6"><button type="button" class="btn btn-block bg-gradient-danger btn-cus-w" onclick="item_cate_delete(${result[i].id})">ลบ</button></div>
                </div>
                </div>
            </td>
            </tr>
            `
            table.insertAdjacentHTML('beforeend',tem)
        }
        
      },
      error:function(textStatus){
        const table = document.querySelector('#table-cate tbody')
        let tem = `
          <tr>
            <td>ไม่มีข้อมูลสแดงผล</td>
          </tr>
          `
        table.insertAdjacentHTML('beforeend',tem)
        console.log(textStatus.responseText)
      }
    })
}

function get_select_type(){
    $.ajax({
        method: "POST",
        url: "functions/get-type.php",
        dataType: 'json',
        success:function(result){
          // console.log(result)
          const select = document.querySelector('#type_id')
    
          for(i=0;i<result.length;i++){
              let tem = `
              <option value="${result[i].id}">${result[i].type_name}</option>
              `
              select.insertAdjacentHTML('beforeend',tem)
          }
          
        },
        error:function(textStatus){
            const select = document.querySelector('#type_id tbody')
            let tem = `
                <tr>
                <td>ไม่มีข้อมูลสแดงผล</td>
                </tr>
                `
            select.insertAdjacentHTML('beforeend',tem)
            console.log(textStatus.responseText)
        }
    })
}

function edit_type(id){
  $.ajax({
    method: "POST",
    url: "functions/get-type-id.php",
    data:{id:id},
    dataType: 'json',
    success:function(result){
      // console.log(result)
      document.querySelector('#type_edit_name').value = result['type_name']
      document.querySelector('#type_edit_id').value = result['id']
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

function edit_cate(id){
  $('#type_id_cate_edit').empty()

  $.ajax({
    method: "POST",
    url: "functions/get-cate-id.php",
    data:{id:id},
    dataType: 'json',
    success:function(result){
      document.querySelector('#cate_edit_name').value = result['cate_name']
      document.querySelector('#cate_edit_id').value = result['id']

      const select = document.querySelector('#type_id_cate_edit')
      let tem1 = `
              <option value="${result.type_id}">${result.type_name}</option>
              `
              select.insertAdjacentHTML('beforeend',tem1)

      // query select type
      $.ajax({
        method: "POST",
        url: "functions/get-type.php",
        dataType: 'json',
        success:function(result){
          const select1 = document.querySelector('#type_id_cate_edit')
    
          for(i=0;i<result.length;i++){
              let tem2 = `
              <option value="${result[i].id}">${result[i].type_name}</option>
              `
              select1.insertAdjacentHTML('beforeend',tem2)
          }
          
        },
        error:function(textStatus){
            console.log(textStatus.responseText)
        }
      })

    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

function update_type(){
  let data = new FormData()
  data.append('type_name',document.querySelector('#type_edit_name').value)
  data.append('type_id',document.querySelector('#type_edit_id').value)

  $.ajax({
    method: "POST",
    url: "functions/update-type.php",
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
          location.href = "https://thavorn-jewelry.com/stock-gold/type-product"
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
      return false;
    }
  })
}

function update_cate(){
  let data = new FormData()
  data.append('cate_name',document.querySelector('#cate_edit_name').value)
  data.append('id',document.querySelector('#cate_edit_id').value)
  data.append('type_id',document.querySelector('#type_id_cate_edit').value)

  $.ajax({
    method: "POST",
    url: "functions/update-cate.php",
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
          location.href = "https://thavorn-jewelry.com/stock-gold/type-product"
      })
    },
    error:function(textStatus){
      console.error(textStatus.responseText)
      Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: 'ไม่สามารถเพิ่มข้อมูลได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
      })
      return false;
    }
  })
}

function item_type_delete(id){
  Swal.fire({
    title: 'คุณต้องการลบใช่หรือไม่?',
    showDenyButton: true,
    confirmButtonText: 'ลบ',
    denyButtonText: `ไม่ลบ`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "functions/delete-type.php",
        data: {
          id:id
        },
        success:function(result){
          if(result == "success"){
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: 'ลบข้อมูลสำเร็จ',
            }).then(()=>{
              location.reload();
            })
          }
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

function item_cate_delete(id){
  Swal.fire({
    title: 'คุณต้องการลบใช่หรือไม่?',
    showDenyButton: true,
    confirmButtonText: 'ลบ',
    denyButtonText: `ไม่ลบ`,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        method: "POST",
        url: "functions/delete-cate.php",
        data: {
          id:id
        },
        success:function(result){
          if(result == "success"){
            Swal.fire({
              icon: 'success',
              title: 'สำเร็จ!',
              text: 'ลบข้อมูลสำเร็จ',
            }).then(()=>{
              location.reload();
            })
          }
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


window.onload = ()=>{
    get_type()
    get_select_type()
    get_cate()
}