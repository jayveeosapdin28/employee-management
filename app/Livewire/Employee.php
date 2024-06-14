<?php

namespace App\Livewire;

use App\Enums\Post;
use App\Models\Employee as EmployeeList;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Employee as EmployeeModel;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

#[Layout('layouts.app')]
class Employee extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete'];
    public $posts = [];
    public $form = [
        'id' => null,
        'first_name' => null,
        'last_name' => null,
        'email' => null,
        'post' => null,
        'phone' => null,
        'avatar' => null,
    ];
    public $search;
    public $perPage = 5;
    public $sortField = 'id';
    public $sortDirection = 'asc';
    protected $updatesQueryString = ['page', 'perPage', 'sortField', 'sortDirection'];

    public function mount()
    {
        $this->posts = Post::values();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetField()
    {
        $this->reset();
        $this->dispatch('close-modal');
    }



    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'form.first_name' => 'required|string|max:255',
            'form.last_name' => 'required|string|max:255',
            'form.email' => 'required|email|max:255',
            'form.post' => 'required|string|max:255',
            'form.phone' => 'required|string|max:20',
            'form.avatar' => 'nullable|image|max:1024',
        ], [], $this->attributes());
    }


    protected function validateForm()
    {
        $this->validate([
            'form.first_name' => 'required|string|max:255',
            'form.last_name' => 'required|string|max:255',
            'form.email' => 'required|email|max:255',
            'form.post' => 'required|string|max:255',
            'form.phone' => 'required|string|max:20',
            'form.avatar' => 'nullable|image|max:1024',
        ], [], $this->attributes());
    }

    protected function attributes()
    {
        return [
            'form.first_name' => 'first name',
            'form.last_name' => 'last name',
            'form.email' => 'email',
            'form.post' => 'post',
            'form.phone' => 'phone',
            'form.avatar' => 'avatar',
        ];
    }

    public function closeModal()
    {
        $this->resetField();
    }

    public function storeEmployee()
    {
        $this->validateForm();

        if ($this->form['avatar']) {
            $avatarPath = $this->form['avatar']->store('avatar', 'public');
            $this->form['avatar'] = $avatarPath;
        }

        EmployeeModel::create($this->form);
        $this->resetField();
        session()->flash('message', 'Employee created successfully.');
    }

    public function editEmployee($id)
    {
        $this->form = EmployeeModel::findAndExtract($id);
    }

    public function updateEmployee($id)
    {
        $employee = EmployeeModel::find($id);
        $employee->update($this->form);
        $this->resetField();
        session()->flash('message', 'Employee updated successfully.');
    }

    public function deleteConfirm($id){
        $this->dispatch('swal:confirm',['id' => $id]);
    }
    public function delete($id){
        EmployeeModel::find($id)->delete();
        session()->flash('message', 'Employee deleted successfully.');
    }
    public function render()
    {
        $employees = EmployeeList::query()
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.employee', [
            'employees' => $employees,
        ]);
    }
}
