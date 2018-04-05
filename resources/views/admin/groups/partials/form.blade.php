 
                        <div class="form-group">
                            {{ Form::label('name', 'Nombre de la etiqueta') }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('slug', 'URL Amigable') }}
                            {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Descripción') }}
                            {{ Form::textarea('description', null, ['class' => 'form-control','rows'=>'3']) }}
                        </div>

                        <!-- =================================== -->      
                        <hr>                       
                            <div class="form-group">                     
                                <label style="padding-left:10px">{{ Form::radio('special', 'all-access') }} Acceso total</label>
                                <label>{{ Form::radio('special', 'no-access') }} Ningún acceso</label>

                            </div> 
                         <hr>     
                        <!-- =================================== -->  
                            <div class="form-group">  
                                                  
                                <div class="table-responsive">
                                    <table  class="table dataTable no-footer dtr-inline">
                                        <thead>
                                            <tr class="filters">                    
                                                <th colspan="2">Lista de Permisos</th>                     
                                            </tr>
                                        </thead>
                                        <tbody id="IdShowPlazasAlta">
                                             @foreach($permissions as $permission)    
                                                    <tr> 
                                                        <td>
                                                         {!! Form::checkbox('permissions[]', $permission->id, null) !!}  
                                                   
                                                        </td>
                                                        <td>
                                                            {{ $permission->name }}<em>({{ $permission->description }})</em>
                                                       </td>
                                                    </tr>                                             
                                            @endforeach 
                                           
                                                  
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        <!-- =================================== -->                          
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('admin.groups.index') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>

                            </div>
                        </div>