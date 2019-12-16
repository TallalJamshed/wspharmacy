<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

<!-- Select 2 jquery-->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6/js/select2.min.js"></script> --}}
<script src="{{ asset('js/select2.min.js')}}"></script>
{{-- <script src="{{ asset('js/chosen.jquery.min.js')}}"></script> --}}


<!-- Morris Charts JavaScript -->
<script src="{{ asset('vendor/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('vendor/morrisjs/morris.min.js')}}"></script>
<script src="{{ asset('js/morris-data.js')}}"></script>

<!-- Flot Charts JavaScript -->
<script src="{{ asset('vendor/flot/excanvas.min.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.time.js')}}"></script>
<script src="{{ asset('vendor/flot-tooltip/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('js/sb-admin-2.js')}}"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script> --}}
<script src="{{ asset('vendor/datatables/js/jquery.datatables.js')}}"></script>

<script type="text/javascript">
  function addMedicineModal(){
    $('#dataModal').modal();
  }
  $(function(){
    $('.custselect').select2({
        placeholder: 'Enter Customer'
    });
    $('.medselect').select2({
      placeholder: 'Enter Medicine',
    });
    $('.companyselect').select2({
      placeholder: 'Select Company',
    });
    $('.formulaselect').select2({
      placeholder: 'Select Formula',
    });
    $('.catselect').select2({
      placeholder: 'Select Category',
    });
    
  });
</script>

<script>
  $(document).ready(function() {
    $('.selectioninput').select2();
    $('.pricingselect').select2();
    $('.cust_name').select2();
    $('.formulaselection').select2();
    $('.vendor_name').select2();
});
</script>

<script>
  setTimeout(function() {
    $('#message').fadeOut('slow');
  }, 3000); 
</script>
<script>
  function deleteStock(id) {
    // alert(id);
    $('#deleteStockModal').modal();
    $('#idtodel').val(id);
  }
  function deleteCompany(id) {
    // alert(id);
    $('#deleteCompanyModal').modal();
    $('#companyidtodel').val(id);
  }
  function deleteCustomer(id) {
    // alert(id);
    $('#deleteCustomerModal').modal();
    $('#customeridtodel').val(id);
  }
  function deleteMedicine(id) {
    // alert(id);
    $('#deleteMedicineModal').modal();
    $('#medicineidtodel').val(id);
  }
  function deleteCategory(id) {
    // alert(id);
    $('#deleteCategoryModal').modal();
    $('#categoryidtodel').val(id);
  }
  function deleteFormula(id) {
    // alert(id);
    $('#deleteFormulaModal').modal();
    $('#formulaidtodel').val(id);
  }
  function deleteInvoice(id) {
    // alert(id);
    $('#deleteInvoiceModal').modal();
    $('#invoiceidtodel').val(id);
  }
  
</script>


{{-- <script>
$(window).load(function(){
  var selects = document.getElementsByName('fk_med_id[]');
  alert(selects.length);
  for(var i=0; i<selects.length; i++){

  }
});
</script> --}}


<script>
$(document).on('change' , '.cust_name' , function(){
      $.ajax({
            url: '/getbycust',
            type: 'post',
            datatype: 'json',
            data:{cust_name:$(this).children('option:selected').val() , _token: '{{csrf_token()}}'},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                if(data.length != 0){
                    $('#ledger_id').val(data.ledger.ledger_id);
                    // $('#cust_name option[value='+data.ledger.cust_id+']').attr('selected','selected').change();
                    $('#invoice_no').val(data.ledger.sale_invoice);
                    $('#cust_name').val(data.ledger.cust_name);
                    $('#total_bill').val(data.remaining);
                    // alert(data.ledger.courier_service);
                    $('#courier').val(data.courier);
                    $('#payment-table tr').remove();
                    data.ledger_details.forEach(element => {
                        var remain = element['remaining_amount']-element['discount'];
                        $('#payment-table').append('<tr><td>'+element['total_amount']+'</td><td>'+element['paid_amount']+'</td><td>'+element['discount']+'</td><td>'+remain+'</td><td>'+element['courier_paid']+'</td><td>'+element['payment_date']+'</td></tr>')
                        // console.log(element['ledger_details_id']);
                    });
                    // console.log(data);
                }else{
                    $('#ledger_id').val('');
                    // $('#cust_name option:selected').removeAttr("selected").change();
                    $('#invoice_no').val('');
                    $('#cust_name').val('');
                    $('#total_bill').val('');
                    $('#courier').val('');
                    $('#payment-table tr').remove();
                }
              }
          });
    // }
  });
