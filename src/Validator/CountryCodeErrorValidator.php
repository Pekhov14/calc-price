<?php

namespace App\Validator;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CountryCodeErrorValidator extends ConstraintValidator
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match('/^[a-zA-Z]{2}\d+$/', $value)) {
            $this->context->buildViolation('Поле должно содержать TAX номер, формата GRXXXXXXXXX где первые два символа - это код страны, а X - это любая цифра от 0 до 9')->addViolation();
            return;
        }

        $repository = $this->em->getRepository(Country::class);

        $tax = $repository->findTaxByCode($value);

        if (empty($tax)) {
            $this->context
                    ->buildViolation($constraint->message)
                    ->addViolation();
        }
    }
}