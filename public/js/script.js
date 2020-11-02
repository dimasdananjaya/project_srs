$(document).ready(function() {
    $('#example').DataTable();
} );

$(document).ready(function() {
  $('#tabel-bon').DataTable();
} );


$(document).ready(function() {
    $('#tabel-pembayaran-bon').DataTable();
} );

$(document).ready(function() {
  $('#tabel-cek-toko').DataTable();
} );

$(document).ready(function() {
  $('#tabel-barang').DataTable({
    "scrollX": true
    });
} );

$(document).ready(function () {
  $('#tabel-total-barang-terjual').DataTable({
  "scrollX": true
  });
  $('.dataTables_length').addClass('bs-select');
});

$(document).ready(function() {
  $('.uangPembayaranBon').mask("000,0000,000,000", {reverse: true, maxLength:false, removeMaskOnSubmit: true});
} );

$("#formPenjualan").submit(function() {
  $(".uang").unmask();
});

$("#formPembayaranBon").submit(function() {
  $(".uangPembayaranBon").unmask();
});


function maskMoney(){
  $(".uang").unmask();
  $('.uang').mask("000,0000,000,000", {reverse: true, maxLength:false, removeMaskOnSubmit: true});
}


function totalAkhir(){
  $(".uang").unmask();
  var diskon=$('#diskon').val();
  var totalHargaPokok = 0;
  var totalHargaJual = 0;

  $("input[name^='total_harga_pokok']").each(function() { 
      totalHargaPokok +=parseInt($(this).val()) 
      $('#total_harga_pokok_akhir').val(totalHargaPokok);
  });

  $("input[name^='total_harga_jual']").each(function() { 
      totalHargaJual +=parseInt($(this).val()) 
      $('#total_akhir1').val(totalHargaJual);
  });

  var totalAkhir = totalHargaJual-diskon;
  
  $('#total_akhir2').val(totalAkhir);
}

function hitungAll(){
  totalAkhir();
  maskMoney();
}

$(".delete").on('click', function() {
    $('.chkbox:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
    updateSerialNo();
    hitungAll();
  });
  var i=$('table tr').length;
  $(".addbtn").on('click',function(){
    
    count=$('#tabel_barangs tr').length;
      var data="<tr><td><input type='checkbox' class='chkbox'/></td>";
        data+="<td><span id='sn"+i+"'>"+count+".</span></td>";
        data+="<td><input style='width:6em;' class='form-control ' type='text' data-type='jumlah' id='jumlah_"+i+"' name='jumlah[]'/></td>";
        data+="<td><input style='width:6em;' class='form-control autocomplete_txt' type='text' data-type='id_barang' id='id_barang_"+i+"' name='id_barang[]' readonly/></td>";
        data+="<td><input style='width:15em;' class='form-control autocomplete_txt' type='text' data-type='nama_barang' id='nama_barang_"+i+"' name='nama_barang[]'/></td>";
        data+="<td><input class='form-control autocomplete_txt uang' type='text' data-type='harga_pokok' id='harga_pokok_"+i+"' name='harga_pokok[]' readonly/></td>";
        data+="<td><input class='form-control autocomplete_txt uang' type='text' data-type='harga_jual' id='harga_jual_"+i+"' name='harga_jual[]' readonly/></td>";
        data+="<td><input class='form-control uang' type='text' data-type='total_harga_pokok' id='total_harga_pokok_"+i+"' name='total_harga_pokok[]'readonly/></td>";
        data+="<td><input class='form-control uang' type='text' data-type='total_harga_jual' id='total_harga_jual_"+i+"' name='total_harga_jual[]'readonly/></td>";
    $('#tabel_barangs').append(data);
    i++;
    hitungAll();
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
  }
  //autocomplete script
  $(document).on('focus','.autocomplete_txt',function(){
    
    type = $(this).data('type');
    
    if(type =='nama_barang' )autoType='nama_barang'; 
    
     $(this).autocomplete({
          
         source: function( request, response ) {
              $.ajax({
                  url: "/searchajax",
                  dataType: "json",
                  data: {
                      term : request.term,
                      type : type,
                      id_toko : $('input#id_toko').val()
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
            hitungAll();
          }       
    });
});



$(".hitungAll").on('click',function(){
  totalAkhir();
  maskMoney();
});