</script>

<script>
    $(document).on('change' , '.vendor_name' , function(){
          $.ajax({
                url: '/getbyvendor',
                type: 'post',
                datatype: 'json',
                data:{vendor_name:$(this).children('option:selected').val() , _token: '{{csrf_token()}}'},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    if(data.length != 0){
                        $('#vendor_ledger_id').val(data.ledger.vendor_ledger_id);
                        // $('#cust_name option[value='+data.ledger.cust_id+']').attr('selected','selected').change();
                        $('#invoice_no').val(data.ledger.sale_invoice);
                        $('#vendor_name').val(data.ledger.vendor_name);
                        $('#total_bill').val(data.remaining);
                        $('#courier').val(data.courier);
                        $('#payment-table tr').remove();
                        data.ledger_details.forEach(element => {
                          var remain = element['remaining_amount']-element['discount'];
                            $('#payment-table').append('<tr><td>'+element['total_amount']+'</td><td>'+element['paid_amount']+'</td><td>'+element['discount']+'</td><td>'+remain+'</td><td>'+element['vcourier_paid']+'</td><td>'+element['payment_date']+'</td></tr>')
                            // console.log(element['ledger_details_id']);
                        });
                        // console.log(data);
                    }else{
                        $('#vendor_ledger_id').val('');
                        // $('#cust_name option:selected').removeAttr("selected").change();
                        $('#invoice_no').val('');
                        $('#vendor_name').val('');
                        $('#total_bill').val('');
                        $('#courier').val('');
                        $('#payment-table tr').remove();
                    }
                  }
              });
        // }
      });
    </script>

<script>
    $(document).on('change' , '.selectioninput' , function(){
        var med_id = $(this).find('option:selected').val();
        var actual_price = $(this).find('option:selected').data('saleprice');
        // alert(actual_price);
        var actual_quantity = $(this).find('option:selected').data('quantity');
        // alert(actual_quantity);
        // var selector = this;
        var parentofSelect = $(this).parent();
        // console.log(parentofSelect);
        var nextsiblingofParent = parentofSelect.siblings().eq(parentofSelect.index()+0);
        var quantityinput = parentofSelect.siblings().eq(parentofSelect.index()+2);

        var siblingChild = $(nextsiblingofParent).find("input");
        var quantityChild = $(quantityinput).find("input");

        // $.ajax({
        //     url: '/getavgpurchase',
        //     type: 'post',
        //     data:{fk_med_id:med_id , _token: '{{csrf_token()}}'},
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(data){
        //       len = data.length;
        //       console.log(data);
        //       // alert(data[0]);
        //     }
        // });
        siblingChild.val(actual_price);
        quantityChild.val(actual_quantity);
        $('#actual_quantity').val(actual_quantity);
    });
</script>

<script>
    $(document).on('change' , '.prcmed' , function(){
        var med_id = $(this).find('option:selected').val();
        var parentofSelect = $(this).parent();
        var nextsiblingofParent = parentofSelect.siblings().eq(parentofSelect.index()+0);
        var siblingChild = $(nextsiblingofParent).find("input");
        // alert(med_id);
        $.ajax({
            url: '/getlastpurchase',
            type: 'post',
            data:{fk_med_id:med_id , _token: '{{csrf_token()}}'},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
              console.log(data.unit_price); 
              siblingChild.val(data.unit_price);
            }
        });

        //

    });
