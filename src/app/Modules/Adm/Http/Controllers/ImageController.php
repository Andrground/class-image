<?php

namespace App\Modules\Adm\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /** @var  $imageService */
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        
    }

    /**
     * Upload da Imagem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('adm::image');
    }

    /**
     * Adiciona a Imagem
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return $this->imageService->imageCreate($request);
    }
}