<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Annotation\Route;

class AbstractBaseController extends AbstractController
{
    public function getFormsErrors(FormInterface $form): array
    {
        $errors = [];
        $formErrors = $form->getErrors(true);

        foreach ($formErrors as $error) {
            $field = $error->getOrigin()->getName();
            $message = $error->getMessage();

            $errors[$field] = $message;
        }

        return $errors;
    }
}
