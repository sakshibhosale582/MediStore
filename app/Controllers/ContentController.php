<?php

namespace App\Controllers;

use App\Models\BannerModel;
use App\Models\FaqModel;
use App\Models\OfferModel;

class ContentController extends BaseController
{
    public function faq(): string
    {
        $faqModel = model(FaqModel::class);

        return view('content/faq', [
            'pageTitle' => 'FAQs | MediStore',
            'faqs' => $faqModel->getActive(),
        ]);
    }

    public function offers(): string
    {
        $offerModel = model(OfferModel::class);

        return view('content/offers', [
            'pageTitle' => 'Offers | MediStore',
            'offers' => $offerModel->getActive(),
        ]);
    }

    public function contact(): string
    {
        return view('content/contact', ['pageTitle' => 'Contact Us | MediStore']);
    }

    public function submitContact()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $email = trim($this->request->getPost('email') ?? '');
        $message = trim($this->request->getPost('message') ?? '');

        if ($name === '' || $email === '' || $message === '') {
            return redirect()->back()->withInput()->with('error', 'Please complete all fields.');
        }

        $contactModel = model('ContactQueryModel');
        $contactModel->insert([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Your message has been sent.');
    }

    public function about(): string
    {
        return view('content/about', ['pageTitle' => 'About Us | MediStore']);
    }
}
