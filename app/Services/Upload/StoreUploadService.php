<?php

namespace App\Services\Upload;

use Maatwebsite\Excel\Excel;
use App\Imports\VoucherImport;
use Illuminate\Http\UploadedFile;
use PerfectOblivion\Services\Traits\SelfCallingService;
use App\Services\Upload\Validation\StoreUploadValidation;

class StoreUploadService
{
    use SelfCallingService;

    /** @var \App\Services\Upload\StoreUploadValidation */
    private $validator;

    /** @var \App\Imports\VouchersImport */
    private $importer;

    /**
     * Construct a new StoreUploadService.
     *
     * @param  \App\Services\Upload\StoreUploadValidation  $validator
     * @param  \App\Imports\VoucherImport  $importer
     */
    public function __construct(StoreUploadValidation $validator, VoucherImport $importer)
    {
        $this->validator = $validator;
        $this->importer = $importer;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run(UploadedFile $sheet)
    {
        $this->validator->validate(array_key($sheet, 'upload'));

        return $this->importer->import($sheet, 'local', Excel::XLSX);
    }
}
