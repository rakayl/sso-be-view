<br>
<br>
<br>
<div class="form-body">
    <form class="form-horizontal" role="form" action="{{ url('bangunan/update') }}" method="post" enctype="multipart/form-data">
                <div class="form-body">
                    <h3 style="text-align: center">Data Bangunan</h3>
                    <hr style="border-top: 2px dashed black;">
                    <br>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name Alamat 
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama alamat" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value='{{$bangunan['name']}}' required placeholder="Nama Alamat">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                NIK 
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan NIK" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="nik" value='{{$bangunan['nik']}}' required placeholder="NIK">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Nomor Kartu Keluarga
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nomor kartu keluarga" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="no_kk" value='{{$bangunan['no_kk']}}' required placeholder="Nama Nomor Kartu Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Name Kartu Keluarga 
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Masukkan nama kartu keluarga" data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name_kk" value='{{$bangunan['name_kk']}}' required placeholder="Nama Kartu Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                                    <div class="input-icon right">
                                            <label class="col-md-3 control-label">
                                                    Province
                                                    <span class="required" aria-required="true"> * </span>
                                                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih provinsi " data-container="body"></i>
                                            </label>
                                    </div>
                                    <div class="col-md-8">
                                            <select id="province" name="id_province" class="form-control select2-multiple" data-placeholder="Select Province" required>
                                                    <option></option>
                                                    @if (!empty($province))
                                                            @foreach($province as $suw)
                                                                    <option @if ($suw['id_province'] == $bangunan['id_province']) selected @endif  value="{{ $suw['id_province'] }}">{{ $suw['province_name'] }}</option>
                                                            @endforeach
                                                    @endif
                                            </select>
                                    </div>
                            </div>

                           

                    <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                City
                <span class="required" aria-required="true"> * </span>
                <i class="fa fa-question-circle tooltips" data-original-title="Pilih kota letak outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-8">
                <select id="city" name="id_city" class="form-control select2-multiple" data-placeholder="Select City" disabled required>
                    <optgroup label="City List">
                        <option value="{{ $bangunan['city']['id_city'] }}">{{ $bangunan['city']['city_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Disctrict
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih kecamatan outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-8">
                <select id="district" name="id_district" class="form-control select2-multiple" data-placeholder="Select Disctrict" disabled required>
                    <optgroup label="Disctrict List">
                        <option value="{{ $bangunan['district']['id_district'] }}">{{ $bangunan['district']['district_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="input-icon right">
                <label class="col-md-3 control-label">
                    Subdisctrict
                    <span class="required" aria-required="true"> * </span>
                    <i class="fa fa-question-circle tooltips" data-original-title="Pilih kelurahan outlet" data-container="body"></i>
                </label>
            </div>
            <div class="col-md-8">
                <select id="subdistrict" name="id_subdistrict" class="form-control select2-multiple" data-placeholder="Select Subdisctrict" disabled required>
                    <optgroup label="Subdisctrict List">
                        <option value="{{ $bangunan['subdistrict']['id_subdistrict'] }}">{{ $bangunan['subdistrict']['subdistrict_name'] }}</option>
                    </optgroup>
                </select>
            </div>
        </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Postal Code
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="postal_code" value='{{$bangunan['postal_code']}}' name="postal_code" required placeholder="Postal Code" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Alamat
                                <span class="required" aria-required="true"> * </span>
                                <i class="fa fa-question-circle tooltips" data-original-title="Alamat lengkap " data-container="body"></i>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <textarea name="address" class="form-control" placeholder="Address" required>{{$bangunan['address']}}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Latitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="latitude" value='{{$bangunan['latitude']}}' id="lat" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Longitude</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control latlong" name="longitude" value='{{$bangunan['longitude']}}' id="lng" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3"></label>
                        <div class="col-md-8">
                            <input id="pac-input" class="controls" type="text" placeholder="Enter a location" style="padding:10px;width:70%" onkeydown="if (event.keyCode == 13) return false;">
                            <div id="map-canvas" style="width:900;height:380px;"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jumlah Anggota Keluarga
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" value='{{$bangunan['jml_keluarga']}}' id="jml_keluarga" name="jml_keluarga" required placeholder="Jumlah Anggota Keluarga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Volume Septic Tank
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" class="form-control" value='{{$bangunan['septic_tank_volume']}}' id="septic_tank_volume" name="septic_tank_volume" required placeholder="Volume Septic Tank">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Posisi Septic Tank
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="posisi_septic_tank" value='{{$bangunan['posisi_septic_tank']}}' name="posisi_septic_tank" required placeholder="Posisi Septic Tank">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Bangunan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_bangunan" value='{{$bangunan['jenis_bangunan']}}' name="jenis_bangunan" required placeholder="Jenis Bangunan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Kepemilikan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_kepemilikan" value='{{$bangunan['jenis_kepemilikan']}}' name="jenis_kepemilikan" required placeholder="Jenis Kepemilikan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Sumber Air Utama
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="sumber_air" value='{{$bangunan['sumber_air']}}' name="sumber_air" required placeholder="Sumber Air">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jarak Sumber Air Minum dan Penampungan
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jarak_sumber_air" value='{{$bangunan['jarak_sumber_air']}}' name="jarak_sumber_air" required placeholder="Jarak Sumber Air Minum dan Penampungan">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Sumber Air Untuk Minum
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_sumber_air_minum" value='{{$bangunan['jenis_sumber_air_minum']}}' name="jenis_sumber_air_minum" required placeholder="Jenis Sumber Air Untuk Minum">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Jenis Sumber Air Untuk Kebutuhan Rumah Tangga
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="jenis_sumber_air_keluarga" value='{{$bangunan['jenis_sumber_air_keluarga']}}' name="jenis_sumber_air_keluarga" required placeholder="Jenis Sumber Air Untuk Kebutuhan Rumah Tangga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Akses Spald
                                <span class="required" aria-required="true"> * </span>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="akses_spald" value='{{$bangunan['akses_spald']}}' name="akses_spald" required placeholder="Jenis Sumber Air Untuk Kebutuhan Rumah Tangga">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                BABS
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control" @if($bangunan['babs']) checked @endif id="babs" name="babs" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Cubluk/Lubang Tanah
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" class="form-control" @if($bangunan['lubang_tanah']) checked @endif id="lubang_tanah" name="lubang_tanah" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-icon right">
                            <label class="col-md-3 control-label">
                                Fasilitas Umum
                            </label>
                        </div>
                        <div class="col-md-1">
                            <input type="checkbox" @if($bangunan['fasilitas_umum']) checked @endif class="form-control" id="fasilitas_umum" name="fasilitas_umum" >
                        </div>
                    </div>
                <div class="form-actions">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-offset-3 col-md-8">
                            <input type="hidden" class="form-control" id="id_user_address" value="{{$bangunan['id_user_address']}}" name="id_user_address" >
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
        </div>            </form>
</div>