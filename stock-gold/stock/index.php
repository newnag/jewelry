./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="js/stock.js"></script>

<script type="text/javascript">
  $(document).ready( function () {
    // get()

    setTimeout(() => {
      $('#table-gold').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "searching":false,
        "autoWidth": false,
        "responsive": true,
      });
    }, 500);
    
  });

  function add_new(){
      location.href = "https://thavorn-jewelry.com/stock-gold/stock/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-gold/stock/edit.php?id=${id}`
  }

  // เมื่อเลือกประเภทสินค้า
  document.querySelector('#search_type').addEventListener('change',()=>{
    let data = {id:document.querySelector('#search_type').value}
    $("#search_cate").empty()

    $.ajax({
      method: "POST",
      url: "functions/get-cate.php",
      data: data,
      dataType: 'json',
      success:function(result){
        // console.log(result)
        if(result != "error"){
          const select_type = document.querySelector('#search_cate')

          for(i=0;i<result.length;i++){
              
              let tem = `
              <option value="${result[i].id}">${result[i].cate_name}</option>
              `
              select_type.insertAdjacentHTML('beforeend',tem)
          }
        } 
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
        const select_type = document.querySelector('#search_cate')
        let tem = `
        <option value="">เลือกหมวดหมู่สินค้า</option>
        `
        select_type.insertAdjacentHTML('beforeend',tem)
      }
    })
  })
</script>

</body>
</html>