</script>

<script>
  $(document).on('change' , '.formulaselection' , function(){
    var id = $('.formulaselection').val();

    $.ajax({
        url: '/getmedsdata/'+id,
        type: 'get',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data){
          len = data.length;
          text = "<ul id='datesul'>";
          for(i=0; i<len; i++)
          {
            text += "<li id='datesli' >" + data[i].med_name + "</li>";
            // alert(data[i].med_name);
          }
          text += "</ul>";
          document.getElementById("showmeds").innerHTML = text;
          // console.log(data[0].med_name);
          // alert(data[0]);
        }
    });
  });
</script>

<script>
    $(document).on('keyup' , '.sale_cal' , function(){
        var total = 0;
        var prices = document.getElementsByName('sale_price[]');
        var quantities = document.getElementsByName('sale_quantity[]');
        for(var i=0; i < prices.length; i++){
            document.getElementsByName('total_price[]')[i].value = prices[i].value * quantities[i].value ;
        }

        // $('#salesubmit').removeAttr('disabled');
        var total = 0;
        var prices = document.getElementsByName('total_price[]');
        for(var i=0; i < prices.length; i++){
            total +=  parseFloat(prices[i].value);
            document.getElementById('total').value = total;
        }
    });

$(document).on('keyup','.sale_quantity' , function(){
  var val1 = $(this).val();
  // alert(val1);
  var val2 = $(this).parent().siblings().children('.total_quantity').val();
  // alert(val2);
  // console.log(val2);
  if(parseInt(val1) > parseInt(val2)){
    $(this).css({"border":"1px solid red" , "box-shadow":"inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 0, 0, 0.6)"});
    $(this).siblings('.warning').text("Can't be more than available quantity");
    }else{
      $(this).css({"border":"1px solid #66afe9" , "box-shadow":"#d2e5f5"});
    }
});
    
</script>

<script>
    // $(document).on('change' , '.totalprice' , function(){
    $('.totalprice').change(function(){
      $('#salesubmit').removeAttr('disabled');
        var total = 0;
        var prices = document.getElementsByName('total_price[]');
        for(var i=0; i < prices.length; i++){
            total +=  parseFloat(prices[i].value);
            document.getElementById('total').value = total;
        }
    });
</script>

<script>
  $(document).on('click','.modalbtn1',function(){
      $('.medsrow').remove();
  });
</script>

{{-- <script>
  $(document).on('keyup' , '#discount' , function(){
      var total = $('#total').val();
      var discount = $('#discount').val();
      var percentage = (parseFloat(total)*(parseFloat(discount) / 100));
      var final = parseFloat(total) - percentage;
      $('#discountedbill').val(final);
    });
</script> --}}

