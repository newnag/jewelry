/** 
 * getLine_user
 * @property  {string} grant_type - authorization_code
 * @property  {string} code - code from line auth
 * @property  {string} redirect_uri - url callback from line develop channel
 * @property  {string} client_id - client_id from line develop channel
 * @property  {string} client_secret - client_secret from line develop channel
 * @property  {string} id_token - id_token is result from token
 * @property  {string} sub - line user id from verify token_id
*/
function getLine_user(){
    let data_line = {
        grant_type: "authorization_code",
        code: document.querySelector('#code').value,
        redirect_uri: "https://thavorn-jewelry.com/profile/index.php",
        client_id: "1657201123",
        client_secret: "d048543caddc0255f028a64c441fbea0"
    }

    $.ajax({
        method: "POST",
        url: "https://api.line.me/oauth2/v2.1/token",
        data: data_line,
        success:function(result){ 
            $.ajax({
                method: "POST",
                url: "https://api.line.me/oauth2/v2.1/verify",
                data: {
                    id_token: result.id_token,
                    client_id: "1657201123"
                },
                success: function(result){
                    console.log(result)
                    localStorage.setItem('line_avatar',result.picture)
                    localStorage.setItem('line_name',result.name)
                    localStorage.setItem('line_exp',result.exp)
                },
                error:function(textStatus){
                    console.error(textStatus.responseText)
                    location.href = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1657201123&redirect_uri=https://thavorn-jewelry.com/profile/index.php&state=12345abcde&scope=profile%20openid&nonce=09876xyz"
                }
            })
        },
        error:function(textStatus){
            console.error(textStatus.responseText)
            location.href = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1657201123&redirect_uri=https://thavorn-jewelry.com/profile/index.php&state=12345abcde&scope=profile%20openid&nonce=09876xyz"
        }
    })

    setTimeout(() => {
        set_LineProfile()
    }, 500);
}

function check_line_access(){
    let now = Math.round((new Date()).getTime() / 1000)
    let exp = +localStorage.getItem('line_exp') 

    if(exp != ""){
        if(now < exp){
            set_LineProfile()
        }
        else{
            getLine_user()
        }
    }
    else{
        getLine_user()
    }
}

function set_LineProfile(){
    document.querySelector('.avatar img').src = localStorage.getItem('line_avatar')
    document.querySelector('.line-name').textContent = localStorage.getItem('line_name')
}

function logout(){
	$.ajax({
		url: "functions/logout.php",
		method: "POST",
		success: function(result){
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'ออกจากระบบสำเร็จ',
            }).then(()=>{
                location.href = "https://thavorn-jewelry.com/register/"
            })	
		},
		error: function(textStatus){
            console.error(textStatus)
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถออกจากระบบได้',
            }).then(()=>{
                return false
            })
		},
	})
}

function update(){
    const date_dob = convert_date_forDB(document.querySelector('#dob').value)
  
    let data = new FormData()
    data.append('fullname',document.querySelector('#name').value)
    data.append('sex',document.querySelector('#sex').value)
    data.append('dob',date_dob)
    data.append('address',document.querySelector('#address').value)
    data.append('line_id',document.querySelector('#line_id').value)
    data.append('email',document.querySelector('#email').value)
    data.append('id',document.querySelector('#user_id').value)
  
    $.ajax({
      method: "POST",
      url: "functions/update-user.php",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success:function(result){
        if(result == "success"){
          Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: 'บันทึกข้อมูลสำเร็จ',
          }).then(()=>{
            location.href = "https://thavorn-jewelry.com/profile/"
          })
        }
        else{
          console.error(result)
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถแก้ไขวิชาได้',
          })
          $('#modal-edit').modal('hide')
        }
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
      }
    })
}


/**
 * @param {string} rawDate convert date from datepicker to formate for DB
 */
function convert_date_forDB(rawDate){
    const con_date = rawDate.split("/")
    let year_con = parseInt(con_date[2])-543
    let date = `${year_con}-${con_date[1]}-${con_date[0]}`
    return date
}


/**
 * 
 * @param {int} position position input file
 */
function select_pic(){
    if(position == 1){
        document.querySelector('#file1').click()
    }
    else if(position == 2){
        document.querySelector('#file2').click()
    }
    else{
        return false
    }
}

document.querySelector('#file1').addEventListener('change',()=>{
    show_simple(document.querySelector('#file1').files[0],1)
})
document.querySelector('#file2').addEventListener('change',()=>{
    show_simple(document.querySelector('#file2').files[0],2)
})

/**
 * 
 * @param {object} file file is select picture
 * @param {int} position position to save picture id_card or bookbank  1 = id_card , 2 = bookbank
 */
function show_simple(file,position){
    document.querySelector('#filename'+position).value = file.name
}

/**
 * 
 * @param {int} position position to save picture id_card or bookbank  1 = id_card , 2 = bookbank
 */
function upload_file(position){
    let file = document.querySelector('#file'+position).files[0]
    console.log(file)
    if(file){
        let data = new FormData()
        data.append('id',document.querySelector('#user_id').value)
        if(position == 1){
            data.append('id_file',file)
        }
        else if(position == 2){
            data.append('bookbank',file)
        }
        else{
            return false
        }

        $.ajax({
            method: "POST",
            url: "functions/uploadfile.php",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success:function(result){
                if(result == "success"){
                    Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'บันทึกข้อมูลสำเร็จ',
                    }).then(()=>{
                    location.href = "https://thavorn-jewelry.com/profile/"
                    })
                }
                else{
                    console.error(result)
                    Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเพิ่มรูปภาพได้ กรุณาตรวจสอบข้อมูล',
                    })
                }
            },
            error:function(textStatus){
              console.log(textStatus.responseText)
            }
        })
    }
    else{
        console.error("Not Found File Upload!!")
        Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน',
            text: 'ไม่พบไฟล์รูปภาพ กรุณาตรวจเช็คข้อมูล',
        })
        return false
    }
}

// goback profile
function back(){
    location.href = "https://thavorn-jewelry.com/profile/"
}

// select pic slip
function select_slip(){
    document.querySelector('#file_slip').click()
}

// เปลี่ยนรูปอัพโหลด
function change_pic(event){
    document.querySelector('.thumbnail img').src = URL.createObjectURL(event.target.files[0])
    document.querySelector('.thumbnail img').onload = function() {
      URL.revokeObjectURL(document.querySelector('.thumbnail img').src) // free memory
    }
    document.querySelector('.custom-file label').innerHTML = event.target.files[0].name
}

function upload_slip(){
    let data = new FormData()
    data.append('item_id',document.querySelector('#select_item').value)
    data.append('user_id',document.querySelector('#user_id').value)
    data.append('interest',document.querySelector('#interest').value)
    data.append('img',document.querySelector('#file_slip').files[0])

    if(document.querySelector('#select_item').value != "" && document.querySelector('#user_id').value != ""){
        $.ajax({
            method: "POST",
            url: "functions/upload-slip.php",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success:function(result){
              // console.log(result)
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'เพิ่มข้อมูลสำเร็จ',
                }).then(()=>{
                    location.href = "https://thavorn-jewelry.com/profile/"
                })
            },
            error:function(textStatus){
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด!',
                    text: 'ไม่สามารถส่งข้อมูลได้',
                })
                console.log(textStatus.responseText)
            }
          })
    }
}