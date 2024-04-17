<?php

namespace App\Http\Livewire;

use GuzzleHttp\Utils;
use App\Models\Course;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\Curricula;
use App\Models\UserPetition;
use GuzzleHttp\Psr7\Request;
use App\Models\AreaKnowledge;
use App\Models\Configuration;
use Livewire\WithFileUploads;

use Psy\Exception\BreakException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\MakePetitionService;
use Carbon\Carbon;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class MakePetition extends Component
{
    use WithFileUploads;
    public UserPetition $userPetition;
    public $showImagePetition = false;
    public $pdfRecord;
    public $excelRecord;
    public $dataExcel;
    public $notas;
    public Collection $objectExcel;
    public $resultDataExcel = [];
    public $imagenShowModal = '';
    public Collection $areas;
    public $showFile = '';
    public $curriculaPetitions = [];
    public $nameUpload;
    public $curricula_id = '';
    public $option;
    public $backup = [];
    public $sumCredits = [];
    private MakePetitionService $makePetitionService;
    public $courseIdMove;
    public $curricula;
    public $totalCreditsForAreaCurrentCurricula;
    public $totalCreditsForAreaExcel;
    public $totalComparationBackupAndExcel;
    public $total_credits_obligated = 0;
    public $total_credits_excel = 0;
    public $missingCoursesPair = [];
    public $missingCoursesOdd = [];
    public $sumPairCourseCredits;
    public $sumOddCourseCredits;
    public $articles = [];
    public $meetsRequirements;
    public $approve = false;

    public $modalRejectRequest=false;
    // public $tasks = [];
    protected function rules()
    {
        return [
            'userPetition.code_petition' => 'required',
            'userPetition.subject' => 'required',
            'userPetition.observations' => 'required',
            'userPetition.record_pdf_path' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'excelRecord.required' => 'El Archivo excel es obligatorio.',
            'excelRecord.mimes' => 'El Archivo debe ser un archivo con formato xlsx',
            'excelRecord.max' => 'El Archivo no debe superar los 2MB.',

        ];
    }
    public function updatingExcelRecord($value)
    {
        $this->resetValidation('excelRecord');
    }
    public function updatedSelectedFormat($value)
    {
        if ($value === 'excel') {
            $this->showFile = 'excel';
        } elseif ($value === 'pdf') {
            $this->showFile = 'pdf';
        }
    }

    public function mount(UserPetition $petition, MakePetitionService $makePetitionService)
    {
        $this->showFile='';
        $this->userPetition = $petition->load(['petition', 'user_petition', 'user_processor']);
       
        $this->makePetitionService = $makePetitionService;
        $this->curriculaPetitions = Curricula::query()
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->get();

        $this->option = Curricula::query()
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->where('state', 1) // Agregar una condición para currículas activas
            ->first();

        // $this->configuration = Configuration::where('faculty_id', Auth::user()->faculty_id)
        //     ->where('department_id', Auth::user()->department_id)
        //     ->first();


        $this->curricula = $this->option;
        $this->curricula_id = $this->option->id;
        //  for ($i = 1; $i <= 5; $i++) {
        //     $this->tasks[] = [
        //         'id' => $i,
        //         'title' => 'Tarea ' . $i
        //     ];
        // }
         if($this->userPetition->agreement_number){
            $this->objectExcel=collect($this->userPetition->excel_record);
            $this->backup=$this->userPetition->backup;
            $this->articles= $this->userPetition->articles;
            $this->approve=true;
            $this->showFile='excel';
            $this->totalCreditsForAreaCurrentCurricula = $this->makePetitionService->getCreditsArea($this->curricula_id, $this->curricula);
        $this->total_credits_obligated = array_sum(array_column($this->totalCreditsForAreaCurrentCurricula, 'total_credits'));


        $this->totalCreditsForAreaExcel = $this->makePetitionService->getCreditsExcel($this->backup);
        $this->sumCredits = $this->makePetitionService->sumRecord($this->backup, $this->curricula_id);

        $this->totalCreditsForAreaCurrentCurricula =  $this->makePetitionService->getResultComparationExcelBackup($this->totalCreditsForAreaExcel, $this->totalCreditsForAreaCurrentCurricula);

        $this->total_credits_excel = array_sum(array_column($this->totalCreditsForAreaCurrentCurricula, 'total_credits_excel'));

        $this->missingCoursesPair = $this->makePetitionService->compareToCourseToExcelWithDatabaseToPair($this->backup, $this->curricula_id);
        $this->sumPairCourseCredits = $this->makePetitionService->sumPairCourseCredits($this->missingCoursesPair);
        $this->missingCoursesOdd = $this->makePetitionService->compareToCourseToExcelWithDatabaseToOdd($this->backup, $this->curricula_id);
        $this->sumOddCourseCredits = $this->makePetitionService->sumOddCourseCredits($this->missingCoursesOdd);
            
        } if(!isset($this->userPetition->agreement_number) &&$this->userPetition->state_petition==4 ){
           
            $this->approve=true;
        
            
        }
    }
    public function indexEnterAndSpace($index)
    {
        $this->curricula_id =  $this->curriculaPetitions[$index]['id'];
    }
    public function curriculaSelect($curricula)
    {

        $this->curricula_id = $curricula['id'];
        $this->curricula = $curricula;
    }
    public function updatedExcelRecord($value)
    {
        $validatedData = $this->validate(
            [
                'excelRecord' => 'required|mimes:xlsx|max:2048', // Ejemplo de regla 'max' para un archivo de hasta 2MB
            ],
        );
        $this->nameUpload = $this->excelRecord->getClientOriginalName();
        $this->uploadExcel();
    }
    public function boot(MakePetitionService $makePetitionService)
    {

        $this->makePetitionService = $makePetitionService;
    }
    public function showImagePetitionModal()
    {
        $this->imagenShowModal = $this->userPetition->petition_imagen_path;
        $this->showImagePetition = true;
    }
    public function showImageVoucherModal()
    {
        $this->imagenShowModal = $this->userPetition->voucher_imagen_path;
        $this->showImagePetition = true;
    }
    public function downloadImagePetition()
    {
        return Storage::disk('public')->download(str_replace('storage/', '', $this->imagenShowModal));
    }
    // public function save()
    // {
    //    $this->generarDocumentoWord(); 
    // }
    public function uploadPdf()
    {
        if ($this->pdf) {
            $client = new Client();

            $options = [
                'multipart' => [
                    [
                        'name' => 'pdfFile',
                        'contents' => fopen($this->pdf->getRealPath(), 'r'),
                        'filename' => $this->pdf->getClientOriginalName(),
                        'headers'  => [
                            'Content-Type' => $this->pdf->getClientMimeType(),
                        ],
                    ],
                ],
            ];

            $request = new Request('POST', 'https://pdfapi-a7a4.onrender.com/record');

            try {
                $response = $client->send($request, $options);
                $responseData = json_decode($response->getBody()->getContents(), true);

                $this->notas = $responseData;
                // Manejar la respuesta si es necesario
            } catch (\Exception $e) {
                // Manejar el error si la solicitud falla
            }
        }
    }
    public function uploadExcel()
    {
        if(!isset($this->userPetition->excel_record))
    {
 $this->validate([
            'excelRecord' => 'required|mimes:xlsx,csv',
            'curricula_id' => 'required',
        ]);
        $this->reset(['resultDataExcel', 'dataExcel', 'backup','articles']);
        $this->dataExcel = Excel::toArray([], $this->excelRecord);
        $this->objectExcel  = collect($this->makePetitionService->uploadExcel($this->dataExcel));
        $groupedCoursesByArea = $this->makePetitionService->processDataFile($this->objectExcel, $this->curricula_id);

        $this->resultDataExcel = $groupedCoursesByArea;
    }
    else{
        $this->objectExcel  = collect($this->userPetition->excel_record);
        $this->reset(['resultDataExcel', 'dataExcel', 'backup','articles']);
        $groupedCoursesByArea = $this->makePetitionService->processDataFile($this->objectExcel, $this->curricula_id);

        $this->resultDataExcel = $groupedCoursesByArea;
    }

       
    }

    public function justOneCourseForArea(): array
    {
        $this->meetsRequirements='';
        $this->articles=[];
        $this->totalCreditsForAreaCurrentCurricula = $this->makePetitionService->getCreditsArea($this->curricula_id, $this->curricula);
        $this->total_credits_obligated = array_sum(array_column($this->totalCreditsForAreaCurrentCurricula, 'total_credits'));

        $this->backup = $this->makePetitionService->justOneCourseForArea($this->resultDataExcel);

        $this->totalCreditsForAreaExcel = $this->makePetitionService->getCreditsExcel($this->backup);
        $this->sumCredits = $this->makePetitionService->sumRecord($this->backup, $this->curricula_id);

        $this->totalCreditsForAreaCurrentCurricula =  $this->makePetitionService->getResultComparationExcelBackup($this->totalCreditsForAreaExcel, $this->totalCreditsForAreaCurrentCurricula);

        $this->total_credits_excel = array_sum(array_column($this->totalCreditsForAreaCurrentCurricula, 'total_credits_excel'));

        $this->missingCoursesPair = $this->makePetitionService->compareToCourseToExcelWithDatabaseToPair($this->backup, $this->curricula_id);
        $this->sumPairCourseCredits = $this->makePetitionService->sumPairCourseCredits($this->missingCoursesPair);
        $this->missingCoursesOdd = $this->makePetitionService->compareToCourseToExcelWithDatabaseToOdd($this->backup, $this->curricula_id);
        $this->sumOddCourseCredits = $this->makePetitionService->sumOddCourseCredits($this->missingCoursesOdd);
        return $this->backup;
    }
    public function processRequestMeet()
    {
        $this->articles = [];
        $this->articles = $this->makePetitionService->processRequestMeet($this->meetsRequirements, $this->userPetition,$this->total_credits_excel);
    }
    public function updateOrder($list)
    {
        $courseIdToFind = $this->courseIdMove;
        $this->backup = $this->makePetitionService->dragAndDropTableCorse($list, $this->backup, $courseIdToFind);
    }

    public function handleDrop($e)
    {

        $this->courseIdMove = $e;
    }
    //    public function generarDocumentoWord()
    // {
    //     // Crea una instancia de PhpWord
    //     $phpWord = new PhpWord();
    //      $configuration= Configuration::where('faculty_id', Auth::user()->faculty_id)
    //             ->where('department_id', Auth::user()->department_id)
    //             ->first();

    //     // Crea una sección en el documento
    //     $section = $phpWord->addSection();
    //     $header = $section->addHeader();
    //     // Define el estilo de la tabla
    //     $tableStyle = [
    //         'borderSize' => 6,
    //         'borderColor' => '000000',
    //         'cellMargin' => 50,
    //     ];
    //     // // Agrega la imagen a la izquierda
    //     // $header->addImage(public_path($configuration->imageLeft), [
    //     //     'width' => 80,
    //     //     'height' => 80,
    //     //     'alignment' => 'left',
    //     // ]);

    //     // // Agrega el título en el centro
    //     // $header->addText('Título del Documentoas dfsdf asdf sdf asdf sadf', [
    //     //     'bold' => true,
    //     //     'alignment' => 'center',
    //     // ]);

    //     // // Agrega la imagen a la derecha
    //     // $header->addImage(public_path($configuration->imageRight), [
    //     //      'width' => 80,
    //     //     'height' => 80,
    //     //     'alignment' => 'right',
    //     //     'marginLeft' => 80,
    //     // ]);
    //     $table = $header->addTable($tableStyle);

    //     // Agrega celdas a la tabla
    //     $cell1 = $table->addCell(50);
    //     $cell1->addText('Celda 1');

    //     $cell2 = $table->addCell(50);
    //     $cell2->addText('Celda 2');
    //     // Guarda el documento en un archivo
    //     $filename = public_path('documento_word.docx');
    //     $phpWord->save($filename);

    //     return response()->download($filename, 'documento_word.docx');
    // }



    public function save()
    {
       
        if (empty($this->articles)) {
            return  $this->notify('por favor complete el formulario!');
        }
        $this->userPetition->articles=$this->articles;
        $this->userPetition->excel_record=$this->objectExcel;
        $this->userPetition->backup=$this->backup;
        $filename = $this->makePetitionService->generarDocumentoWord($this->userPetition, $this->missingCoursesPair, $this->sumPairCourseCredits, $this->missingCoursesOdd, $this->sumOddCourseCredits, $this->backup, $this->articles,$this->total_credits_excel,$this->totalCreditsForAreaCurrentCurricula);
        $response = response()->download($filename['filepath'], $filename['filename']);
        register_shutdown_function('unlink', $filename['filepath']);
         $this->notify('proceso realizado con correctamente!');
        return $response;
    }
    public function back(){
        
        return redirect()->route('petition_process_list');
    }
    public function showRejectModal()
    {
        $this->modalRejectRequest=true;
    }
    public function rejectRequest()
    {
        $this->userPetition->processing_status =4;
        $this->userPetition->state_petition =5;
        $this->userPetition->save();
        return redirect()->route('petition_process_list');
    }
    public function ApproveRequest()
    {
        $this->userPetition->state_petition=4;
        $this->userPetition->save();
        $this->approve=true;
        $this->notify('Solicitud Aprobada');
    }
    public function render(): object
    {
        return view('livewire.make-petition', [
            'userPetition' => $this->userPetition
        ]);
    }
}
