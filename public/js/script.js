$(document).ready(function() {
    $('#example').DataTable();
    $('#tabel-bon').DataTable();
    $('#tabel-pembayaran-bon').DataTable();
} );


function totalAkhir(){
  var diskon=$('#diskon').val();

  var tmpPokok = 0;
  $("input[name^='total_harga_pokok']").each(function() { 
      tmpPokok +=parseInt($(this).val()) 
      totalHargaPokok=tmpPokok-diskon; 
      $('#total_harga_pokok_akhir').val(totalHargaPokok);
  });

  
  var tmpJual = 0;
  $("input[name^='total_harga_jual']").each(function() { 
      tmpJual +=parseInt($(this).val()) 
      totalHargaJual=tmpJual-diskon; 
      $('#total_akhir1').val(totalHargaJual);
      $('#total_akhir2').val(totalHargaJual);
  });


}



$(".delete").on('click', function() {
    $('.chkbox:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
    updateSerialNo();
    totalAkhir();
  });
  var i=$('table tr').length;
  $(".addbtn").on('click',function(){
    count=$('#tabel_barangs tr').length;
    
      var data="<tr><td><input type='checkbox' class='chkbox'/></td>";
        data+="<td><span id='sn"+i+"'>"+count+".</span></td>";
        data+="<td><input style='width:6em;' class='form-control ' type='text' data-type='jumlah' id='jumlah_"+i+"' name='jumlah[]'/></td>";
        data+="<td><input style='width:6em;' class='form-control autocomplete_txt' type='text' data-type='id_barang' id='id_barang_"+i+"' name='id_barang[]' readonly/></td>";
        data+="<td><input style='width:15em;' class='form-control autocomplete_txt' type='text' data-type='nama_barang' id='nama_barang_"+i+"' name='nama_barang[]'/></td>";
        data+="<td><input class='form-control autocomplete_txt' type='text' data-type='harga_pokok' id='harga_pokok_"+i+"' name='harga_pokok[]' readonly/></td>";
        data+="<td><input class='form-control autocomplete_txt' type='text' data-type='harga_jual' id='harga_jual_"+i+"' name='harga_jual[]' readonly/></td>";
        data+="<td><input class='form-control ' type='text' data-type='total_harga_pokok' id='total_harga_pokok_"+i+"' name='total_harga_pokok[]'readonly/></td>";
        data+="<td><input class='form-control ' type='text' data-type='total_harga_jual' id='total_harga_jual_"+i+"' name='total_harga_jual[]'readonly/></td>";
    $('#tabel_barangs').append(data);
   
    i++;
    totalAkhir();
  });
          
  function select_all() {
    $('input[class=chkbox]:checkbox').each(function(){ 
      if($('input[class=check_all]:checkbox:checked').length == 0){ 
        $(this).prop("checked", false); 
      } else {
        $(this).prop("checked", true); 
      } 
    });
  }
  
  function updateSerialNo(){
    obj=$('#tabel_barangs tr').find('span');
    $.each( obj, function( key, value ) {
      id=value.id;
      $('#'+id).html(key+1);
      
    });
    totalAkhir();
  }
  //autocomplete script
  $(document).on('focus','.autocomplete_txt',function(){
    type = $(this).data('type');
    
    if(type =='nama_barang' )autoType='nama_barang'; 
    if(type =='harga_pokok' )autoType='harga_pokok'; 
    if(type =='harga_jual' )autoType='harga_jual'; 
    
     $(this).autocomplete({
     
         source: function( request, response ) {
             
              $.ajax({
                  url: "/searchajax",
                  dataType: "json",
                  data: {
                      term : request.term,
                      type : type,
                  },
                  success: function(data) {
                      var array = $.map(data, function (item) {
                         return {
                             label: item[autoType],
                             value: item[autoType],
                             data : item
                         }
                     });
                      response(array)
                  }
              });
         },
         select: function( event, ui ) {
             var data = ui.item.data;           
             id_arr = $(this).attr('id');
             id = id_arr.split("_");
             elementId = id[id.length-1];
             $('#id_barang_'+elementId).val(data.id_barang);
             $('#nama_barang_'+elementId).val(data.nama_barang);
             $('#harga_pokok_'+elementId).val(data.harga_pokok);
             $('#harga_jual_'+elementId).val(data.harga_jual);

             var jumlah=$('#jumlah_'+elementId).val();
            
             var totalHargaPokok = data.harga_pokok * jumlah;
             var totalHargaJual = data.harga_jual * jumlah;
             $('#total_harga_pokok_'+elementId).val(totalHargaPokok);
             $('#total_harga_jual_'+elementId).val(totalHargaJual);

            totalAkhir();
           }

           
     });
           

});