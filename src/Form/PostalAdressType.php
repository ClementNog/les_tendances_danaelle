<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
class PostalAddressType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'help' => 'Street address, P.O. box, company name',
            ])
            ->add('number', TextType::class, [
                'help' => 'Apartment, suite, unit, building, floor',
            ])
            ->add('city', TextType::class)
            ->add('zipCode', TextType::class, [
                'label' => 'ZIP Code',
            ])
        ;
    }
}
?>