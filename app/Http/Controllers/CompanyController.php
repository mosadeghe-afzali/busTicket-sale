<?php

namespace App\Http\Controllers;

use App\Traits\Response;
use App\repositories\CommentRepository;
use App\repositories\CompanyRepository;
use Illuminate\Http\Response as HTTPResponse;

class CompanyController extends Controller
{
    use Response;

    public $companyRepository;
    public $commentRepository;

    /* injection of CompanyRepository and CommentRepository dependencies to this class: */
    public function __construct(CompanyRepository $companyRepository, CommentRepository $commentRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->commentRepository = $commentRepository;
    }

    /* display list of companies in database*/
    public function list()
    {
        $companies = $this->companyRepository->list();

        return $this->getMessage(
            'لیست شرکت ها با موفقیت بازبابی شد.',
            HTTPResponse::HTTP_OK,
            $companies,
        );
    }

    /* display comments of companies about site*/
    public function getComments()
    {
        $comments = $this->commentRepository->getComment();

        return $this->getMessage(
            'لیست کامنت ها با موفقیت بازبابی شد.',
            HTTPResponse::HTTP_OK,
            $comments,

        );
    }

    public function info()
    {
        $info = $this->companyRepository->info();

        return $this->getMessage(
            'اطلاعات شرکت با موفقیت بازبابی شد.',
            HTTPResponse::HTTP_OK,
            $info,
        );
    }
}
