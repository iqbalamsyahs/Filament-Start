<?php

namespace App\Livewire;

use App\Models\AcademicYear;
use Filament\Forms;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class AcademicYearFilter extends Component implements HasForms
{
    use InteractsWithForms;

    public $academicYear = '';

    public function mount(): void
    {
        $defaultYear = AcademicYear::where('status', 'active')->value('academic_year_name');

        $this->academicYear = session('academicYear', $defaultYear);
        $this->form->fill(['academicYear' => $this->academicYear]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('academicYear')
                ->label(false)
                ->placeholder('Academic Year')
                ->options(
                    AcademicYear::orderByDesc('start_date')->pluck('academic_year_name', 'academic_year_name')
                )
                ->live()
                ->afterStateUpdated(fn ($state) => $this->updateAcademicYear($state)),
        ];
    }

    public function updateAcademicYear($year): void
    {
        // dd('Method updateAcademicYear dipanggil dengan nilai:', $year);
        session(['academicYear' => $year]);
        $this->academicYear = $year;
        // $this->dispatchBrowserEvent('academic-year-updated');
        $this->redirect(request()->header('Referer'));
    }

    public function render(): View
    {
        return view('livewire.academic-year-filter');
    }
}

