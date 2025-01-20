/**
 * Register Function
 * Develop by Nexadon
 * @copyright Nexadon 2022
 */


function regis(){
    let date_dob = document.querySelector('#dob').value
    date_dob = date_dob.split("/")
    let y_dob = Number(date_dob[2])-543
    let new_dob = `${y_dob}-${date_dob[1]}-${date_dob[0]}`

    let data = new FormData()
    data.append('fullname',document.querySelector('#fullname').value)
    data.append('dob',new_dob)
    data.append('phone',document.querySelector('#phone').value)
    data.append('id_no',document.querySelector('#id_no').value)
    data.append('line_id',document.querySelector('#line_id').value)
    data.append('email',document.querySelector('#email').value)
    data.append('address',document.querySelector('#address').value)
    data.append('line_user',document.querySelector('#line_user').value)
    data.append('type_regis',document.querySelector('#type_regis').value)

    if(data.get('fullname') != "" || data.get('dob') != "" || data.get('phone') != "" || data.get('id_no') != "" || data.get('address') != ""){
        $.ajax({
            method: "POST",
            url: "functions/register.php",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success:function(result){ 
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: 'สมัครสมาชิกสำเร็จ',
                }).then(()=>{
                    location.href = "https://thavorn-jewelry.com/register/"
                })
            },
            error:function(textStatus){
                console.error(textStatus.responseText)
                Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถสมัครสมาชิกได้ กรุณาตรวจเช็คข้อมูลอีกครั้ง',
                })
            }
        })
    }
    else{
        Swal.fire({
            icon: 'warning',
            title: 'แจ้งเตือน!',
            text: 'คุณกรอกข้อมูลไม่ครบถ้วน!',
        })
    }
}

function login(){
    let data = {
        phone: document.querySelector('#phone').value,
        id_no: document.querySelector('#id_no').value
    }

    $.ajax({
        method: "POST",
        url: "functions/login.php",
        data: data,
        success:function(result){ 
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'เข้าสู่ระบบสำเร็จ',
            }).then(()=>{
                location.href = "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1657201123&redirect_uri=https://thavorn-jewelry.com/profile/index.php&state=12345abcde&scope=profile%20openid&nonce=09876xyz"
            })
        },
        error:function(textStatus){
            console.error(textStatus.responseText)
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบข้อมูลอีกครั้ง',
            })
        }
    })
}


/** 
 * getLine_user
 * @property  {string} grant_type - authorization_code
 * @property  {string} code - code from line auth
 * @property  {string} redirect_uri - url callback from line develop channel
 * @property  {string} client_id - client_id from line develop channel
 * @property  {string} client_secret - client_secret from line develop channel
 * @property  {string} id_token - id_token is result from token
 * @property {string} sub - line user id from verify token_id
*/
function getLine_user(){
    let type_regis = document.querySelector('#type_regis').value
    let data_line = {
        grant_type: "authorization_code",
        code: document.querySelector('#code').value,
        redirect_uri: `https://thavorn-jewelry.com/register/register.php?type_regis=${type_regis}`,
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
                    document.querySelector('#line_user').value = result.sub
                },
                error:function(textStatus){
                    console.error(textStatus.responseText)
                }
            })
        },
        error:function(textStatus){
            console.error(textStatus.responseText)
        }
    })
}


