function add(){
    let data = new FormData()
    data.append('supplier_name',document.querySelector('#supplier_name').value)
    data.append('type_supplier',document.querySelector('#type_supplier').value)
    
    $.ajax({
      method: "POST",
      url: "functions/add-item.php",
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
            location.href = "https://thavorn-jewelry.com/stock-gold/supplier/"
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

function edit(id){
    $.ajax({
      method: "POST",
      url: "functions/get-supplier-id.php",
      data:{id:id},
      dataType: 'json',
      success:function(result){
        // console.log(result)
        // $('#supplier_name_edit').empty()
        document.querySelector('#supplier_name_edit').value = result['name']
        document.querySelector('#tax_id_edit').value = result['tax_id']
        document.querySelector('#edit_id').value = result['id']
        const select = document.querySelector('#type_supplier_edit')
        let txt = ""
        let option = ``
        if(result['type_supplier'] == 1){
          txt = "ทอง"
          option = `<option value="${result['type_supplier']}">${txt}</option>`
        }
        else if(result['type_supplier'] == 2){
          txt = "กรอบพระ"
          option = `<option value="${result['type_supplier']}">${txt}</option>`
        }
        else if(result['type_supplier'] == 3){
          txt = "เครื่องประดับ"
          option = `<option value="${result['type_supplier']}">${txt}</option>`
        }
        select.value = result['type_supplier'];
        // select.insertAdjacentHTML('afterbegin',option)
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
      }
    })
}

function update(){
    let data = new FormData()
    data.append('name',document.querySelector('#supplier_name_edit').value)
    data.append('type_supplier_edit',document.querySelector('#type_supplier_edit').value)
    data.append('tax_id_edit',document.querySelector('#tax_id_edit').value)
    data.append('id',document.querySelector('#edit_id').value)
  
    $.ajax({
      method: "POST",
      url: "functions/update.php",
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
            location.href = "https://thavorn-jewelry.com/stock-gold/supplier"
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
          url: "functions/item-delete.php",
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