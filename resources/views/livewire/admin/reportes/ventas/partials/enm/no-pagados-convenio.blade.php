  <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <td></td>
                            <td>ID</td>
                            <td>Cupon</td>
                            <td>Actividad</td>
                            <td>Cliente</td>
                            <td>Agencia</td>
                            <td>Motivo</td>
                        </tr>
                       
                    </thead>
                    <tbody>
                        @foreach ($corte->ENMNoPagadosConvenio() as $enm)
                            <tr>
                                 <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $enm->idRP }}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $enm->idRP }}">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $enm->IdReserva }})">Ver
                                                    reserva</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                               <td>{{ $enm->idRP }}</td>
                                <td>{{ $enm->CuponDisplay }}</td>
                                <td><i class="{{ $enm->Icon }} me-2"></i>{{ $enm->NombreActividad }}
                                    <br>
                                    <small class="text-muted">{{ $enm->FechaServicio }}</small>
                                </td>
                                <td>{{ $enm->ClienteNombre }}</td>
                                <td>{{ $enm->AgenciaNombre }}</td>                             
                                <td>{{ $enm->motivo }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>