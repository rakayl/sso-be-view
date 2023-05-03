<?php
    $title = "User Profile";
?>
@extends('webview.main')

@section('page-style-plugin')
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('css')
    <style type="text/css">
        .text-brown{
          color: #6C5648;
        }
        .text-black{
          color: #000;
        }
        .text-red{
          color: #e64343;
        }
        .text-error{
          margin-top: 5px;
        }
        .form-group.form-md-line-input{
          margin-bottom: 10px;
        }
        .form-group label{
          color: #666666;
          font-size: 13px;
          margin-bottom: 0px;
        }

        /* the arrow inside the select element: */
        .select-img{
          position: absolute;
          top: 52px;
          right: 3px;
          width: 17px;
          height: 17px;
          z-index: -1;
        }

        /* select 2 */
        .select2-search__field{
            border: 1px solid #c2cad8;
        }
        span.select2-selection.select2-selection--single {
            outline: none;
        }
        .select2-container{
            padding-top: 1px;
        }
        .select2 .select2-container--default,
        .select2 .select2-selection--single,
        .select2 .select2-selection__rendered{
            line-height: 34px !important;
            padding-left: 0px !important;
            color: #000 !important;
            font-family: "GoogleSans";
            border-bottom: 1px solid #c2cad8;
        }
        .select2 .select2-selection--single{
            height: 34px;
            border: none;
            background-color: transparent;
        }
        .select2-results__option{
            color: #000;
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: #990003 !important;
            color: #fff;
        }
        .select2-selection__arrow{
            display: none;
        }

        .city .select2-results ul{
            height: 160px;
        }

        .form-actions{
          margin-bottom: 30px;
        }
        @media screen and ( max-height: 585px ) {
          .form-actions{
            margin-top: 120px;
          }
        }
        @media screen and ( min-height: 586px ) {
          .form-actions{
            margin-top: 70px;
          }
          .button-wrapper {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
          }
        }
        .button-wrapper .btn{
            width: 75%;
            max-width: 400px;
            font-size: 16px;
        }
        .btn-round{
            border-radius: 25px !important;
        }
        .btn-outline.brown{
            border-color: #6C5648;
            color: #6C5648;
            background-color: #fff;
        }
        .btn-outline.brown:focus{
          animation: btn-click 0.5s;
        }
        @keyframes btn-click {
          0% {
            background-color: #fff;
            color: #6C5648;
          }
          50% {
            background-color: #6C5648;
            color: #fff;
          }
          100% {
            background-color: #fff;
            color: #6C5648;
          }
        }

        .birthday-wrapper input.form-control{
          height: 36px;
          padding-top: 8px;
          padding-bottom: 8px;
          border-bottom-color: #c2cad8;
          color: #000 !important;
          font-size: 15px;
        }
        .btn-save{
            background: #990003;
            color: white;
            border-radius: 5px !important;
        }
        .btn:hover{
            color: white !important;
        }
    </style>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-4" style="position: unset;">
        <div class="text-black" style="margin-top: 20px; margin-bottom: 20px; text-align: justify;">
            Silakan lengkapi data di bawah ini dan dapatkan Panda Points
        </div>

        @if(isset($errors))
          <div class="alert alert-danger text-red" role="alert" style="margin-top:20px; margin-bottom: 0px;">
           @foreach($errors as $e)
            <p>{{ $e }}</p>
           @endforeach
         </div>
        @endif

        @if($user != null)
            @php
              $date = "";
              $month = "";
              $year = "";
              $id_city = ""; // Jakarta
              if ($user['birthday'] != "") {
                $birthday = date('j-n-Y', strtotime($user['birthday']));
                $birthday = explode('-', $birthday);
                $date = $birthday[0];
                $month = $birthday[1];
                $year = $birthday[2];
              }
              if ($user['id_city'] != "") {
                $id_city = $user['id_city'];
              }
            @endphp

            @if($user['birthday']==null || $user['gender']==null || $user['id_city']==null )
            {{-- form --}}
            <form role="form" action="{{ url('webview/complete-profile/submit') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-body">
                    <div class="form-group form-md-line-input">
                        <label>Jenis Kelamin</label>
                        <select id="select2-gender" class="form-control" name="gender" required data-placeholder="Pilih Jenis Kelamin">
                            <option></option>
                            <option value="Male" {{ ($user['gender']=='Male' ? 'selected' : '') }}>Laki-laki</option>
                            <option value="Female" {{ ($user['gender']=='Female' ? 'selected' : '') }}>Perempuan</option>
                        </select>
                        <img class="select-img" src="{{ env('STORAGE_URL_VIEW') }}{{('img/webview/arrow-down.png') }}" alt="">
                        <div id="error-gender" class="text-red text-error"></div>
                    </div>

                    <div class="form-group form-md-line-input birthday">
                        <label>Tanggal Lahir</label>

                        <div class="birthday-wrapper row">
                            <div class="form-md-line-input date-select col-xs-3">
                              <input id="date-input" class="form-control text-center" type="tel" name="date" maxlength="2" placeholder="Tanggal" autocomplete="off" required value="{{ $date }}" pattern="[0-9]{1,2}">
                            </div>
                            <div class="form-md-line-input col-xs-3">
                              <input id="month-input" class="form-control text-center" type="tel" name="month" maxlength="2" placeholder="Bulan" autocomplete="off" required value="{{ $month }}" pattern="[0-9]{1,2}">
                            </div>
                            <div class="form-md-line-input col-xs-4">
                              <input id="year-input" class="form-control text-center" type="tel" name="year" maxlength="4" placeholder="Tahun" autocomplete="off" required value="{{ $year }}" pattern="[0-9]{4}">
                            </div>
                        </div>
                        <div id="error-birthday" class="text-red text-error"></div>
                    </div>

                    <div class="form-group form-md-line-input city">
                        <label>Kota Domisili</label>
                        <select id="id_city" class="form-control id_city" name="id_city" required style="width: 100%;">
                            <option></option>
                            @foreach ($cities as $city)
                                <option value="{{$city['id_city']}}" @if($city['id_city']==$id_city) selected @endif>{{ $city['city_type']. " " .$city['city_name'] }}</option>
                            @endforeach
                        </select>
                        <img class="select-img" src="{{ env('STORAGE_URL_VIEW') }}{{('img/webview/arrow-down.png') }}" alt="">
                        <div id="city-dropdown" style="position: relative;"></div>
                        <div id="error-city" class="text-red text-error"></div>
                    </div>



                    <div class="form-actions noborder">
                        <input type="hidden" name="bearer" value="{{ $bearer }}">

                        <div class="button-wrapper text-center">
                            <input type="submit" value="Simpan" class="btn btn-save GoogleSans-Bold">
                        </div>
                    </div>
                </div>
            </form>
            {{-- end form --}}
            @else
                <div class="alert alert-warning text-brown">Data is completed</div>
            @endif
        @else
            <div class="alert alert-warning text-brown">Data not found</div>
        @endif
    </div>
