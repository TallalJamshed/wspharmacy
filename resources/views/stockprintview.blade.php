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
    <h2 align="center">Available Stocks Report</h2>
    <hr>
    <div style="width:100%">
        <?php $i = 0; ?>
        @foreach ($stocks as $stock)
                    <span style="display:inline-block; width:33.333%">{{++$i}}) {{$stock->med_name}}</span>
                @if ($i%3 ==0)
                    <br>
                @endif
        @endforeach
    </div>
</body>
</html>