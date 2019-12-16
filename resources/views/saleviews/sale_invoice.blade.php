<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        /* page[size="A4"] {
            background: white;
            width: 5.5in;
            height: 210mm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        }
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            body, page[size="A4"] {
            margin: 0;
            box-shadow: 0;
            } */
        body{
            width: 5.5in;
            padding-left: 0.3in;
            padding-right: 0.3in;
            /* background: rgb(204,204,204);  */
        }
        table , th , td{
            margin-top:5px;
            border:1px solid black;
            border-collapse: collapse;
        }
        .table2{
            margin-top:15px;
        }
        th{
            /* padding: 15px; */
            text-align: center;
            font-size: 13px
        }
        td{
            text-align: center;
            font-size: 11px
        }
        table{
            border-spacing: 5px;
        }
        .header{
            margin-top: 5px;
            /* margin-bottom: 8px; */
        }
        .header-div{
            display:inline-block; 
            padding-left:20px;
            /* border: 1px solid black */
        }
        .header-div-left{
            width:59%; 
            padding-left:20px
        }
        .header-div-right{
            width:40%; 
            text-align:right; 
            padding-right:20px
        }
        .header-label
        {
            font-size:10px; 
            font-weight:bold
        }
        .header-span{
            font-size: 12px;
        }
    </style>
</head>
<body>
    <page size="A4">
    <h3 align="center">Sales Invoice</h3>    
        <div class="header">    
            <div class="header-div header-div-left">
                <label class="header-label">Customer Name:</label>
                <span class="header-span">{{$sales->cust_name}}</span>
            </div>
            <div class="header-div header-div-right">
                <label class="header-label">Invoice No:</label>
                <span class="header-span">{{$sales->sale_invoice}}</span>
            </div>
        </div>
        <div class="header">    
            <div class="header-div header-div-left">
                <label class="header-label">Address:</label>
                <span class="header-span">{{$sales->cust_address}}</span>
            </div>
            <div class="header-div header-div-right">
                <label class="header-label">Agent:</label>
                <span class="header-span">{{$sales->sale_agent}}</span>
            </div>
        </div>
        <div class="header">    
            <div class="header-div header-div-left">
                <label class="header-label">Invoice Date:</label>
                <span class="header-span">{{date('d-m-y')}}</span>
            </div>
            <div class="header-div header-div-right">
                <label class="header-label">Sale Date:</label>
                <span class="header-span">{{date('d-m-Y' , strtotime($sales->sale_date))}}</span>
            </div>
        </div>
<hr>
    <table style="width:100%; ">
        <thead>
            <tr>
                <th>Qnty</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Total</th>
                {{-- <th>Disc</th> --}}
                {{-- <th>Final</th> --}}
            </tr>
        </thead>
        <tbody style="background-color:white; ">
            <?php $serial = 0?>
            @foreach ($sale_details as $item)
            <tr>
                <?php ++$serial ?>
                <td>{{$item->quantity_sold}}</td>
                <td>{{$item->med_name}}</td>
                <td>{{($item->price / $item->quantity_sold)}}</td>
                <td>{{$item->price}}</td>
                {{-- <td></td> --}}
                {{-- <td></td> --}}
                {{-- <td>{{date('d-m-Y' , strtotime($item->sale_date))}}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <table style="width:100%">
            <tr>
                <th>No of Items :</th><td>{{$serial}}</td>
                <th>Gross Sale :</th><td>{{$sales->total_sale}}</td>
            </tr>
            <tr>
                <th style="border:0px"></th><td style="border:0px"></td>
                <th>Previous Balance :</th>
                @php
                    $total = $sale_sum - $paid
                @endphp
                <td>
                    @if ($total < 0)
                    {{0}}
                    @else
                    {{$total}}
                    @endif
                </td>

                {{-- <td>
                    @if ($remaining == $sales->total_sale)
                        {{0}}
                        @php
                            $remaining = 0;
                        @endphp
                    @else
                        {{$remaining}}
                    @endif
                </td> --}}
            </tr>
            <tr>
                <th style="border:0px"></th><td style="border:0px"></td>
                <th>Courier Service :</th><td>{{$sales->courier_service}}</td>
            </tr>
            <tr>
                <th style="border:0px"></th><td style="border:0px"></td>
                <th>Total Amount :</th><td>{{$sales->total_sale + ($sale_sum - $paid) + $sales->courier_service}}</td>
            </tr>
    </table>
</page>
</body>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
        // console.log(window.history);
        window.print();
    });
</script>
<script>
    $(document).ready(function(){
        setTimeout( function(){
            history.back()
            // window.location.replace("/addsalesform");
        }, 1000);     
    });
</script>
</html>