@stop

@section('page-script')
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/webview/scripts/select2-custom.js') }}" type="text/javascript"></script>
    <script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>

    <script>
        // when document ready
        (function() {
          // force select2 to open in below
          $('#id_city').select2({
            positionDropdown: true,
            placeholder : 'Pilih Kota Domisili',
            dropdownParent: $('#city-dropdown')
          });

          $('#select2-gender').select2({
            positionDropdown: true,
            minimumResultsForSearch: -1,
            placeholder : 'Pilih Jenis Kelamin'
          });


        })();


        /* styling select2 when keyboard show */
        /*$('body').on('focus', '.select2-search__field', function() {
          $('.select2-container--open').css({'position': 'relative', 'top': '0'});
          $('.select2-dropdown').css('position', 'relative');
        });*/

        /* check last date if month change */
        $('#month-input').on('change, keyup', function (e) {
          var month = $(this).val();
          var year = $('#year-input').val();
          if (year == "") {
            var today = new Date();
            var year = today.getFullYear();
          }
          var d = new Date(year, month, 0);
          var last_day = d.getDate();

          var date = $('#date-input').val();
          // reset selected date
          if (date > last_day) {
            date = 1;
            $('#date-input').val(date);
          }
        });
        // check february last day
        $('#year-input').on('change, keyup', function(e) {
          var year = $(this).val();
          var month = $('#month-input').val();
          if (month == 2) {
            var d = new Date(year, month, 0);
            var last_day = d.getDate();

            var date = $('#date-input').val();
            // reset selected date
            if (date > last_day) {
              date = 1;
              $('#date-input').val(date);
            }
          }
        });

        var date_input = document.getElementById('date-input');
        var month_input = document.getElementById('month-input');
        var year_input = document.getElementById('year-input');
        // validate date
        date_input.addEventListener('keydown', validateDate);
        date_input.addEventListener('keyup', validateDateRange);
        // validate month
        month_input.addEventListener('keydown', validateMonth);
        month_input.addEventListener('keyup', validateMonthRange);
        // validate year
        year_input.addEventListener('keydown', validateYear);
        year_input.addEventListener('keyup', validateYear);

        function validateDate(e) {
          var date = date_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 2 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (date.length == 2) {
              e.preventDefault();
            }
          }
          // accept only numeric in date
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)) {
              e.preventDefault();
              if (keycode == 13) {
                // on enter, focus on month input
                month_input.focus();
              }
          }
        }
        // check date range
        function validateDateRange(e) {
          var date = date_input.value;
          var month = month_input.value;
          var year = year_input.value;
          if (year == "") {
            var today = new Date();
            var year = today.getFullYear();
          }
          var d = new Date(year, month, 0);
          var last_day = d.getDate();
          if (date == 0) {
            date_input.value = "";
          }
          else if (date > last_day) {
            date = date.slice(0, 1);
            date_input.value = date;
          }
          validateAge(date_input);
        }

        function validateMonth(e) {
          var month = month_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 4 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (month.length == 2) {
              e.preventDefault();
            }
          }
          // accept only numeric in month
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)) {
            e.preventDefault();
            if (keycode == 13) {
              // on enter, focus on month input
              year_input.focus();
            }
          }
        }
        // check month range
        function validateMonthRange(e) {
          var month = month_input.value;
          if (month == 0) {
            month_input.value = "";
          }
          else if (month > 12) {
            month = month.slice(0, 1);
            month_input.value = month;
          }
          validateAge(month_input);
        }

        function validateYear(e) {
          var year = year_input.value;
          var keycode = (typeof e.which == "number") ? e.which : e.keyCode;
          // max 4 digit
          // except backspace, delete, tab
          if (keycode != 8 && keycode != 46 && keycode != 9) {
            if (year.length == 4) {
              e.preventDefault();
            }
            validateAge(year_input);
          }

          // accept only numeric in year
          if (keycode != 0 && keycode != 8 && keycode != 9 && (keycode < 48 || keycode > 57)) {
            e.preventDefault();
            if (keycode == 13) {
              // on enter, remove cursor from field
              year_input.blur();
            }
          }
        }

        function validateAge(target_input) {
          var date = new Date();
          var this_year = date.getFullYear();

          var year = year_input.value;
          var month = (month_input.value!='' ? month_input.value-1 : '0');  // month start from 0
          var day = (date_input.value!='' ? date_input.value : '01');
          var birthday = new Date(year, month, day);

          var age = diff_years(date, birthday);

          if (age < 0) {
            target_input.value = "";
            $('#error-birthday').text('Tahun lahir tidak valid');
          }
          else if (age < 10) {
            target_input.value = "";
            $('#error-birthday').text('Usia minimal adalah 10 tahun');
          }
          else {
            $('#error-birthday').text('');
          }
        }
        // calculate difference year between 2 dates
        function diff_years(date2, date1) {
          var day1 = date1.getDate();
          var day2 = date2.getDate();
          var month1 = date1.getMonth();
          var month2 = date2.getMonth();
          // if today is birthday, calculate by year
          if (day1 == day2 && month1==month2) {
            var year1 = date1.getFullYear();
            var year2 = date2.getFullYear();
            var diff = year2 - year1;
          }
          else {
            var diff = Math.floor((date2-date1) / (365.25 * 24 * 60 * 60 * 1000));
          }
          return diff;
        }

        $('form').submit(function(e) {
          var gender = $('#select2-gender').val();
          var birthday_d = $('#date-input').val();
          var birthday_m = $('#month-input').val();
          var birthday_y = $('#year-input').val();
          var id_city = $('#id_city').val();



          if (gender=="" || birthday_d=="" || birthday_m=="" || birthday_y=="" || id_city=="" ) {
            e.preventDefault();
            if (gender == "") {
              $('#error-gender').text('Jenis Kelamin tidak boleh kosong')
            }
            if (birthday_d=="" || birthday_m=="" || birthday_y=="") {
              $('#error-birthday').text('Tanggal Lahir tidak boleh kosong')
            }
            if (id_city == "") {
              $('#error-city').text('Kota tidak boleh kosong')
            }

          }

        });

    </script>
@stop