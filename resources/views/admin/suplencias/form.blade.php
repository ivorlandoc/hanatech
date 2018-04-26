           
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Fecha:</strong>
                        {!! Form::date('Fecha', null, array('placeholder' => 'Fecha','class' => 'form-control','id' => 'datetime1')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Descripción:</strong>
                        {!! Form::textarea('Descripcion', null, array('placeholder' => 'Descripción','class' => 'form-control','style'=>'height:100px')) !!}
                    </div>
                </div>

                 <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Estado:</strong>
                        {!! Form::select('Estado', ['1'=>'Activo','0'=>'Inactivo'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                 

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>

             <!-- ========================== -->            