<div class="container mt-5">
    @include('livewire.form')
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{__('Manage Employees')}}</h3>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#employeeFormModal">
                        {{__('Add New Employee')}}
                    </button>
                </div>
                <div class="card-body">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-3">
                        <div class="col form-inline">
                            Show
                            <select wire:model.live.debounce.200ms="perPage" id="perPage"
                                    class="form-control form-control-sm custom-select custom-select-sm mx-2">
                                <option>5</option>
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            Entries
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" wire:model.live.debounce.350ms="search"
                                   placeholder="Search employees...">
                        </div>
                    </div>

                    <table class="table table-striped">
                        <thead>
                        @php
                            $columns = [
                                'id' => 'ID',
                                'avatar' => 'Avatar',
                                'first_name' => 'Name',
                                'email' => 'Email',
                                'post' => 'Post',
                                'phone' => 'Phone',

                            ];
                        @endphp

                        @foreach ($columns as $field => $label)
                            <th wire:click="sortBy('{{ $field }}')" style="cursor: pointer;">
                                {{ $label }}
                                @if ($sortField == $field)
                                    @if ($sortDirection == 'asc')
                                        &uarr;
                                @else
                                    &darr;
                                @endif
                                @endif
                            </th>
                        @endforeach
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                        @if(count($employees) < 1)
                            <tr>
                                <td colspan="10" class="text-center pa-2 text-muted">{{__('No data')}}</td>
                            </tr>
                        @else
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="align-middle">{{$employee->id}}</td>
                                    <td class="align-middle">
                                        <img style="width: 50px; height: 50px; background-color: white; padding: 5px"
                                             class="avatar rounded-circle p-1" src="{{$employee->avatar}}">
                                    </td>
                                    <td class="align-middle">{{$employee->name}}</td>
                                    <td class="align-middle">{{$employee->email}}</td>
                                    <td class="align-middle">{{$employee->post}}</td>
                                    <td class="align-middle">{{$employee->phone}}</td>
                                    <td class="align-middle">
                                        <button type="button" wire:click="editEmployee({{$employee->id}})"
                                                data-toggle="modal" data-target="#employeeFormModal"
                                                class="btn btn-success" title="Edit"><i class="fa fa-edit"></i></button>
                                        <button type="button" wire:click="deleteConfirm({{$employee->id}})" class="btn btn-danger" title="Delete"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $employees->links()  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('close-modal', event => {
            $('#employeeFormModal').modal('hide');
        })
        window.addEventListener('swal:confirm',event => {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this.",
                icon: 'info',
                buttons: true,
                dangerMode: true,
            }).then((willDelete)=>{
                if (willDelete){
                    Livewire.dispatch('delete',{id:event.detail[0].id})
                }

            })
        })
    </script>
@endpush