{{-- /////////////////////////////////////////////////////////////////////////////////// --}}
{{-- <script>
  $(document).on('keyup' , '.sale_quantity' , function(){
    var selector = this;
    
    var total = document.getElementsByName('fk_med_id[]');
    for(var i=0; i<total.length; i++){
      // alert('helo');
      var actual_quantity = document.getElementsByName('actual_quantity[]')[i].value;
      var added_quantity = document.getElementsByName('sale_quantity[]')[i].value;
      // alert(actual_quantity);
      // alert(added_quantity);

      if(parseFloat(added_quantity) > parseFloat(actual_quantity)){
        var parentofSelect = $(selector).parent();
        // var nextsiblingofParent = parentofSelect.siblings().eq(parentofSelect.index()+0);
        // console.log(nextsiblingofParent);
        var siblingChild = $(parentofSelect).find("span");
        // console.log(siblingChild);

        siblingChild.text('Total quantity in stocks is not enough');
        // var quantityChild = $(quantityinput).find("input");
        // $('#warning').val('Total quantity in stocks is not enough');
      }        
    }
  });
  </script> --}}
  {{-- ///////////////////////////////////// ///////////////////////////////////////////////--}}
{{-- <script>
  $(document).ready(function selection(){
      alert('helloo');
      $("[name='fk_med_id[]']").chosen({
      // placeholder: 'This is my placeholder',
    });
      });
</script> --}}
{{-- <script>
    function selection(){
        alert('helloo');
        $("[name='fk_med_id[]']").chosen({
        // placeholder: 'This is my placeholder',
        });
    });
  </script> --}}
{{-- <script>
  $(document).ready(function (){
    $('#addfield').click(function (){
        $('#buildyourform').append($('.repeatDiv').html());
        // selection();
    });
  });
</script> --}}

{{-- <script>
  // function selection(){
  //       alert('helloo');
  //       // document.getElementsByName('fk_med_id[]').chosen();
  //       $("[name='fk_med_id[]']").chosen({
  //       // placeholder: 'This is my placeholder',
  //       });
  //   }

  $(document).ready(function (){
    $('#addfield').click(function (){
        // $('#medstable').append('<tr>');
        $('#medstable').append("<tr>" ,$('.medicineblock').html() ,'</tr>');
        // $('#medstable').append('</tr>');
        // selection();
    });
  });
</script> --}}

{{-- <script>
  
    $('#addfield').click(function (){
      $('#medstable tr:last').after('<tr class="medicineblock"><td><select class="select2 form-control selectioninput"  style="width:100%;" name="fk_med_id[]"><option></option>@foreach ($medicines as $medicine)<option data-saleprice="{{$medicine->sale_price}}" data-quantity="{{$medicine->quantity}}" value="{{$medicine->med_id}}">{{$medicine->med_name}}({{$medicine->cat_name}}) - {{$medicine->company_name}} </option>@endforeach   </select></td><td><input type="number"  readonly name="price[]" class="form-control is-valid actual_price" id="price" placeholder="Actual Price"  ></td><td><input type="number"  name="sale_price[]" class="form-control is-valid pkt_price" id="pkt_price" placeholder="Sale Price"  ></td> <td><input type="number" readonly name="available_quantity[]" class="form-control is-valid sale_quantity" id="total_quantity" placeholder="Available Quantity"></td> <td><input type="number"  name="sale_quantity[]"  class="form-control is-valid sale_quantity" id="sale_quantity" placeholder="Sale Quantity"><span class="warning" style="color:red; font-size:12px" name="warning[]" id="warning"></span></td><td><input type="text"  readonly name="total_price[]" class="form-control is-valid totalprice" id="sale_price" placeholder="Total Price"  ></td><input type="hidden" name="actual_quantity[]" id="actual_quantity"></tr>');
      $('.select2').select2({
        placeholder: 'Enter Medicine',
      });
    });
    
</script> --}}

{{-- <script>
  $(document).on('click' , '.closebtn' , function (){
    var parent = $(this).parent().parent();
    parent.remove();
    // var name = parent.attr('name');
    // alert(name);
    // var siblings = parent.siblings();
    // console.log(parent);
    // $('div.medicineformfields').remove();
  });
</script> --}}

<script>
  $(document).ready( function () {
    $('.alldatatables').DataTable({
      responsive:true
    });
    $('.medsdatatables').DataTable({
      // paging:false
    });
    $('.paymentdatatable').DataTable({
      
      "oLanguage": {"sZeroRecords": "", "sEmptyTable": ""}
    });
} );
</script>

{{-- <script type="text/javascript">
  $(document).on('click' , '.closebtn' , function (){
        // alert('hello');
          // var delete = [];
          var array = document.getElementsByName('closecheck[]');
            alert(array.length);
          // for(var i=0; i< array.length; i++){
          //   alert('helloo');
          // }
          // $.each($("input[name='closecheck']:checked"), function(){
            // alert('hello');            
          //   delete.push($(this).val());
          // });
          // alert("My favourite sports are: " + delete.join(", "));
      });
  // });
</script> --}}