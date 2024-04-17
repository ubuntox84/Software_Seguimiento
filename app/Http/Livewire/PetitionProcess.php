<?php

namespace App\Http\Livewire;

use App\Models\UserPetition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Json;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PetitionProcess extends Component
{
    use WithPagination;
    public $showPetition = false;
    public $detailPetition = '';
    public $modalCancelRequest = false;
    public $perPage = 10;
    public $filters = [
        'search' => '',
        'state' => '',
        'process' => '',
    ];
    public $showFilters = false;
    public  $user_petition;

    public function toggleShowFilters()
    {
        $this->showFilters = !$this->showFilters;
    }
    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function show($id)
    {

        $this->detailPetition = UserPetition::with('petition')
            ->with('user_petition')
            ->with('user_processor')
            ->findOrFail($id);
        $this->showPetition = true;
    }
    public function downloadImagePetition($petition)
    {
        // dd($name['voucher_imagen_path']);
        return Storage::disk('public')->download(str_replace('storage/', '', $petition['petition_imagen_path']));
    }
    public function downloadImageVoucher($petition)
    {
        // dd($name['voucher_imagen_path']);
        return Storage::disk('public')->download(str_replace('storage/', '', $petition['voucher_imagen_path']));
    }
    public function processorPetition(UserPetition $petition)
    {
        $petition = UserPetition::with('user_processor')->findOrFail($petition->id);

        if ($petition->user_processor_id) {
            if ($petition->user_processor_id == Auth::user()->id) {
                if (isset($petition->agreement_number)) {
                    if ($petition->state_petition != 6) {
                        $petition->state_petition = 3;
                        $petition->processing_status = 3;
                        $petition->processing_date = Carbon::now();
                        $petition->save();
                        return redirect()->route('petition_process_make', ['petition' => $petition]);
                    } else {

                        return redirect()->route('petition_process_make', ['petition' => $petition]);
                    }
                } elseif ($petition->state_petition == 4) {
                    return redirect()->route('petition_process_make', ['petition' => $petition]);
                } else {
                    return redirect()->route('petition_process_make', ['petition' => $petition]);
                }
            } else {
                return $this->notify('Esta solicitud esta siendo procesada por ' . $petition->user_processor->name . ' ' . $petition->user_processor->surname);
            }
        } else {
            $petition->user_processor_id = Auth::user()->id;
            $petition->state_petition = 3;
            $petition->processing_status = 3;
            $petition->processing_date = Carbon::now();
            $petition->save();
            return redirect()->route('petition_process_make', ['petition' => $petition]);
        }
    }
    public function showRejectModal($id)
    {
        $this->user_petition = $id;
        $this->modalCancelRequest = true;
    }
    public function rejectCancel()
    {
        $user_petition = UserPetition::findOrFail($this->user_petition);
        $user_petition->processing_status = 4;
        $user_petition->state_petition = 7;
        $user_petition->update();

        $this->modalCancelRequest = false;
        return $this->notify('Solicitud cancelada');
    }
    public function render()
    {
        return view('livewire.petition-process', [
            'petitionProcess' => UserPetition::query()
                ->when($this->filters['search'], function ($query, $search) {
                    return $query->where('code_petition', 'like', '%' . $search . '%')
                        ->orWhereHas('user_petition', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        })
                        ->orWhereHas('user_petition', function ($query) {
                            $query->where('surname', 'like', '%' . $this->filters['search'] . '%');
                        })
                        ->orWhereHas('user_petition', function ($query) {
                            $query->where('code', 'like', '%' . $this->filters['search'] . '%');
                        })
                        ->orWhereHas('petition', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        })
                        ->orWhereHas('petition', function ($query) {
                            $query->where('agreement_number', $this->filters['search']);
                        })
                        ->orWhereHas('user_processor', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        });
                })
                ->when($this->filters['state'], function ($query) {
                    return $query->where('state_petition', $this->filters['state']);
                })
                ->when($this->filters['process'], function ($query) {
                    return $query->where('processing_status', $this->filters['process']);
                })

                ->whereHas('user_petition', function ($query) {
                    $query->where('faculty_id', Auth::user()->faculty_id)
                        ->where('department_id', Auth::user()->department_id);
                })
                ->latest()
                ->paginate($this->perPage)
        ]);
    }
}
