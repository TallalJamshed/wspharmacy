<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            /* width: 8.27in;
            height: 11.69; */
            padding-left: 0.3in;
            padding-right: 0.3in;
        }
        table , th , td{
            border:1px solid black;
            border-collapse: collapse;
        }
        th, td{
            /* padding: 10px; */
            text-align: center;
        }
        th{
            /* padding: 15px; */
            text-align: center;
            font-size: 12px
        }
        td{
            text-align: center;
            font-size: 10px
        }
        table{
            border-spacing: 5px;
            margin-top: 20px;
        }
        .header{
            margin-top: 5px;
            margin-bottom: -10px;
            width: 100%;
            /* border: 1px solid black */
            /* margin-bottom: 8px; */
        }
        .header-div{
            display:inline-block; 
            /* padding-left:20px; */
            /* width: 7in; */
            /* border: 1px solid red */
        }
        .header-div-left{
            padding-left:20px
        }
        .header-div-right{
            padding-right:20px;
            float: right;
            /* margin-left: auto; */
            /* margin-right: 0; */
            /* text-align:right;  */
            /* padding-right:20px */
        }
        .header-label
        {
            font-size:13px; 
            font-weight:bold
        }
        .header-span{
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2 align="center">Purchase Report</h2>
    <div class="header">    
        <div class="header-div header-div-left">
            <label class="header-label">Start Date:</label>
            <span class="header-span">{{$start_date}}</span>
        </div>
        <div class="header-div header-div-right">
            <label class="header-label">End Date:</label>
            <span class="header-span">{{$end_date}}</span>
        </div>
    </div>
       
    <table style="width:100%; ">
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Purchase Price</th>
                <th>Courier Charges</th>
                {{-- <th>Discounted Price</th> --}}
                <th>Vendor Name</th>
                <th>Purchase Agent</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody style="background-color:white; ">
            <?php $serial = 0; $grosssale = 0; $grosscourier = 0; ?>
            @foreach ($purchases as $purchase)
            <tr>
                <?php $serial++; ?>
                <td>{{$purchase->invoice_no}}</td>
                <td>{{$purchase->total_price}}</td>
                <td>{{$purchase->purchase_courier}}</td>
                <?php $grosssale += $purchase->total_price;
                      $grosscourier += $purchase->purchase_courier;
                ?>
                {{-- <td>{{$sale->discount}}</td> --}}
                {{-- <td>{{$sale->sale_price - (($sale->discount/100)*$sale->sale_price)}}</td> --}}
                <td>{{$purchase->vendor_name}}</td>
                <td>{{$purchase->purchase_agent}}</td>
                <td>{{date('d-m-Y' , strtotime($purchase->purchase_date))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width:100%">
        <tr>
            <th>No of Purchases :</th><td>{{$serial}}</td>
            <th>Gross Purchase :</th><td>{{$grosssale}}</td>
            <th>Gross Courier Charges :</th><td>{{$grosscourier}}</td>
        </tr>
        {{-- <tr>
            <th style="border:0px"></th><td style="border:0px"></td>
            <th>Previous Balance :</th><td></td>
        </tr> --}}
        {{-- <tr>
            <th style="border:0px"></th><td style="border:0px"></td>
            <th>Total Amount :</th><td></td>
        </tr> --}}
    </table>
</body>
</html>