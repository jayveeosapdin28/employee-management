<div wire:ignore.self class="modal fade" id="employeeFormModal" tabindex="-1" role="dialog"
     aria-labelledby="employeeFormModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form wire:submit.prevent="storeEmployee">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"> @if($form['id'])
                            {{__('Update')}}
                        @else
                            {{__(' Add New')}}
                        @endif  {{__('Employee')}} </h5>
                    <button wire:click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col form-group">
                            <label for="first_name">First Name</label>
                            <input wire:model="form.first_name" placeholder="First Name" type="text"
                                   class="form-control" id="first_name"/>
                            @error('form.first_name')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col form-group">
                            <label for="last_name">Last Name</label>
                            <input wire:model="form.last_name" placeholder="Last Name" type="text"
                                   class="form-control" id="last_name"/>
                            @error('form.last_name')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input wire:model="form.email" placeholder="Email" type="email" class="form-control"
                               id="email"/>
                        @error('form.email')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input wire:model="form.phone" placeholder="Phone" type="text" class="form-control"
                               id="phone"/>
                        @error('form.phone')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="post">Post</label>
                        <select wire:model="form.post" class="form-control" id="post">
                            <option style="display: none" class="text-muted" value="">Select Post</option>
                            @foreach($posts as $post)
                                <option value="{{$post}}">{{$post}}</option>
                            @endforeach
                        </select>
                        @error('form.post')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input wire:model="form.avatar" type="file" class="form-control" id="avatar"/>
                        @error('form.avatar')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        @if($form['avatar'])
                           <div class="mt-3">
                               <img width="100" height="100" style="object-fit: cover" src="{{$form['avatar']->temporaryUrl()}}" >
                           </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal" data-dismiss="modal">Close
                    </button>
                    @if($form['id'])
                        <button type="button" wire:click="updateEmployee({{$form['id']}})" class="btn btn-primary">{{__('Update Employee')}}</button>
                    @else
                        <button type="submit" class="btn btn-primary">{{__('Add Employee')}}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
