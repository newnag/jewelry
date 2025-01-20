document.querySelector('#test').addEventListener('click',()=>{
  $.ajax({
    method: "POST",
    url: "functions/test.php",
    data: data,
    dataType: 'json',
    success:function(result){ 
      console.log(result)
    },
    error:function(textStatus){
      
    }
  })
})